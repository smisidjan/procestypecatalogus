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

class HuwelijksplannerFixtures extends Fixture
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
            $this->params->get('app_domain') != "huwelijksplanner.online" && strpos($this->params->get('app_domain'), "huwelijksplanner.online") == false
        ) {
            return false;
        }

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
        $stage->setName('Locatie');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('ambtenaar-locatie');
        $stage->setDescription('Wie treed op als belanghebbende?');

        /*
        $section = new Section();
        $section->setName('Ambtenaar');
        $section->setDescription('Trouwen of partnerschap');
        $section->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/db69ce35-4ae1-4aac-936f-bdb5d4d1ff18"]);
        $stage->addSection($section);
        */

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

        // Save it all to the db
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $manager->flush();
    }
}
