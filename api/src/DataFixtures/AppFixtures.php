<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


use App\Entity\ProcesType;
use App\Entity\Stage;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
    	$verhuizenNl = new ProcesType();
    	$verhuizenNl->setName('Verhuizen');    	
    	$verhuizenNl->setSubtitle('Geef uw verhuizing door');
    	$verhuizenNl->setDescription('Via dit procces geeft u een verhuizing door aan de gemeente waar u gaat wonen');
    	$verhuizenNl->setLogo('Geef uw verhuizing door');
    	$verhuizenNl->setSourceOrganization('000');
    	//$verhuizenNl->setRequest('Geef uw verhuizing door');
    	$manager->persist($verhuizen);    	
    	
    	$stage1 = new ProcesType();
    	
    	$verhuizenEindhoven = new ProcesType();
    	$verhuizenEindhoven->setName('Verhuizen');
    	$verhuizenEindhoven->setSubtitle('Geef uw verhuizing door');
    	$verhuizenEindhoven->setDescription('Via dit procces geeft u een verhuizing door aan de gemeente Eindhoven');
    	$verhuizenEindhoven->setLogo('Geef uw verhuizing door');
    	//$verhuizenEindhoven->setSourceOrganization('000');
    	//$verhuizenNl->setRequest('Geef uw verhuizing door');
    	$manager->persist($verhuizenEindhoven);    	
    	
    	$verhuizenDb = new ProcesType();
    	$verhuizenDb->setName('Verhuizen');
    	$verhuizenDb->setSubtitle('Geef uw verhuizing door');
    	$verhuizenDb->setDescription('Via dit procces geeft u een verhuizing door aan de gemeente \'s-Hertogenbosh');
    	$verhuizenDb->setLogo('Geef uw verhuizing door');
    	//$verhuizenDb->setSourceOrganization('000');
    	//$verhuizenNl->setRequest('Geef uw verhuizing door');
    	$manager->persist($verhuizenDb);

        $manager->flush();
    }
}
