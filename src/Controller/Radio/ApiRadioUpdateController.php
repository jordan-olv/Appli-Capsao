<?php

namespace App\Controller\Radio;

use App\Entity\ApiRadio;
use App\Form\ApiRadioType;
use App\Repository\ApiRadioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/radio')]
class ApiRadioUpdateController extends AbstractController
{
    #[Route('/{id}/edit', name: 'app_api_radio_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ApiRadio $apiRadio, ApiRadioRepository $apiRadioRepository): Response
    {
        $form = $this->createForm(ApiRadioType::class, $apiRadio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $apiRadioRepository->save($apiRadio, true);

            return $this->redirectToRoute('app_api_radio_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('api_radio/edit.html.twig', [
            'api_radio' => $apiRadio,
            'form' => $form,
        ]);
    }
}