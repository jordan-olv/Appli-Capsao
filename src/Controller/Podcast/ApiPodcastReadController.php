<?php

namespace App\Controller\Podcast;

use App\Repository\ApiPodcastRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller liste podcast
 */

#[Route('/podcast')]
class ApiPodcastReadController extends AbstractController
{
    #[Route('/', name: 'app_api_podcast_index', methods: ['GET'])]
    public function index(ApiPodcastRepository $apiPodcastRepository): Response
    {
        return $this->render('api_podcast/index.html.twig', [
            'api_podcasts' => $apiPodcastRepository->findAll(),
        ]);
    }
}