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
 * Création d'événement dans le slider
 */

#[Route('/slider')]
class SliderCreateController extends AbstractController
{
    #[Route('/new', name: 'app_slider_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SliderRepository $sliderRepository): Response
    {
        if(!isset($sliderRepository->findAll()[0]))
        {
            echo 'Erreur lors de la récupération des informations des événements, vérifiez le lien du flux événement.';
            return $this->render('slider/new.html.twig');
        }
        else{
            $slider = new Slider();
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
            return $this->render('slider/new.html.twig', [
                'slider' => $slider,
                'form' => $form,
            ]);
        }



        
    }
}
