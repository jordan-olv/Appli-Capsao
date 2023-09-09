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

class SliderReadController extends AbstractController
{
    #[Route('/slider', name: 'app_slider_index', methods: ['GET'])]
    public function index(SliderRepository $sliderRepository,ApiEventRepository $apiEventRepository,EventFluxRssRepository $eventFluxRssRepository): Response
    {
        




        return $this->render('slider/index.html.twig', [
            'sliders' => $sliderRepository->findAll(),
        ]);
    }
}
