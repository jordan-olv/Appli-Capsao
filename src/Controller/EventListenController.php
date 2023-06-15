<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use GuzzleHttp\Client;

class EventListenController extends AbstractController
{
    #[Route('/event', name: 'app_event_listen')]
    public function edit(Request $request): Response
    {
        // dd($apiRadio);
        // dd($test);
    
        $client = new Client();
        $response = $client->get('https://capsao.com/rss-feed-34');
        // dd($response);
        $content = $response->getBody()->getContents();

// Envoyer le contenu à l'application front-end (Vue.js) sous forme de réponse JSON, par exemple
return $this->json(['fileContent' => $content]);
    }
}