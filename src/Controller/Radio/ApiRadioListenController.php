<?php

namespace App\Controller\Radio;

use App\Entity\ApiRadio;
use App\Form\ApiRadioType;
use App\Repository\ApiRadioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;
use GuzzleHttp\Client;

#[Route('admin/radio')]
class ApiRadioListenController extends AbstractController
{
    #[Route('/{id}/listen', name: 'app_api_radio_listen', methods: ['GET', 'POST'])]
    public function edit(Request $request, ApiRadio $apiRadio, ApiRadioRepository $apiRadioRepository): Response
    {
        // dd($apiRadio);
        $test = $apiRadio->getFluxTxt();
        // dd($test);
    
        $client = new Client();
$response = $client->get($test);
$content = $response->getBody()->getContents();

// Envoyer le contenu à l'application front-end (Vue.js) sous forme de réponse JSON, par exemple
return $this->json(['fileContent' => $content]);
    }
}