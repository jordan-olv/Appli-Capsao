<?php

namespace App\Controller\Slider;

use App\Entity\Slider;
use App\Form\SliderType;
use App\Repository\SliderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Update d'événement dans le slider
 */

#[Route('/slider')]
class SliderUpdateController extends AbstractController
{
    #[Route('/{id}/edit', name: 'app_slider_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Slider $slider, SliderRepository $sliderRepository): Response
    {
        $form = $this->createForm(SliderType::class, $slider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //Récupération des data selon le choix du select

            $data = $form->get('id')->getData();

            $slider->setTitle($data->getTitle());
            $slider->setDescription($data->getDescription());
            $slider->setPubDate($data->getPubDate());
            $slider->setLink($data->getLink());
            $slider->setGuid($data->getGuid());
            $slider->setUrlImg($data->getUrlImg());
            $slider->setContent($data->getContent());

            $sliderRepository->save($slider, true);

            return $this->redirectToRoute('app_slider_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('slider/edit.html.twig', [
            'slider' => $slider,
            'form' => $form,
        ]);
    }
}