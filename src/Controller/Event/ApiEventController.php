<?php

namespace App\Controller\Event;

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
    #[Route('admin/evenement', name: 'app_api_event')]
    public function index(Request $request,EventFluxRssRepository $eventFluxRssRepository,ApiEventRepository $apiEventRepository,EntityManagerInterface $em): Response
    {
        $eventFluxRss = $eventFluxRssRepository->findOneBy([],['id'=>'desc']);

        if(!isset($eventFluxRss)){
            $eventFluxRss = new EventFluxRss();
        }

        $form = $this->createForm(ApiFluxRssType::class, $eventFluxRss);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $eventFluxRssRepository->save($eventFluxRss, true);
            return $this->redirectToRoute('app_api_event', [], Response::HTTP_SEE_OTHER);
        }


        return $this->render('api_event/index.html.twig', [
            'eventFluxRss' => $eventFluxRss,
            'form' => $form,
        ]);
    }
}
