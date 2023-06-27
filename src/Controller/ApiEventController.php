<?php

namespace App\Controller;

use Exception;
use App\Entity\ApiEvent;
use App\Entity\EventFluxRss;
use App\Form\ApiFluxRssType;
use App\Repository\ApiEventRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\EventFluxRssRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Permet à la table api_event de ce mettre a jour a chaque fois que ce controller est activé
 */


class ApiEventController extends AbstractController
{
    #[Route('/apievent/{id}', name: 'app_api_event')]
    public function index(Request $request, EventFluxRss $eventFluxRss,EventFluxRssRepository $eventFluxRssRepository,ApiEventRepository $apiEventRepository,EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ApiFluxRssType::class, $eventFluxRss);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $eventFluxRssRepository->save($eventFluxRss, true);
        }

        // Truncate de la table api_event

        $RAW_QUERY = 'TRUNCATE TABLE api_event';
        
        $statement = $em->getConnection()->prepare($RAW_QUERY);
        $statement->execute();

        $em->flush();

        // récupération du flux rss venant de la base de donnée

        // $feeds = file_get_contents($eventFluxRss->getLink());

        // dd($feeds);


        try{
            $feeds = file_get_contents($eventFluxRss->getLink());
            echo 'ok';
            // rename de la balise <content:encoded> sinon on ne peut récupérer ce qu'elle contient
            $feeds = str_replace("<content:encoded>","<contentEncoded>",$feeds);
            $feeds = str_replace("</content:encoded>","</contentEncoded>",$feeds);
            $rss = simplexml_load_string($feeds, 'SimpleXMLElement', LIBXML_NOCDATA);
            $item = $rss->channel->item;

            foreach ($item as $key => $value) {

                // Ajout des infos provenant du flux rss dans la bdd

                ////////////////////////
                $apirss = new ApiEvent();

                $apirss->setTitle($value->title);
                $apirss->setDescription($value->description);
                $apirss->setPubDate($value->pubDate);
                $apirss->setLink($value->link);
                $apirss->setGuid($value->guid);
                $apirss->setUrlImg($value->enclosure->attributes()->url);
                $apirss->setContent($value->contentEncoded);
                ////////////////////////

                $apiEventRepository->save($apirss, true);

            }
        }catch (Exception $e) {
        echo 'Exception reçue : ',  $e->getMessage(), "\n";
    }



        return $this->render('api_event/index.html.twig', [
            'eventFluxRss' => $eventFluxRss,
            'form' => $form,
        ]);
    }
}
