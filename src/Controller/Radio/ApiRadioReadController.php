<?php

namespace App\Controller\Radio;

use App\Repository\ApiRadioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/radio')]
class ApiRadioReadController extends AbstractController
{
    #[Route('/', name: 'app_api_radio_index', methods: ['GET'])]
    public function index(ApiRadioRepository $apiRadioRepository): Response
    {
        return $this->render('api_radio/index.html.twig', [
            'api_radios' => $apiRadioRepository->findAll(),
        ]);
    }
}