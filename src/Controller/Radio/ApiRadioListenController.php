<?php

namespace App\Controller\Radio;

use App\Entity\ApiRadio;
use App\Repository\ApiRadioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use GuzzleHttp\Client;

/**
 * Controller qui transforme le retour du lien FluxTxt en Json
 */

#[Route('admin/radio')]
class ApiRadioListenController extends AbstractController
{
    #[Route('/{id}/listen', name: 'app_api_radio_listen', methods: ['GET', 'POST'])]
    public function edit(ApiRadio $apiRadio): Response
    {
        $fluxTxt = $apiRadio->getFluxTxt();
    
        $client = new Client();
        $response = $client->get($fluxTxt);
        $content = $response->getBody()->getContents();

// Envoyer le contenu à l'application front-end (Vue.js) sous forme de réponse JSON, par exemple
        return $this->json(['fileContent' => $content]);
    }
}