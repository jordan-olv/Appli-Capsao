<?php

namespace App\Controller\Slider;

use App\Entity\Slider;
use App\Form\SliderType;
use App\Repository\SliderRepository;
use App\Repository\ApiEventRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\EventFluxRssRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Création d'événement dans le slider
 */

#[Route('/slider')]
class SliderCreateController extends AbstractController
{
    #[Route('/new', name: 'app_slider_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SliderRepository $sliderRepository,ApiEventRepository $apiEventRepository, EventFluxRssRepository $eventFluxRssRepository,EntityManagerInterface $em): Response
    {

            $fluxrss = $eventFluxRssRepository->findOneBy([],['id'=>'desc']);
            // dd($fluxrss);

            $fluxrss = $fluxrss->getLink();

                $apiEventRepository->addEventDB($fluxrss,$em);

            


            $slider = new Slider();
            $form = $this->createForm(SliderType::class, $slider);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                //Récupération des data selon le choix du select

                $data = $form->get('id')->getData();

                // dd($data->getUrlImg());

                $slider->setTitle($data->getTitle());
                $slider->setDescription($data->getDescription());
                $slider->setPubDate($data->getPubDate());
                $slider->setGuid($data->getGuid());
                $slider->setContent($data->getContent());

                if($data->getTitle() === '--- Vide ---'){  
                    $slider->setLink($form->get('link')->getData());
                    $slider->setUrlImg($form->get('imageFile')->getData());
                    $sliderRepository->save($slider, true);
                    $slider->setUrlImg('https://latinoclub.fr/assets/img/'.$slider->geturlImg());
                }
                else{
                    $slider->setLink($data->getLink()); 
                    $slider->setUrlImg($data->getUrlImg());
                }

                // dd($slider);
                

                
                $sliderRepository->save($slider, true);

                return $this->redirectToRoute('app_slider_index', [], Response::HTTP_SEE_OTHER);
            }
            return $this->render('slider/new.html.twig', [
                'slider' => $slider,
                'form' => $form,
            ]);
    }
}
