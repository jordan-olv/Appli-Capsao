<?php

namespace App\Controller\Slider;

use App\Entity\Slider;
use App\Repository\SliderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Suppression d'événement dans le slider
 */

#[Route('/slider')]
class SliderDeleteController extends AbstractController
{
    #[Route('/{id}', name: 'app_slider_delete', methods: ['POST'])]
    public function delete(Request $request, Slider $slider, SliderRepository $sliderRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$slider->getId(), $request->request->get('_token'))) {
            $sliderRepository->remove($slider, true);
        }

        return $this->redirectToRoute('app_slider_index', [], Response::HTTP_SEE_OTHER);
    }
}
