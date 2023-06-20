<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use GuzzleHttp\Client;

/**
 * Controller qui transforme le flux rss en Json
 */

class EventListenController extends AbstractController
{
    #[Route('/event', name: 'app_event_listen')]
    public function edit(): Response
    {
    
        $client = new Client();
        $response = $client->get('https://capsao.com/rss-feed-34');
        $content = $response->getBody()->getContents();

        // Envoyer le contenu à l'application front-end (Vue.js) sous forme de réponse JSON, par exemple
        return $this->json(['fileContent' => $content]);
    }
}