<?php

namespace App\DataFixtures;

use App\Entity\ProcessType;
use App\Entity\Section;
use App\Entity\Stage;
use Conduction\CommonGroundBundle\Service\CommonGroundService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class MijnclusterFixtures extends Fixture
{
    private $commonGroundService;
    private $params;

    public function __construct(CommonGroundService $commonGroundService, ParameterBagInterface $params)
    {
        $this->commonGroundService = $commonGroundService;
        $this->params = $params;
    }

    public function load(ObjectManager $manager)
    {
        // Lets make sure we only run these fixtures on larping enviroment
        if (
            ($this->params->get('app_domain') != "mijncluster.nl" && strpos($this->params->get('app_domain'), "mijncluster.nl") == false)
        ) {
            return false;
        }

        /*
         *  Verhuizen
         */
        $id = Uuid::fromString('76039f75-6c9c-44bc-a5a2-2c4804ca23fc');
        $processType = new ProcessType();
        $processType->setName('Verhuizen');
        $processType->setIcon('fal fa-truck-moving');
        $processType->setDescription('Het doorgeven van een verhuizing aan een gemeente ');
        $processType->setSourceOrganization('001709124');
        $processType->setRequestType("{$this->commonGroundService->getComponent('vtc')['location']}/request_types/23d4803a-67cd-4720-82d0-e1e0a776d8c4");
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage = new Stage();
        $stage->setName('Waarheen en Waneer');
        $stage->setDescription('Waarheen en waneer wilt u verhuizen');
        $stage->setIcon('fal fa-calendar');
        $stage->setSlug('gegevens');
        $stage->setProcess($processType);
        $stage->setOrderNumber(1);
        $manager->persist($stage);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Datum en tijd');
        $section->setDescription('Wanneer vindt het afscheid plaats?');
        $section->setOrderNumber(1);
        $section->setProperties([
            "{$this->commonGroundService->getComponent('vtc')['location']}/properties/fbc9c518-8971-4257-bf81-68cbd9af84d3",
        ]);
        $manager->persist($section);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Locatie');
        $section->setDescription('Waarheen gaat u verhuizen');
        $section->setProperties([
            "{$this->commonGroundService->getComponent('vtc')['location']}/properties/c6623907-a2cc-490e-a4cf-4bc3eaaadeba",
        ]);
        $manager->persist($section);

        $manager->flush();
    }
}
