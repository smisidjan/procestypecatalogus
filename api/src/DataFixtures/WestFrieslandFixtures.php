<?php

namespace App\DataFixtures;

use App\Entity\Condition;
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
        $processType->setIcon('fas fa-monument');
        $processType->setRequireLogin(true);
        $processType->setAudience('organization');
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'d280c4d3-6310-46db-9934-5285ec7d0d5e']));
        $processType->setName('Aanvragen begrafenis');
        $processType->setDescription('Plan een begrafenis op een gekozen begraafplaats.');
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'c2e9824e-2566-460f-ab4c-905f20cddb6c']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage = new Stage();
        $stage->setName('Gemeente');
        $stage->setOrderNumber(1);

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
        $stage->setOrderNumber(2);
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
        $stage->setOrderNumber(3);
        $stage->setSlug('grafsoort');
        $stage->setDescription('Het soort graf waarin de overledene wordt begraven');
        $stage->setSlug('grafsoort');

        $section = new Section();
        $section->setName('Soort graf');
        $section->setDescription('Wat voor soort graf wilt u iemand in begraven?');
        $section->setProperties(
            [
                $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'3b6a637d-19c6-4730-b322-c03d0d8301b6']),

            ]
        );
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Kistmaat');
        $section->setDescription('Valt de kist binnen de standaard afmetingen van 55cm bij 200cm?');
        $section->setProperties(
            [
                $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'4153ca80-55df-4a0e-9053-79f7db01bf4a']),
            ]
        );
        //s$section->setProperties(["https://vtc.westfriesland.commonground.nu/properties/3b6a637d-19c6-4730-b322-c03d0d8301b6"]);
        $stage->addSection($section);

        // Add the stage to the procces type
        $processType->addStage($stage);

        $stage = new Stage();
        $stage->setName('Bestaand graf');
        $stage->setOrderNumber(4);
        $stage->setDescription('Moet de overledene in een bestaand of een nieuw graf worden begraven?');
        $stage->setSlug('bestaand-graf');

        $condition = new Condition();
        $condition->setProperty('properties.soort_graf');
        $condition->setOperation('==');
        $condition->setValue($this->commonGroundService->cleanUrl(['component'=>'pdc', 'type'=>'offers', 'id'=>'d4b24164-d9b1-4ba2-88d0-8b6fa824e4e1']));

        $stage->addCondition($condition);

        $section = new Section();
        $section->setName('');
        $section->setDescription('In het geval van een bijzetting dient u het graf waarin dient te worden bijgezet te identificeren met een grafnummer of naam van reeds geplaatste overledenen');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'7c212e0e-46dc-4ce0-8cec-8fd0d2d2c99b'])]);
        //$section->setProperties(["https://vtc.westfriesland.commonground.nu/properties/b1fd7b38-384b-47ec-a0f2-6f81949cdece"]);
        $stage->addSection($section);

        // Add the stage to the procces type
        $processType->addStage($stage);

        $stage = new Stage();
        $stage->setName('Datum');
        $stage->setOrderNumber(5);
        $stage->setDescription('Wanneer gaat het afscheid plaatsvinden?');
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
        $stage->setOrderNumber(6);
        $stage->setSlug('artikelen');
        $stage->setDescription('Selecteer hier de gewenste artikelen voor de begrafenis.');

        $section = new Section();
        $section->setName('Artikelen');
        $section->setDescription('Selecteer hier de gewenste artikelen voor de begrafenis.');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'8f9adb13-d5e0-40de-a08c-a2ce5a648b1e'])]);
        // $section->setProperties(["https://vtc.westfriesland.commonground.nu/properties/8f9adb13-d5e0-40de-a08c-a2ce5a648b1e"]);
        $stage->addSection($section);

        // Add the stage to the procces type
        $processType->addStage($stage);

        $stage = new Stage();
        //$property->setId('');
        $stage->setName('Overledene');
        $stage->setOrderNumber(7);
        $stage->setSlug('overledene');
        $stage->setDescription('Wie wordt er begraven?');

        $section = new Section();
        $section->setName('Overledene met bsn');
        $section->setDescription('Wie is er overleden?');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'db69ce35-4ae1-4aac-936f-bdb5d4d1ff18'])]);
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Overledene zonder bsn');
        $section->setDescription('Wie is er overleden?');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'e532635f-70d2-4a4a-9245-b28d8a4a6ad6'])]);
        $stage->addSection($section);

        // Add the stage to the procces type
        $processType->addStage($stage);

        $stage = new Stage();
        $stage->setName('Aanvrager / Rechthebbende');
        $stage->setOrderNumber(8);
        $stage->setSlug('aanvrager-rechthebbende');
        $stage->setDescription('Wie treed op als aanvrager/rechthebbende?');

        $section = new Section();
        $section->setName('Aanvrager / Rechthebbende');
        $section->setDescription('Wie treed er op als aanvrager/rechthebbende?');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'24d3e05d-26c2-4adb-acd4-08bde88b4526'])]);
        //$section->setProperties(["https://vtc.westfriesland.commonground.nu/properties/24d3e05d-26c2-4adb-acd4-08bde88b4526"]);
        $stage->addSection($section);

        // Add the stage to the procces type
        $processType->addStage($stage);

        $stage = new Stage();
        $stage->setName('Contactpersoon');
        $stage->setOrderNumber(9);
        $stage->setSlug('contactpersoon');
        $stage->setDescription('Wie treed op als contactpersoon?');

        $section = new Section();
        $section->setName('Contactpersoon');
        $section->setDescription('Wie treed er op als contactpersoon?');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'8110dc29-7b27-448e-8853-a8126c984ccb']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'baf2d8a5-250a-44f8-9a05-55af004d5d4f']),
        ]);
        //$section->setProperties(["https://vtc.westfriesland.commonground.nu/properties/8110dc29-7b27-448e-8853-a8126c984ccb"]);
        $stage->addSection($section);

        // Add the stage to the procces type
        $processType->addStage($stage);

        $stage = new Stage();
        $stage->setName('Aanvullende informatie');
        $stage->setOrderNumber(10);
        $stage->setSlug('aanvullende-informatie');

        $section = new Section();
        $section->setName('Opmerkingen');
        $section->setDescription('Zijn er extra opmerkingen of wensen die u wilt meegeven?');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'03d4460d-ce9b-4d5b-9063-e7856205273d']),
        ]);
        //$section->setProperties(["https://vtc.westfriesland.commonground.nu/properties/8110dc29-7b27-448e-8853-a8126c984ccb"]);
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

        /*
         *  Wijziging
         */
        $id = Uuid::fromString('7216b69d-e245-488e-af8f-0969241926e7');
        $processType = new ProcessType();
        $processType->setIcon('far fa-edit');
        $processType->setRequireLogin(true);
        $processType->setAudience('organization');
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'d280c4d3-6310-46db-9934-5285ec7d0d5e']));
        $processType->setName('Wijziging');
        $processType->setDescription('Met dit verzoek kunt u een reeds in behandeling zijnd verzoek wijzigen');
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'5223c58e-75a5-4a9d-86ca-47b77b4656e8']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage = new Stage();
        $stage->setName('Aanvrager/Rechthebbende');
        $stage->setSlug('aanvrager/rechthebbende');
        $stage->setDescription('Wie treed op als aanvrager/rechthebbende?');

        $stage = new Stage();
        $stage->setName('gegevens');
        $stage->setSlug('gegevens');
        $stage->setDescription('Wat zijn de gegevens van het bezwaar');

        $section = new Section();
        $section->setName('gegevens');
        $section->setDescription('Wat zijn de gegevens van het bezwaar');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'6c5e6a94-1b31-4db3-97a7-c9a0bb3e6eda'])]);
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

        /*
         *  Bezwaar
         */
        $id = Uuid::fromString('2a95ba3e-a3f9-4fdf-8a6d-005d96aad405');
        $processType = new ProcessType();
        $processType->setIcon('far fa-hand-paper');
        $processType->setRequireLogin(true);
        $processType->setAudience('organization');
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'d280c4d3-6310-46db-9934-5285ec7d0d5e']));
        $processType->setName('Bezwaar');
        $processType->setDescription('Met dit verzoek kunt bezwaar maken tegen de uitkomst van een procedure');
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'5013042b-ffab-4933-9fd8-edfbc0c82b22']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage = new Stage();
        $stage->setName('gegevens');
        $stage->setSlug('gegevens');
        $stage->setDescription('Wat zijn de gegevens van het bezwaar');

        $section = new Section();
        $section->setName('gegevens');
        $section->setDescription('Wat zijn de gegevens van het bezwaar');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'efc8430d-73b5-44ae-a217-d95b663b7d09'])]);
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
