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

class ZuiddrechtFixtures extends Fixture
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
            $this->params->get('app_domain') != "zuiddrecht.nl" && strpos($this->params->get('app_domain'), "zuiddrecht.nl") == false &&
            $this->params->get('app_domain') != "zuid-drecht.nl" && strpos($this->params->get('app_domain'), "zuid-drecht.nl") == false
        ) {
            return false;
        }

        /*
         *  Huwelijk
         */

        $id = Uuid::fromString('b8955949-2d8d-4bfb-9c73-e5275bffa427');
        $processType = new ProcessType();
        $processType->setIcon('fal fa-rings-wedding');
        $processType->setSourceOrganization('000');
        $processType->setName('Huwelijk / Partnerschap');
        $processType->setDescription('Huwelijk / Partnerschap');
        $processType->setRequestType("{$this->commonGroundService->getComponent('vtc')['location']}/request_types/d0badfff-1c90-4ddb-80fc-49842d806eaa");
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage = new Stage();
        $stage->setName('Hoe wilt u trouwen?');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('huwelijk-ceremonie');
        $stage->setDescription('Wie treed op als belanghebbende?');

        $section = new Section();
        $section->setName('Soort huwelijk');
        $section->setDescription('Trouwen of partnerschap');
        $section->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/81ea285b-41c1-43ae-80f6-a8dc3c6825ff"]);
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Soort Plechtigheid');
        $section->setDescription('Trouwen of partnerschap');
        $section->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/d16e3c3b-564b-4d8d-bad2-adb5ffac26ad"]);
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Partner');
        $section->setDescription('Met wie wilt u trouwen');
        $section->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/963162eb-c4b7-42f2-9b37-b8bcbf84117a"]);
        $stage->addSection($section);

        $processType->addStage($stage);

        $stage = new Stage();
        $stage->setName('Ambtenaar');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('ambtenaar-locatie');
        $stage->setDescription('Wie treed op als belanghebbende?');

        /*
        $section = new Section();
        $section->setName('Ambtenaar');
        $section->setDescription('Trouwen of partnerschap');
        $section->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/c9937faf-ebc2-438c-b3bb-5590a3c63464"]);
        $stage->addSection($section);
        */

        $section = new Section();
        $section->setName('Locatie');
        $section->setDescription('Trouwen of partnerschap');
        $section->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/7a59202e-c830-4a2e-839c-c11a1ce62a6a"]);

        $stage->addSection($section);

        $stage = new Stage();
        $stage->setName('Wanneer wilt u trouwen?');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('datum');
        $stage->setDescription('Wie treed op als belanghebbende?');

        $section = new Section();
        $section->setName('Datum');
        $section->setDescription('Trouwen of partnerschap');
        $section->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/e85fdb66-f8b6-4ca0-a3fb-32b11aaebcb2"]);
        $stage->addSection($section);

        $processType->addStage($stage);

        $stage = new Stage();
        $stage->setName('Getuigen');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('getuigen');
        $stage->setDescription('Wie treed op als belanghebbende?');

        $section = new Section();
        $section->setName('Getuigen');
        $section->setDescription('Trouwen of partnerschap');
        $section->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/3a3b2d0e-7d93-4c4b-b313-30f7cdef0c06"]);
        $stage->addSection($section);

        $processType->addStage($stage);

        $stage = new Stage();
        $stage->setName('Overige gegevens');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('overig');
        $stage->setDescription('Wie treed op als belanghebbende?');

        $section = new Section();
        $section->setName('Contact gegevens');
        $section->setDescription('Trouwen of partnerschap');
        $section->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/db69ce35-4ae1-4aac-936f-bdb5d4d1ff18"]);
        $stage->addSection($section);

        /*
        $section = new Section();
        $section->setName('Naamsgebruik');
        $section->setDescription('Trouwen of partnerschap');
        $section->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/db69ce35-4ae1-4aac-936f-bdb5d4d1ff18"]);
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Taal');
        $section->setDescription('Trouwen of partnerschap');
        $section->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/db69ce35-4ae1-4aac-936f-bdb5d4d1ff18"]);
        $stage->addSection($section);
        */

        $section = new Section();
        $section->setName('Extras');
        $section->setDescription('Trouwen of partnerschap');
        $section->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/e6a8c45c-eae2-48a2-b215-81c3b5bf82df"]);
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Opmerkingen');
        $section->setDescription('Trouwen of partnerschap');
        $section->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/8a047a87-61fe-435c-95a8-ffc843a8e362"]);
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Melding voorgenomen huwelijk');
        $section->setDescription('Trouwen of partnerschap');
        $section->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/d46c0a9c-b6db-40da-af77-09f0037def57"]);
        $stage->addSection($section);

        $processType->addStage($stage);

        // Save it all to the db
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $manager->flush();
    }
}
