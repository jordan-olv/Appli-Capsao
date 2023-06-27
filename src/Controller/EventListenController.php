<?php

namespace App\Controller;tps://capsao.com/rss-feed-34

use GuzzleHttp\Client;
use App\Entity\EventFluxRss;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Controller qui transforme le flux rss en Json
 */

class EventListenController extends AbstractController
{
    #[Route('/event/{id}', name: 'app_event_listen')]
    public function edit(EventFluxRss $eventFluxRss): Response
    {
    
        $feeds = file_get_contents($eventFluxRss->getLink());
        // $feeds = str_replace("<content:encoded>","<contentEncoded>",$feeds);
        // $feeds = str_replace("</content:encoded>","</contentEncoded>",$feeds);
        $rss = simplexml_load_string($feeds, 'SimpleXMLElement', LIBXML_NOCDATA);


        // Envoyer le contenu à l'application front-end (Vue.js) sous forme de réponse JSON, par exemple
        return $this->json(['fileContent' => $feeds]);
    }
}