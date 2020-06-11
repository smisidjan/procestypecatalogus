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
            ($this->params->get('app_domain') != "begraven.zaakonline.nl" && strpos($this->params->get('app_domain'), "begraven.zaakonline.nl") == false) ||
            ($this->params->get('app_domain') != "westfriesland.commonground.nu" && strpos($this->params->get('app_domain'), "westfriesland.commonground.nu") == false) ||
            ($this->params->get('app_domain') != "zuid-drecht.nl" && strpos($this->params->get('app_domain'), "zuid-drecht.nl") == false)
        ) {
            return false;
        }

        /*
         *  Begraven
         */
        $id = Uuid::fromString('a8b8ce49-d5db-4270-9e42-4b47902fc817');
        $processType = new ProcessType();
        $processType->setIcon('fal fa-tombstone');
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

        $section = new Section();
        $section->setName('Gemeente');
        $section->setDescription('In welke gemeente wilt u iemand begraven?');
        $section->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/72fdd281-c60d-4e2d-8b7d-d266303bdc46"]);
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Begraafplaats');
        $section->setDescription('Op welke begraafplaats wilt u iemand begraven?');
        $section->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/bdae2f7b-21c3-4d88-be6d-a35b31c13916"]);
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Soort graf');
        $section->setDescription('Wat voor soort graf wilt u iemand in begraven?');
        $section->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/3b6a637d-19c6-4730-b322-c03d0d8301b6"]);
        $stage->addSection($section);

        // Add the stage to the procces type
        $processType->addStage($stage);

        $stage = new Stage();
        $stage->setName('Datum en tijd');
        $stage->setDescription('Wanneer gaat het afscheid plaatsvinden?');
        $stage->setIcon('fal fa-calendar');
        $stage->setSlug('datum');

        $section = new Section();
        $section->setName('Datum en tijd');
        $section->setDescription('Wanneer vindt het afscheid plaats?');
        $section->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/b1fd7b38-384b-47ec-a0f2-6f81949cdece"]);
        $stage->addSection($section);

        // Add the stage to the procces type
        $processType->addStage($stage);

        $stage = new Stage();
        $stage->setName('Artikelen');
        $stage->setIcon('fal fa-map-tasks');
        $stage->setSlug('artikelen');
        $stage->setDescription('Selecteer hier de artikelen voor de begrafenis.');

        $section = new Section();
        $section->setName('Artikelen');
        $section->setDescription('Selecteer hier de artikelen voor de begrafenis.');
        $section->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/8f9adb13-d5e0-40de-a08c-a2ce5a648b1e"]);
        $stage->addSection($section);

        // Add the stage to the procces type
        $processType->addStage($stage);

        $stage = new Stage();
        //$property->setId('');
        $stage->setName('Overledene');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('overledene');
        $stage->setDescription('Wie wordt er begraven?');

        $section = new Section();
        $section->setName('Overledene');
        $section->setDescription('Wie is er overleden?');
        $section->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/db69ce35-4ae1-4aac-936f-bdb5d4d1ff18"]);
        $stage->addSection($section);

        // Add the stage to the procces type
        $processType->addStage($stage);

        $stage = new Stage();
        $stage->setName('Belanghebbende');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('belanghebbende');
        $stage->setDescription('Wie treed op als belanghebbende?');

        $section = new Section();
        $section->setName('Belanghebbende');
        $section->setDescription('Wie treed er op als belanghebbende?');
        $section->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/db69ce35-4ae1-4aac-936f-bdb5d4d1ff18"]);
        $stage->addSection($section);

        // Add the stage to the procces type
        $processType->addStage($stage);

        // asd
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        /*
         *  Huwelijk
         */

        $id = Uuid::fromString('5b10c1d6-7121-4be2-b479-7523f1b625f1');
        $processType = new ProcessType();
        $processType->setIcon('fal fa-rings-wedding');
        $processType->setSourceOrganization('000');
        $processType->setName('Huwelijk / Partnerschap');
        $processType->setDescription('Huwelijk / Partnerschap');
        $processType->setRequestType("{$this->commonGroundService->getComponent('vtc')['location']}/request_types/5b10c1d6-7121-4be2-b479-7523f1b625f1");
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
        $section->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/db69ce35-4ae1-4aac-936f-bdb5d4d1ff18"]);
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Soort Ceremonie');
        $section->setDescription('Trouwen of partnerschap');
        $section->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/db69ce35-4ae1-4aac-936f-bdb5d4d1ff18"]);
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Partner');
        $section->setDescription('Met wie wilt u trouwen');
        $section->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/db69ce35-4ae1-4aac-936f-bdb5d4d1ff18"]);
        $stage->addSection($section);

        $processType->addStage($stage);

        $stage = new Stage();
        $stage->setName('Ambtenaar en Locatie');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('ambtenaar-locatie');
        $stage->setDescription('Wie treed op als belanghebbende?');

        $section = new Section();
        $section->setName('Ambtenaar');
        $section->setDescription('Trouwen of partnerschap');
        $section->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/db69ce35-4ae1-4aac-936f-bdb5d4d1ff18"]);
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Locatie');
        $section->setDescription('Trouwen of partnerschap');
        $section->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/db69ce35-4ae1-4aac-936f-bdb5d4d1ff18"]);

        $stage->addSection($section);

        $stage = new Stage();
        $stage->setName('Wanneer wilt u trouwen?');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('datum');
        $stage->setDescription('Wie treed op als belanghebbende?');

        $section = new Section();
        $section->setName('Datum');
        $section->setDescription('Trouwen of partnerschap');
        $section->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/db69ce35-4ae1-4aac-936f-bdb5d4d1ff18"]);
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
        $section->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/db69ce35-4ae1-4aac-936f-bdb5d4d1ff18"]);
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

        $section = new Section();
        $section->setName('Extras');
        $section->setDescription('Trouwen of partnerschap');
        $section->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/db69ce35-4ae1-4aac-936f-bdb5d4d1ff18"]);
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Opmerkingen');
        $section->setDescription('Trouwen of partnerschap');
        $section->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/db69ce35-4ae1-4aac-936f-bdb5d4d1ff18"]);
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Melding voorgenomen huwelijk');
        $section->setDescription('Trouwen of partnerschap');
        $section->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/db69ce35-4ae1-4aac-936f-bdb5d4d1ff18"]);
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Betaling');
        $section->setDescription('Trouwen of partnerschap');
        $section->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/db69ce35-4ae1-4aac-936f-bdb5d4d1ff18"]);
        $stage->addSection($section);

        $processType->addStage($stage);

        // asd
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $manager->flush();
    }
}
