<?php

namespace App\Controller\Radio;

use App\Entity\ApiRadio;
use App\Form\ApiRadioType;
use App\Repository\ApiRadioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

#[Route('admin/radio')]
class ApiRadioCreateController extends AbstractController
{
    #[Route('/new', name: 'app_api_radio_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ApiRadioRepository $apiRadioRepository): Response
    {
        $apiRadio = new ApiRadio();
        $form = $this->createForm(ApiRadioType::class, $apiRadio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $apiRadioRepository->save($apiRadio, true);
            $citiesJson = file_get_contents('assets/cities.json');
            $json = json_decode($citiesJson, true);
            $test = $json['cities'];

            $results = $apiRadioRepository->findBy(array(),array('id'=>'DESC'),1,0);
            $codePostal= $results[0]->getCodePostal();
            $isFinded = false;
            

            foreach ($test as $key => $value) {
                if($value['zip_code'] == $codePostal){
                    $correctInfo = $value;
                    $isFinded = true;
                }
            }
            if($isFinded){
                $concat = $correctInfo['latitude'].','.$correctInfo['longitude'];
                $results[0]->setCoordonnees($concat);
            }
            else{
                $results[0]->setCoordonnees('0,0');
            }


            $apiRadioRepository->save($apiRadio, true);

            return $this->redirectToRoute('app_api_radio_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('api_radio/new.html.twig', [
            'api_radio' => $apiRadio,
            'form' => $form,
        ]);
    }
}