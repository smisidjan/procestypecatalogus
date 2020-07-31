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

class SaraiFixtures extends Fixture
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
            $this->params->get('app_domain') != 'zuiddrecht.nl' && strpos($this->params->get('app_domain'), 'zuiddrecht.nl') == false &&
            $this->params->get('app_domain') != 'zuid-drecht.nl' && strpos($this->params->get('app_domain'), 'zuid-drecht.nl') == false
        ) {
            return false;
        }

        //zorg formulier
        $id = Uuid::fromString('6ea049ca-a24a-40b8-b854-2544c9b813c3');
        $processType = new ProcessType();
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setName('Direct zorg aanvragen');
        $processType->setDescription('Dit aanmeldformulier is voor bewoners van Zuid Drecht die zorg en/of ondersteuning nodig hebben. De gegevens uit dit aanmeldformulier worden opgeslagen en besproken binnen het team van Zuid Drecht.');
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => 'ffa22c00-6622-4cf3-8e97-682459a28d2d']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id' => $id]);

        //1ste pagina
        $stage = new Stage();
        $stage->setName('Aanmelden');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('zorgform');
        $stage->setDescription('Dit aanmeldformulier is voor bewoners van Zuid Drecht die zorg en/of ondersteuning nodig hebben. De gegevens uit dit aanmeldformulier worden opgeslagen en besproken binnen het team van Zuid Drecht');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Aanmelden');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '621a9799-0eb8-4242-b2d5-aa4c7ac5e62b']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'e5b77291-5ba1-49f3-a8c7-0e94a1df0dfe']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '5e286dc3-c7b8-4f09-8bd0-7daa0db21881']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //2e pagina
        $stage = new Stage();
        $stage->setName('Contactgegevens');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('contact');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Contactgegevens');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '56e115f6-aaa4-437f-80f6-252ff4ea0b84']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'b8835509-40a0-4d7a-958d-f4c72f726bfe']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '2b22534f-7982-42b6-98d5-c91f5b93eddd']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //3de pagina
        $stage = new Stage();
        $stage->setName('Taal');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('taal');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Taal');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '688a2e68-55c3-4dde-aaf6-339b918ae137']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //4de pagina
        $stage = new Stage();
        $stage->setName('Betrokkenen');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('betrokkenen');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Betrokkenen');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '5c3ba3db-bf7a-40d3-8f94-201a885f8df0']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '88f0d590-7fc4-4097-90fa-8406799ea13c']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '0d1ffdb0-23cf-4431-8c6e-1db2a88b7e4c']),

        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //5de pagina
        $stage = new Stage();
        $stage->setName('Reden van aanmelding');
        $stage->setDescription('U kunt in een volgend scherm (Overige opmerkingen) ook een bijlage toevoegen.');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('reden-aanmelding');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Reden voor aanmelding');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '0a2ff1c2-0712-4c08-964e-524b1ad66513']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '4276abce-e9b5-4360-a255-1d45a4a94bcc']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'cc9d2eba-b050-46e2-bc90-407e0bde4baf']),

        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //6de pagina
        $stage = new Stage();
        $stage->setName('Overige opmerkingen');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('overige-opmerkingen');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Overige opmerkingen');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '1cbd9f75-6689-405e-9d84-e6459870a941']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '65002f0c-8b16-496f-9298-70e89c08b67f']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        /*
         * Afschrift burgelijke stand
         *
         */

        $id = Uuid::fromString('e80093de-813f-4822-8ffe-d0de2afb3f43');
        $processType = new ProcessType();
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setName('Afschrift burgelijke stand');
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => 'a535b49a-6a0c-4010-b14d-25b850b32380']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id' => $id]);

        //1ste pagina
        $stage = new Stage();
        $stage->setName('Soort afschrift');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('soortafschrift');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Soort afschrift');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'c91562a2-87d2-48f2-8aff-acd045116314']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '15c6173a-a826-4dae-a2e0-3ba91ec83aa5']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $section = new Section();
        $section->setName('Van wie?');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'f2b68e37-f6d2-447c-a374-0fd9cb68b93e']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $section = new Section();
        $section->setName('De persoonsgegevens');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'eddf6606-e470-4a93-b1dd-00af4f7673c8']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '320a94f5-8d09-4386-ada8-d0e2b4b03a87']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'b9545eb0-8b83-42ef-84ba-d5f547826bde']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $section = new Section();
        $section->setName('De datum van gebeurtenis');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'd654a2aa-b0de-49e2-9c14-829356e05a59']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $section = new Section();
        $section->setName('Waar nodig?');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '320b941f-d295-4fd9-bb50-69bba5b55f78']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '4f096b36-23cb-4b29-ac97-08152563e920']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //2e pagina

        $stage = new Stage();
        $stage->setName('Uw gegevens');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('gegevens');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Uw gegevens');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'ed376dae-ef61-43f4-968f-9fa0f7be507b']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '7db65c5a-1443-412e-9342-bfde7d0908ca']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '78e675c9-f5b0-438d-bc68-9b4edc48a354']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        /*
         *
         * Leerlingen vervoer wijziging doorgeven
         */


        $id = Uuid::fromString('b79b3b4d-78f8-4b18-be86-dcace8d838a7');
        $processType = new ProcessType();
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setName('Leerlingen vervoer wijziging doorgeven');
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => '51665b5d-e727-442c-9b48-cf704d1f958c']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id' => $id]);

        //1ste pagina
        $stage = new Stage();
        $stage->setName('Doorgeven');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('leerlingwijzig');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Gegevens ouder/verzorger');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '31cfa8b3-96f2-4af2-8d36-166334f45875']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '7c38580e-bb71-4259-b4dd-76a0e9d60a36']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '8b403a94-f257-4664-8191-d72bfba4a9ee']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $section = new Section();
        $section->setName('Gegevens leerling');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'bc2434be-bae8-4e5d-992a-522e1306c350']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '50385e5e-d172-467b-a88c-d23fea1381f3']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '684d769d-8e54-4008-b788-a40bb35a98e9']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '9a59aa5b-c959-4611-b745-04965f1db214']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();


    }
}
