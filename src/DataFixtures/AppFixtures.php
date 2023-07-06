<?php

namespace App\DataFixtures;

use App\Entity\ApiRadio;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $radio = new ApiRadio();
        $radio->setNom('RadioLyon');
        $radio->setVille('Lyon');
        $radio->setFluxAudio('http://capsaopremium.ice.infomaniak.ch/capsaopremium-128.mp3');
        $radio->setFluxTxt('http://92.154.29.211/txt-CapsaoLyon.txt');
        $radio->setCodePostal('69000');
        $radio->setCoordonnees('45.7578137,4.8320114');
        $radio->setRayon('15');
        $radio->setIsDefault('0');
        $radio->setimageURL('https://www.capsao.com/upload/players/6202865f0fb1c2.45156718.jpg');
        $manager->persist($radio);
        $radio = new ApiRadio();
        $radio->setNom('RadioOyonnax');
        $radio->setVille('Oyonnax');
        $radio->setFluxAudio('http://str0.creacast.com:80/capsao_f');
        $radio->setFluxTxt('http://92.154.29.211/txt-CapsaoLyon.txt');
        $radio->setCodePostal('01100');
        $radio->setCoordonnees('46.226480597,5.612552487');
        $radio->setRayon('10');
        $radio->setIsDefault('0');
        $radio->setimageURL('https://pbs.twimg.com/profile_images/704216087446069248/SXdeJQpz_400x400.jpg');
        $manager->persist($radio);


        $manager->flush();
    }
}
