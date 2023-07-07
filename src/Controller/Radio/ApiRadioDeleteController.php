<?php

namespace App\Controller\Radio;

use App\Entity\ApiRadio;
use App\Repository\ApiRadioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller de suppresion de radio
 */

#[Route('admin/radio')]
class ApiRadioDeleteController extends AbstractController
{
    #[Route('/{id}', name: 'app_api_radio_delete', methods: ['POST'])]
    public function delete(Request $request, ApiRadio $apiRadio, ApiRadioRepository $apiRadioRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$apiRadio->getId(), $request->request->get('_token'))) {
            $apiRadioRepository->remove($apiRadio, true);
        }

        return $this->redirectToRoute('app_api_radio_index', [], Response::HTTP_SEE_OTHER);
    }
}