<?php

namespace App\Controller\Radio;

use App\Entity\ApiRadio;
use App\Entity\DefaultRadio;
use App\Form\ApiRadioType;
use App\Form\RadioDefaultType;
use App\Repository\ApiRadioRepository;
use App\Repository\DefaultRadioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller affichages liste des radios
 */

#[Route('admin/radio')]
class ApiRadioReadController extends AbstractController
{
    #[Route('/', name: 'app_api_radio_index', methods: ['GET', 'POST'])]
    public function index(ApiRadioRepository $apiRadioRepository,Request $request,EntityManagerInterface $em): Response
    { 


        $radios = $apiRadioRepository->findAll();

        $choices = [];
        foreach ($radios as $radio) {
            $choices[$radio->getNom()] = $radio->getId();
        }

        $radio = new ApiRadio();
        $form = $this->createForm(RadioDefaultType::class,$radio);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $defaultRadio = $apiRadioRepository->findBy(array('id' => $form->get('nom')->getData()->getId()));

            foreach ($radios as $radio) {
                $radio->setIsDefault('0');
            }

            $defaultRadio[0]->setIsDefault('1');

            $em->flush();
        }

        return $this->render('api_radio/index.html.twig', [
            'api_radios' => $apiRadioRepository->findAll(),
            'form' => $form
        ]);
    }
}
