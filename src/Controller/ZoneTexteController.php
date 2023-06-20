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
    #[Route('/{id}/zonetexte', name: 'app_zone_texte', methods: ['GET', 'POST'])]
    public function edit(Request $request, ZoneTexte $zoneTexte, ZoneTexteRepository $zoneTexteRepository): Response
    {
        $form = $this->createForm(ZoneTexteType::class, $zoneTexte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $zoneTexteRepository->save($zoneTexte, true);
        }

        return $this->renderForm('zone_texte/index.html.twig', [
            'zoneTexte' => $zoneTexte,
            'form' => $form,
        ]);
    }
}
