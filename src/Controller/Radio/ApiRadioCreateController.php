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

/**
 * Controller création radio
 */

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

            // Ajout dans la base de donnée toutes les infos pour la radio sans les coordonnées

            $apiRadioRepository->save($apiRadio, true);

            // Récupération de la liste des villes contenant les latitudes et longitudes
            // https://www.data.gouv.fr/fr/datasets/villes-de-france/

            $citiesJson = file_get_contents('assets/cities.json');
            $json = json_decode($citiesJson, true);
            $jsonCities = $json['cities'];

            // Récupération du dernier code postal ajouté dans la base de donnée

            $results    = $apiRadioRepository->findBy(array(),array('id'=>'DESC'),1,0);
            $codePostal = $results[0]->getCodePostal();


            $isFinded   = false;

            // Chercher dans le json si on trouve une correspondance etre un code postal du json et celui rentré 
            
            foreach ($jsonCities as $key => $value) {
                if($value['zip_code'] == $codePostal){
                    $correctInfo = $value;
                    $isFinded    = true;
                }
            }

            // Si trouvé rajouter dans la bdd les coordonnées

            if($isFinded){
                $concat = $correctInfo['latitude'].','.$correctInfo['longitude'];
                $results[0]->setCoordonnees($concat);
            }
            else{
                // Si non trouvé ajouter les coordonnées 0,0
                $results[0]->setCoordonnees('0,0');
            }

            if(!$apiRadio->getimageURL() == null){
                $apiRadio->setimageURL('https://sc1ihlu1696.universe.wf/Appli-Capsao/public/assets/img/'.$apiRadio->getimageURL());
            }

            $apiRadioRepository->save($apiRadio, true);

            return $this->redirectToRoute('app_api_radio_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('api_radio/new.html.twig', [
            'api_radio' => $apiRadio,
            'form' => $form,
        ]);
    }
}