<?php

namespace App\Controller\Radio;

use App\Entity\ApiRadio;
use App\Form\ApiRadioType;
use App\Repository\ApiRadioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Controller de mise a jour des radios
 */

#[Route('admin/radio')]
class ApiRadioUpdateController extends AbstractController
{
    #[Route('/{id}/edit', name: 'app_api_radio_edit', methods: ['GET', 'POST'])]
    public function edit($id,Request $request, ApiRadio $apiRadio, ApiRadioRepository $apiRadioRepository,EntityManagerInterface $em): Response
    {

        $form = $this->createForm(ApiRadioType::class, $apiRadio);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $zipCode = $form['codePostal']->getData();

            
            
            $apiRadioRepository->findZipCode($apiRadio,$zipCode);
            $apiRadioRepository->save($apiRadio, true);

            if(!$form['imageFile']->getData()==NULL){
                $apiRadioRepository->updateImgUrl($apiRadio);
            }

            return $this->redirectToRoute('app_api_radio_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('api_radio/edit.html.twig', [
            'api_radio' => $apiRadio,
            'form' => $form,
        ]);
    }
}