<?php

namespace App\Controller\Event;

use Exception;
use App\Repository\EventFluxRssRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Controller qui transforme le flux rss en Json
 */

class EventListenController extends AbstractController
{
    #[Route('/api/event', name: 'app_event_listen')]
    public function edit(EventFluxRssRepository $eventFluxRssRepository): Response
    {
        $eventFluxRss = $eventFluxRssRepository->findOneBy([],['id'=>'desc']);
    
        if(isset($eventFluxRss)){
            $feeds = file_get_contents($eventFluxRss->getLink());
            return $this->json(['fileContent' => $feeds]);
        }
        
        // Envoyer le contenu à l'application front-end (Vue.js) sous forme de réponse JSON, par exemple
        
        return $this->json(['fileContent' => NULL]);
    }
}
