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
 * Controller mise a jour podcast
 */

#[Route('/podcast')]
class ApiPodcastUpdateController extends AbstractController
{
    #[Route('/{id}/edit', name: 'app_api_podcast_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ApiPodcast $apiPodcast, ApiPodcastRepository $apiPodcastRepository): Response
    {
        $form = $this->createForm(ApiPodcastType::class, $apiPodcast);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $apiPodcastRepository->save($apiPodcast, true);

            return $this->redirectToRoute('app_api_podcast_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('api_podcast/edit.html.twig', [
            'api_podcast' => $apiPodcast,
            'form' => $form,
        ]);
    }
}