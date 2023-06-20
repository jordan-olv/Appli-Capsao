<?php

namespace App\DataFixtures;

use App\Entity\ApiRadio;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $radio = new ApiRadio();
        $radio->setNom('RadioLyon');
        $radio->setVille('Lyon');
        $radio->setFluxAudio('http://capsaopremium.ice.infomaniak.ch/capsaopremium-128.mp3');
        $radio->setFluxTxt('http://92.154.29.211/txt-CapsaoLyon.txt');
        $radio->setCodePostal('69000');
        $radio->setCoordonnees('45.7578137,4.8320114');
        $radio->setRayon('15');
        $manager->persist($radio);
        $radio = new ApiRadio();
        $radio->setNom('RadioOyonnax');
        $radio->setVille('Oyonnax');
        $radio->setFluxAudio('http://str0.creacast.com:80/capsao_f');
        $radio->setFluxTxt('http://92.154.29.211/txt-CapsaoLyon.txt');
        $radio->setCodePostal('01100');
        $radio->setCoordonnees('46.226480597,5.612552487');
        $radio->setRayon('10');
        $manager->persist($radio);


        $manager->flush();
    }
}
