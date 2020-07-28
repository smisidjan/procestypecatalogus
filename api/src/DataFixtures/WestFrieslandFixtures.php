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

class WestFrieslandFixtures extends Fixture
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
            // If build all fixtures is true we build all the fixtures
            !$this->params->get('app_build_all_fixtures') &&
            // Specific domain names
            ($this->params->get('app_domain') != 'begraven.zaakonline.nl' && strpos($this->params->get('app_domain'), 'begraven.zaakonline.nl') == false) &&
            ($this->params->get('app_domain') != 'westfriesland.commonground.nu' && strpos($this->params->get('app_domain'), 'westfriesland.commonground.nu') == false) &&
            ($this->params->get('app_domain') != 'zuid-drecht.nl' && strpos($this->params->get('app_domain'), 'zuid-drecht.nl') == false)
        ) {
            return false;
        }

        /*
         *  Begraven
         */
        $id = Uuid::fromString('a8b8ce49-d5db-4270-9e42-4b47902fc817');
        $processType = new ProcessType();
        $processType->setIcon('fal fa-tombstone');
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'d280c4d3-6310-46db-9934-5285ec7d0d5e']));
        $processType->setName('Begraven');
        $processType->setDescription('Plan een begrafenis op een gekozen begraafplaats.');
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'c2e9824e-2566-460f-ab4c-905f20cddb6c']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage = new Stage();
        $stage->setName('Instructies');
//        $stage->setIcon('fal fa-headstone');
        $stage->setSlug('instruction');
        $stage->setDescription('De instructies van dit process type');

        $section = new Section();
        $section->setName('Instructies');
        $section->setDescription('De instructies van dit process type');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'f22037e8-8088-4f15-a24c-d1be880d495e'])]);
        //$section->setProperties(["https://vtc.westfriesland.commonground.nu/properties/72fdd281-c60d-4e2d-8b7d-d266303bdc46"]);
        $stage->addSection($section);

        $processType->addStage($stage);

        $stage = new Stage();
        $stage->setName('Gemeente');
        $stage->setIcon('fal fa-headstone');
        $stage->setSlug('gemeente');
        $stage->setDescription('De gemeente waarin de begrafenis plaats moet vinden');
        $stage->setSlug('gemeente');

        $section = new Section();
        $section->setName('Gemeente');
        $section->setDescription('In welke gemeente wilt u iemand begraven?');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'72fdd281-c60d-4e2d-8b7d-d266303bdc46'])]);
        //$section->setProperties(["https://vtc.westfriesland.commonground.nu/properties/72fdd281-c60d-4e2d-8b7d-d266303bdc46"]);
        $stage->addSection($section);

        $processType->addStage($stage);

        $stage = new Stage();
        $stage->setName('Begraafplaats');
        $stage->setIcon('fal fa-headstone');
        $stage->setSlug('begraafplaats');
        $stage->setDescription('De gegevens van de begrafenis');
        $stage->setSlug('begraafplaats');

        $section = new Section();
        $section->setName('Begraafplaats');
        $section->setDescription('Op welke begraafplaats wilt u iemand begraven?');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'bdae2f7b-21c3-4d88-be6d-a35b31c13916'])]);
        //$section->setProperties(["https://vtc.westfriesland.commonground.nu/properties/bdae2f7b-21c3-4d88-be6d-a35b31c13916"]);
        $stage->addSection($section);

        $processType->addStage($stage);

        $stage = new Stage();
        $stage->setName('Grafsoort');
        $stage->setIcon('fal fa-headstone');
        $stage->setSlug('grafsoort');
        $stage->setDescription('Het soort graf waarin de overledene wordt begraven');
        $stage->setSlug('grafsoort');

        $section = new Section();
        $section->setName('Soort graf');
        $section->setDescription('Wat voor soort graf wilt u iemand in begraven?');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'3b6a637d-19c6-4730-b322-c03d0d8301b6'])]);
        //s$section->setProperties(["https://vtc.westfriesland.commonground.nu/properties/3b6a637d-19c6-4730-b322-c03d0d8301b6"]);
        $stage->addSection($section);

        // Add the stage to the procces type
        $processType->addStage($stage);

        $stage = new Stage();
        $stage->setName('Datum');
        $stage->setDescription('Wanneer gaat het afscheid plaatsvinden?');
        $stage->setIcon('fal fa-calendar');
        $stage->setSlug('datum');

        $section = new Section();
        $section->setName('Datum');
        $section->setDescription('Wanneer vindt het afscheid plaats?');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'b1fd7b38-384b-47ec-a0f2-6f81949cdece'])]);
        //$section->setProperties(["https://vtc.westfriesland.commonground.nu/properties/b1fd7b38-384b-47ec-a0f2-6f81949cdece"]);
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
        $section->setProperties([$this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'8f9adb13-d5e0-40de-a08c-a2ce5a648b1e'])]);
        // $section->setProperties(["https://vtc.westfriesland.commonground.nu/properties/8f9adb13-d5e0-40de-a08c-a2ce5a648b1e"]);
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
        $section->setProperties([$this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'db69ce35-4ae1-4aac-936f-bdb5d4d1ff18'])]);
        //$section->setProperties(["https://vtc.westfriesland.commonground.nu/properties/db69ce35-4ae1-4aac-936f-bdb5d4d1ff18"]);
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
        $section->setProperties([$this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'24d3e05d-26c2-4adb-acd4-08bde88b4526'])]);
        //$section->setProperties(["https://vtc.westfriesland.commonground.nu/properties/24d3e05d-26c2-4adb-acd4-08bde88b4526"]);
        $stage->addSection($section);

        // Add the stage to the procces type
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
