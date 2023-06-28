<?php

namespace App\Controller;

use App\Form\ZoneTexteType;
use App\Repository\ZoneTexteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ZoneTexteController extends AbstractController
{
    #[Route('zonetexte', name: 'app_zone_texte', methods: ['GET', 'POST'])]
    public function edit(Request $request, ZoneTexteRepository $zoneTexteRepository): Response
    {
        $zoneTexte = $zoneTexteRepository->findBy(array('id'=>1));
        $zoneTexte = $zoneTexte[0];

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
