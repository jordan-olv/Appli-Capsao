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
 * Update d'événement dans le slider
 */

#[Route('/slider')]
class SliderUpdateController extends AbstractController
{
    #[Route('/{id}/edit', name: 'app_slider_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Slider $slider, SliderRepository $sliderRepository,ApiEventRepository $apiEventRepository,EventFluxRssRepository $eventFluxRssRepository,EntityManagerInterface $em): Response
    {
        $fluxrss = $eventFluxRssRepository->findOneBy([],['id'=>'desc']);
        $fluxrss = $fluxrss->getLink();

        $apiEventRepository->addEventDB($fluxrss,$em);

        $form = $this->createForm(SliderType::class, $slider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //Récupération des data selon le choix du select

            $data = $form->get('id')->getData();

            $slider->setTitle($data->getTitle());
            $slider->setDescription($data->getDescription());
            $slider->setPubDate($data->getPubDate());
            $slider->setGuid($data->getGuid());
            $slider->setContent($data->getContent());

            if($data->getTitle() === '--- Vide ---'){  
                $slider->setLink($form->get('link')->getData());
                $sliderRepository->save($slider, true);
                $slider->setUrlImg('https://latinoclub.fr/assets/img/'.$slider->getUrlImg());
            }
            else{
                $slider->setLink($data->getLink());
                $slider->setUrlImg($data->getUrlImg());
            }

            $sliderRepository->save($slider, true);

            return $this->redirectToRoute('app_slider_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('slider/edit.html.twig', [
            'slider' => $slider,
            'form' => $form,
        ]);
    }
}
