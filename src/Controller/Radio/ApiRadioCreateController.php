<?php

namespace App\Controller\Radio;

use App\Entity\ApiRadio;
use App\Form\ApiRadioType;
use App\Repository\ApiRadioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller création radio
 */

#[Route('admin/radio')]
class ApiRadioCreateController extends AbstractController
{
    #[Route('/new', name: 'app_api_radio_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ApiRadioRepository $apiRadioRepository): Response
    {
        $apiRadio = new ApiRadio();
        $form = $this->createForm(ApiRadioType::class, $apiRadio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $zipCode = $form['codePostal']->getData();

            $apiRadioRepository->findZipCode($apiRadio,$zipCode);
            $apiRadioRepository->save($apiRadio, true);
            $apiRadioRepository->updateImgUrl($apiRadio);

            return $this->redirectToRoute('app_api_radio_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('api_radio/new.html.twig', [
            'api_radio' => $apiRadio,
            'form' => $form,
        ]);
    }
}