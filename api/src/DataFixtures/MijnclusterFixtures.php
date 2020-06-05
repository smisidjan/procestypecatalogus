<?php

namespace App\DataFixtures;

use App\Entity\Section;
use App\Entity\Stage;
use App\Entity\ProcessType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class MijnclusterFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Lets make sure we only run these fixtures on larping enviroment
        if ($this->params->get('app_domain') != "mijncluster.nl" && strpos($this->params->get('app_domain'), "mijncluster.nl") == false) {
            return false;
        }

        /*
         *  Verhuizen
         */
        $id = Uuid::fromString('76039f75-6c9c-44bc-a5a2-2c4804ca23fc');
        $processType= new ProcessType();
        $processType->setName('Verhuizen');
        $processType->setIcon('fal fa-truck-moving');
        $processType->setDescription('Het doorgeven van een verhuizing aan een gemeente ');
        $processType->setSourceOrganization('001709124');
        $processType->setRequestType('https://vtc.mijncluster.nl/requestType/23d4803a-67cd-4720-82d0-e1e0a776d8c4');
        $processType->setExtends($verhuizen);
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType= $manager->getRepository('App:ProcessType')->findOneBy(array('id'=> $id));

        $stage= new Stage();
        $stage->setStart(true);
        $stage->setName('Gegevens');
        $stage->setIcon('fal fa-envelope');
        $stage->setSlug('gegevens');
        $stage->setDescription('Het e-mail addres dat wordt gebruikt om contact op te nemen (indien nodig) over deze verhuizing');
        $stage->setProcess($processType);
        $manager->persist($stage);

        $section = new Section();
        $section->setName('Telefoon');
        $section->setDescription('Het telefoon nummer dat wordt gebruikt om contact op te nemen (indien nodig) over deze verhuizing');
        $section->setType('string');
        $section->setProcess($processType);
        $manager->persist($section);
    }
}
