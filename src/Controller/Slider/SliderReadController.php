<?php

namespace App\Controller\Slider;

use Exception;
use App\Entity\ApiEvent;
use App\Repository\SliderRepository;
use App\Repository\ApiEventRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\EventFluxRssRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Read d'événement dans le slider
 */

#[Route('/slider')]
class SliderReadController extends AbstractController
{
    #[Route('/', name: 'app_slider_index', methods: ['GET'])]
    public function index(SliderRepository $sliderRepository,ApiEventRepository $apiEventRepository,EventFluxRssRepository $eventFluxRssRepository,EntityManagerInterface $em): Response
    {
        
        try{

            // récupération du flux rss venant de la base de donnée

            $fluxrss = $eventFluxRssRepository->findBy(array(),array('id'=>'DESC'),1,0);

            if(isset($fluxrss[0])){
                $fluxrss = $fluxrss[0];
                $feeds = file_get_contents('https://capsao.com/rss-feed-34');
    
    
    
                $RAW_QUERY = 'TRUNCATE TABLE api_event';
            
                $statement = $em->getConnection()->prepare($RAW_QUERY);
                $statement->execute();
    
    
                $em->flush();
    
                $apirss = new ApiEvent();
                $apirss->setTitle('--- Vide ---');
                $apirss->setDescription('empty data for slider select');
                $apirss->setPubDate('');
                $apirss->setLink('');
                $apirss->setGuid('');
                $apirss->setUrlImg('');
                $apirss->setContent('');
                $apiEventRepository->save($apirss, true);   
    
                
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
            }




            
        }catch (Exception $e) {
        echo 'Exception reçue : ',  $e->getMessage(), "\n";
        }

        return $this->render('slider/index.html.twig', [
            'sliders' => $sliderRepository->findAll(),
        ]);
    }
}
