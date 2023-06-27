<?php

namespace App\Controller\Podcast;

use App\Entity\ApiPodcast;
use App\Form\ApiPodcastType;
use App\Repository\ApiPodcastRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller création podcast
 */

#[Route('/podcast')]
class ApiPodcastCreateController extends AbstractController
{   
    #[Route('/new', name: 'app_api_podcast_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ApiPodcastRepository $apiPodcastRepository): Response
    {
        $apiPodcast = new ApiPodcast();
        $form = $this->createForm(ApiPodcastType::class, $apiPodcast);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $apiPodcastRepository->save($apiPodcast, true);

            return $this->redirectToRoute('app_api_podcast_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('api_podcast/new.html.twig', [
            'api_podcast' => $apiPodcast,
            'form' => $form,
        ]);
    }
}