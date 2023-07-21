<?php

namespace App\Controller;

use App\Entity\ZoneTexte;
use App\Form\ZoneTexteType;
use App\Repository\ZoneTexteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ZoneTexteController extends AbstractController
{
    #[Route('admin/zonetexte', name: 'app_zone_texte', methods: ['GET', 'POST'])]
    public function edit(Request $request, ZoneTexteRepository $zoneTexteRepository): Response
    {
        $zoneTexte = $zoneTexteRepository->findBy(array(),array('id'=>'DESC'),1,0);
        
        if(isset($zoneTexte[0])){
            $zoneTexte = $zoneTexte[0];
        }
        else{
            $zoneTexte = new ZoneTexte();
        }

        



        $form = $this->createForm(ZoneTexteType::class, $zoneTexte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $zoneTexteRepository->save($zoneTexte, true);
        }

        return $this->render('zone_texte/index.html.twig', [
            'zoneTexte' => $zoneTexte,
            'form' => $form,
        ]);
    }
}
