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

class BegravenFixtures extends Fixture
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
        if (
            strpos($this->params->get('app_domain'), 'begraven.zaakonline.nl') == false &&
            $this->params->get('app_domain') != 'begraven.zaakonline.nl' &&
            strpos($this->params->get('app_domain'), 'westfriesland.commonground.nu') == false &&
            $this->params->get('app_domain') != 'westfriesland.commonground.nu'
        ) {
            //return false;
        }

        /*
         *  Begraven
         */
        $id = Uuid::fromString('a8b8ce49-d5db-4270-9e42-4b47902fc817');
        $processType = new ProcessType();
        $processType->setIcon('fal fa-truck-moving');
        $processType->setSourceOrganization('0000');
        $processType->setName('Begraven');
        $processType->setDescription('Plan een begrafenis op een gekozen begraafplaats');
        $processType->setRequestType("{$this->commonGroundService->getComponent('vtc')['location']}/request_types/c2e9824e-2566-460f-ab4c-905f20cddb6c");
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage = new Stage();
        $stage->setName('Begraafplaats');
        $stage->setIcon('fal fa-headstone');
        $stage->setSlug('begraafplaats');
        $stage->setDescription('De gegevens van de begrafenis');
        $stage->setSlug('begraafplaats');
        $stage->setOrderNumber(1);

        $section = new Section();
        $section->setName('Gemeente');
        $section->setDescription('In welke gemeente wilt u iemand begraven?');
        $section->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/72fdd281-c60d-4e2d-8b7d-d266303bdc46"]);
        $section->setOrderNumber(1);
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Begraafplaats');
        $section->setDescription('Op welke begraafplaats wilt u iemand begraven?');
        $section->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/bdae2f7b-21c3-4d88-be6d-a35b31c13916"]);
        $section->setOrderNumber(2);
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Soort graf');
        $section->setDescription('Wat voor soort graf wilt u iemand in begraven?');
        $section->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/3b6a637d-19c6-4730-b322-c03d0d8301b6"]);
        $section->setOrderNumber(3);
        $stage->addSection($section);

        // Add the stage to the procces type
        $processType->addStage($stage);

        $stage = new Stage();
        $stage->setName('Datum en tijd');
        $stage->setDescription('Wanneer gaat het afscheid plaatsvinden?');
        $stage->setIcon('fal fa-calendar');
        $stage->setSlug('datum');
        $stage->setOrderNumber(2);


        $section = new Section();
        $section->setName('Datum en tijd');
        $section->setDescription('Wanneer vindt het afscheid plaats?');
        $section->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/b1fd7b38-384b-47ec-a0f2-6f81949cdece"]);
        $section->setOrderNumber(1);
        $stage->addSection($section);

        // Add the stage to the procces type
        $processType->addStage($stage);

        $stage = new Stage();
        $stage->setName('Artikelen');
        $stage->setIcon('fal fa-map-tasks');
        $stage->setSlug('artikelen');
        $stage->setDescription('Selecteer hier de artikelen voor de begrafenis.');
        $stage->setOrderNumber(3);

        $section = new Section();
        $section->setName('Artikelen');
        $section->setDescription('Selecteer hier de artikelen voor de begrafenis.');
        $section->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/8f9adb13-d5e0-40de-a08c-a2ce5a648b1e"]);
        $section->setOrderNumber(1);
        $stage->addSection($section);

        // Add the stage to the procces type
        $processType->addStage($stage);

        $stage = new Stage();
        //$property->setId('');
        $stage->setName('Overledene');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('overledene');
        $stage->setDescription('Wie wordt er begraven?');
        $stage->setOrderNumber(4);

        $section = new Section();
        $section->setName('Overledene');
        $section->setDescription('Wie is er overleden?');
        $section->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/db69ce35-4ae1-4aac-936f-bdb5d4d1ff18"]);
        $section->setOrderNumber(1);
        $stage->addSection($section);

        // Add the stage to the procces type
        $processType->addStage($stage);

        $stage = new Stage();
        $stage->setName('Belanghebbende');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('belanghebbende');
        $stage->setDescription('Wie treed op als belanghebbende?');
        $stage->setOrderNumber(5);

        $section = new Section();
        $section->setName('Belanghebbende');
        $section->setDescription('Wie treed er op als belanghebbende?');
        $section->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/db69ce35-4ae1-4aac-936f-bdb5d4d1ff18"]);
        $section->setOrderNumber(1);
        $stage->addSection($section);

        // Add the stage to the procces type
        $processType->addStage($stage);

        $manager->persist($processType);

        $manager->flush();
    }
}
