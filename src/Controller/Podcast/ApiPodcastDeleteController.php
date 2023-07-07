<?php

namespace App\Controller\Podcast;

use App\Entity\ApiPodcast;
use App\Repository\ApiPodcastRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller suppresion podcast
 */

#[Route('/podcast')]
class ApiPodcastDeleteController extends AbstractController
{
    #[Route('/{id}', name: 'app_api_podcast_delete', methods: ['POST'])]
    public function delete(Request $request, ApiPodcast $apiPodcast, ApiPodcastRepository $apiPodcastRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$apiPodcast->getId(), $request->request->get('_token'))) {
            $apiPodcastRepository->remove($apiPodcast, true);
        }

        return $this->redirectToRoute('app_api_podcast_index', [], Response::HTTP_SEE_OTHER);
    }
}