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
        $stage->setName('Wie wilt u aanmelden');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('zorgform');
        $stage->setDescription('Dit aanmeldformulier is voor bewoners van Zuid Drecht die zorg en/of ondersteuning nodig hebben. De gegevens uit dit aanmeldformulier worden opgeslagen en besproken binnen het team van Zuid Drecht');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Wie wilt u aanmelden');
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
        $stage->setName('Uw contactgegevens');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('contact');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Uw contactgegevens');
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
        $stage->setName('Spreekt u de Nederlandse taal');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('taal');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Spreekt u de Nederlandse taal');
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
        $stage->setName('Wie zijn er bij betrokken');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('betrokkenen');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Wie zijn er bij betrokken');
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
        $processType->setDescription('Via dit formulier kunt u een afschrift burgelijke stand aanvragen');
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
        $processType->setDescription('Geef hier uw leerlingen vervoer wijziging door');
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => '51665b5d-e727-442c-9b48-cf704d1f958c']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id' => $id]);

        //1ste pagina
        $stage = new Stage();
        $stage->setName('Gegevens doorgeven');
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
        /*
         *
         * Bouwtekening opvragen
         */

        $id = Uuid::fromString('07aa6d8f-96bc-41cd-ba52-adc62d6dd1b5');
        $processType = new ProcessType();
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setName('Bouwtekening opvragen');
        $processType->setDescription('Via dit formulier kunt u bouwtekeningen opvragen');
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => 'ba6093e6-2f51-4d05-b9a2-60dc9ef6fc62']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id' => $id]);

        //1ste pagina
        $stage = new Stage();
        $stage->setName('Uw gegevens');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('gegevens');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Uw gegevens');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '25eacbe9-31c7-4af4-84cf-a68bec98f77d']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '4b27eeea-7a1e-4660-8b4b-85c8d63b2371']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '41728926-f2d0-41b0-8af9-7c787e291206']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //2e pagina
        $stage = new Stage();
        $stage->setName('Bouwjaar en type object');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('bouwjaar');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Bouwjaar en type object');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'e51124d4-cb5b-48f0-a720-b3144f2d2abc']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '97c5aa5c-9d03-4401-b95e-debcabe6523e']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //3e pagina
        $stage = new Stage();
        $stage->setName('Een toelichting');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('toelichting');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Een toelichting');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '2b4e9b1e-b3b4-4a36-ad08-c3d2836ac41c']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'f17d1d5b-2d0d-4fa6-b674-491dadc5601d']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'd53aa76f-aad6-42ec-8be7-6f50d8109ef2']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '891ec347-13d9-4d3e-89c1-d7db32b28691']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'eb1c128b-d4b0-49d2-9a3e-6064027adeef']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '69be5e95-dbd3-4518-b08d-95bd232c4271']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '76539609-7734-4f6b-acec-0a91c80e9ffb']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $section = new Section();
        $section->setName('Welke gegevens heeft u nodig?');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '542f5cfa-e2a8-4e08-99a3-589bb891ef7f']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        /*
         *
         * Buurtbudget aanvragen
         */

        $id = Uuid::fromString('fd549387-ffe6-41ca-9fc5-655e09305edb');
        $processType = new ProcessType();
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setName('Buurtbudget aanvragen');
        $processType->setDescription('Via dit formulier kunt u een buurtbudget aanvragen');
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => '50c4032e-b2d2-4e54-a07a-610832d16252']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id' => $id]);

        //1ste pagina
        $stage = new Stage();
        $stage->setName('Uw gegevens');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('gegevens');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Uw gegevens');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '19e542a4-65dd-43fe-b985-e96c71b061a6']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '0f48762c-d6c6-42fe-a682-77c2d047e107']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '2c5351c7-5067-4d22-87c8-b147c7497f06']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //2e pagina
        $stage = new Stage();
        $stage->setName('Doel buurtbudget');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('doel-buurtbudget');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Doel buurtbudget');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '87bfa6ea-e415-43c5-a822-ddc6fcaa8f66']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'a1f9ddf8-f635-4fc2-9058-046e400d79c0']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '2b81753e-0f31-4378-8769-166fba603331']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'f272d9bc-5a3d-4aec-908b-02f53e65b51d']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '7c7fbc27-7a64-4a08-87ac-5355af45b074']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $section = new Section();
        $section->setName('De kosten');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '20338510-5cc4-4b1b-af04-da35588ce612']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '4b7ab9e1-d2f1-4da3-8d4f-6caecd9df58a']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'c1c2d389-f2b9-4bbb-9a94-c7e27a072bac']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //3e pagina
        $stage = new Stage();
        $stage->setName('Betrokkenheid buurt');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('betrokkenheid-buurt');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Betrokkenheid buurt');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '1ae039e9-43e5-4579-9a9b-f188a25d56db']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '6d6f8b0c-2446-4043-9e94-3f3d6bf097e1']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '4ec4c54e-b841-463d-83bc-8d2559e3c4e0']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        /*
         *
         * Samenstelling sportvereniging
         */
        $id = Uuid::fromString('958eeb72-3b4d-4361-8b58-5bb0424c8e59');
        $processType = new ProcessType();
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setName('Samenstelling sportvereniging');
        $processType->setDescription('Via dit formulier kunt u een samenstelling sportvereniging aanvragen');
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => '1f2fc424-f82d-4505-8731-ac55833d81b3']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id' => $id]);

        //1ste pagina
        $stage = new Stage();
        $stage->setName('Gegevens sportvereniging');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('gegevens');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Gegevens sportvereniging');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '0dbc66a2-5112-4efd-a094-0a5a8b1bfb23']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $section = new Section();
        $section->setName('Bedrijfsgegevens ');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'f507af1e-bd2f-47ea-b9b5-306cf2e9836d']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '9e738fb2-819e-4c79-8860-07bc6567d6d9']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '46c291ae-d2e7-48f4-a09c-b41d660e8fb9']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'e41b4e17-b6af-4888-a57b-bd4213843cbd']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '95e07dc0-0945-40f6-a79f-3686e5d33bea']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '2b610890-bc38-4553-afa2-4d3fbd45386f']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '06329a11-d4f4-4571-a6d6-0a61c3369b75']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $section = new Section();
        $section->setName('Gegevens secretaris/contact persoon');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'ee598e5b-db66-4f4d-a12b-aee5069a0ca2']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'e9d11008-fa0a-4c10-b69b-e6b73ec2c78e']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '906309b3-db5c-4299-8957-720e146272e4']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '5e758019-0353-40c5-aef6-95d1b005f24f']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '2f9b19ef-ddb2-4d4d-a76e-4d7c3ef348fb']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'a571478f-cc7b-4477-8690-6e05adeb6f03']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'b75b0eb2-4d97-4cdb-bd33-246195232371']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //2e pagina
        $stage = new Stage();
        $stage->setName('Aanvullende gegevens');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('aanvullende-gegevens');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Sportvereniging');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'a491c29c-a934-4a12-a406-5d6d96bf20aa']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '56e2b968-3792-46c6-b83b-4fae472887af']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $section = new Section();
        $section->setName('Aantal leden');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'ee28d427-d9ba-430e-9480-2012ee36fa93']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '6310acef-9383-4429-abd2-e9adbaf9501c']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '60a681fa-c8ac-4979-b827-2bcfbe99bcb3']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $section = new Section();
        $section->setName('Postadres');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'eb97faac-f858-443c-9feb-62cc63e7657c']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'cf5384fb-7644-4f61-8894-5205ee2c830d']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'e5276902-4b3f-45d1-9e27-a32a8f8429b3']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'd74f396b-0986-464a-981d-b361a2fd2aca']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '5762c643-2942-492e-a50f-657339b059a7']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'aa3bdda0-db77-4c51-ba17-1f08b1b8c730']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '9ffad900-28c4-4bc4-b71e-e104c338084e']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        /*
         *
         * Aanvragen tegemoetkoming in schade (planschadevergoeding)
         *
         */
        $id = Uuid::fromString('5246ca0d-2a0a-4422-b500-39923a540d95');
        $processType = new ProcessType();
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setName('Aanvragen tegemoetkoming in schade (planschadevergoeding)');
        $processType->setDescription('Via dit formulier kunt u een tegemoetkoming in schade aanvragen');
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => '3bb7a27a-82a0-4e38-afba-b4b3a9de4306']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id' => $id]);

        //1ste pagina
        $stage = new Stage();
        $stage->setName('Ontroerende zaak');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('onroerendezaak');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Welke ontroerende zaak heeft schade geleden?');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'e61264de-4f93-4d75-97a2-a9b8516c0c01']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '1f4cf91e-6a04-44b6-9e49-d701bfecf7b5']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '819139d1-e660-4bab-bcbf-dd42514872ac']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '291e038a-f9db-4b4b-823b-6063f1dadee5']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '9d9833ba-1d3c-4f68-9c40-a62364f30d83']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '527241ec-bff9-492f-9e22-e93d1b7a7fd5']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'a28e6787-2740-402e-aca3-eff225b711f8']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '8c0ffbcc-9e38-451e-b628-a8e8ad1abb50']),
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
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '7bbd0593-4284-4f2f-a918-3a99670e8136']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '2ab5126f-af53-4c88-8734-b08fd564994b']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'cf60c928-6b05-44ee-afe5-29909ba441f8']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //3e pagina
        $stage = new Stage();
        $stage->setName('De grond van aanvraag');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('aanvraag');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('De grond van aanvraag');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '4970f85e-cc4e-4f05-b8b5-b6e7bee8aecb']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //4e pagina
        $stage = new Stage();
        $stage->setName('Aard van schade');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('aanvraag');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Aard van schade');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'de2fe24a-4e99-41dc-a7a8-d776c909b739']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '892a67d9-a1a4-4ebd-bb86-baa772b01bef']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'bc564bc6-e47d-413e-b1f8-72c9e7fd72c7']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '4e34f490-1910-4f7a-b0ea-135c347b5b49']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'e17baaac-d192-4fad-ade7-9606dff4932d']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        /*
         *
         * Parkeervergunning Incidenteel
         */
        $id = Uuid::fromString('1ec841bd-3a86-4bf8-beb0-27a5558773bf');
        $processType = new ProcessType();
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setName('Parkeervergunning Incidenteel');
        $processType->setDescription('Via dit formulier vraagt u Indicenteel een parkeervergunning aan');
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => '06ede3d9-2146-4250-a06b-00d1d4822a78']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id' => $id]);

        //1ste pagina
        $stage = new Stage();
        $stage->setName('Uw gegevens');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('gegevens');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Uw gegevens');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '89bb3781-56a7-4c3e-b121-1cb2f153badc']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '68990cc6-c8bb-4ae0-bf3a-6dcd38eb1577']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'a736d736-af06-44f4-adde-a6083dc0f3ec']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //2e pagina
        $stage = new Stage();
        $stage->setName('Vergunning gegevens');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('vergunning');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Kenteken');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'c7b529a5-a201-457d-b968-6b95254a6a12']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $section = new Section();
        $section->setName('Vergunningsgegevens');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '4214131b-33c6-491d-a1ff-6631855a006d']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '55c56c50-1f9f-48fc-ba0c-303386bf296c']),
            ////Voor welke periode heeft u de vergunning nodig?
            ////De vergunning meot minimaal 1 week en mag maximaal 3 maanden van tevoren aangevraagd worden.
            ////De vergunning kan maximaal voor de duur van 1 jaar aangevraagd worden.
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '9a5e4cfc-e67e-4163-a516-f1c133e49f59']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //3e pagina
        $stage = new Stage();
        $stage->setName('Machtiging');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('machtiging');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Machtiging');
        $section->setDescription('Ik machtig hierbij de gemeente Hoorn om éénmalig de kosten van een incidentele parkeervergunning automatisch af te schrijven van mijn rekening');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'd5eafe00-910e-4f83-9f5b-f17cd9c5ed85']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '380b25c1-9cc5-41e0-90f9-413ad4fef80b']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '4d8bc0b6-f15a-4dba-be8e-8a3ae4ce7d07']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'fac8ae29-a2ab-4576-88f8-01a68c59d368']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        /*
         *
         * Ligplaats klein bootje
         *
         */
        $id = Uuid::fromString('49234bba-d0db-4b1e-acef-7208e0dc429e');
        $processType = new ProcessType();
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setName('Ligplaats klein bootje');
        $processType->setDescription('Via dit formulier vraagt u een ligplaats voor een klein bootje aan');
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => 'ebff7783-2a8a-482c-882b-9d478e7d0a12']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id' => $id]);

        //1ste pagina
        $stage = new Stage();
        $stage->setName('Informatie over de gewenste ligplaats');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('info');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Informatie over de gewenste ligplaats');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'ca4251ab-8c59-431a-b7c4-22f6805c387c']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $section = new Section();
        $section->setName('Informatie over uw vaartuig');
        $section->setDescription('De hieronder gevraagde lengte van het vaartuig is de uiterste maatvoering van een vaartuig in verticale projectie, met daarbij inbegrepen roer, motor, tredeplank en daarmee gelijk te stellen constructie onderdelen.');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'e509701b-aa0e-420f-8c69-9c0eed109ba0']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '0b234ca7-e3ba-4565-a3e5-fdf51c972a1d']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '7d4244f3-2deb-44d0-864c-9be410f03c99']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'cdb311fb-8304-44b3-b9cb-88b02c0be648']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '5020f873-2faf-4391-ba7a-a8e4da22d307']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '594b38f9-229a-453b-87a5-ec448be4375d']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'ab94af43-1036-46eb-ba84-fef19275206c']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '76be117a-26d3-480e-8747-4a104dbca088']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'e38cc577-cf07-4a08-ad4e-748c6c18707c']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $section = new Section();
        $section->setName('Een toelichting');
        $section->setDescription('Hieronder is ruimte voor een toelichting en opmerkingen.');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'd7ea4d24-23f3-428f-a3d4-a655554eb5d6']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '689bec79-a955-4588-b889-3b90bb56147c']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //2e pagina
        $stage = new Stage();
        $stage->setName('Bijlage(n) boot');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('bijlagen');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Bijlage(n) boot');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '6356938a-1c34-456d-b006-963028c3aacd']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //3e pagina
        $stage = new Stage();
        $stage->setName('Uw gegevens');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('gegevens');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Uw gegevens');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '47c29397-4509-4d6d-9f26-13695cb68cc5']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '28b09e40-99e0-4dd4-be7b-b6e1b0f00f29']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '2c47f95b-b940-4914-b35f-d0b516df29b8']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '9a5cb50d-9556-4154-afd7-ca4613cfed54']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        /*
         * Contactformulier schuldhulpverlening
         *
         */

               $id = Uuid::fromString('e49c17b9-5c16-4992-ae25-1e090452f685');
        $processType = new ProcessType();
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setName('Contactformulier schuldhulpverlening');
        $processType->setDescription('Via dit formulier kunt u schuldhulpverlening aanvragen');
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => '16bb609d-cc5e-40ea-b0f9-a0d0b0fdd796']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id' => $id]);

        //1ste pagina
        $stage = new Stage();
        $stage->setName('Belangrijk');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('belangrijk');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Belangrijk');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'c18e476b-d5b0-43dd-b8a9-3fbfa60379e1']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'fe566195-405e-43fa-802f-7b9240caf872']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '1a2b9a41-0d36-4fb7-b57f-b47e90e6df7e']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '13116bd7-ffea-452a-969b-e094b42a0695']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $section = new Section();
        $section->setName('Gegevens bewindvoerder');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '53ff3d9f-636b-419a-8fde-dda9c504921f']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '266b6881-9ba3-4a48-a86d-b1700da40269']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //2e pagina
        $stage = new Stage();
        $stage->setName('Partner');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('partner');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Partner');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'e8716fcf-e8e5-464e-bbc4-72ddf23c5b75']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '7189aa48-5dc2-4196-b7de-adab3ef17069']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'f7fd5290-dce2-4a6a-9bef-be79b8702a8c']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //3e pagina
        $stage = new Stage();
        $stage->setName('Bijlagen toevoegen');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('bijlagen');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Bijlagen versturen');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'd538d3dc-1e16-4a90-94ca-ad5c58e708b1']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //4e pagina
        $stage = new Stage();
        $stage->setName('Toelichting en persoonsgegevens');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('toelichting-persoonsgegevens');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Uw gegevens');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'a19b21d2-c395-45ea-8ec1-0b58ddbbcbc0']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '576cb008-a477-4140-9f7b-15e1ce942ab7']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'a37e98d6-a6fa-4bbc-ba4d-f09e2ea3e6b7']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $section = new Section();
        $section->setName('Toelichting');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'c8bed216-f084-42fa-a52f-9e37f09791c9']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '5fb8c237-a0b3-4c37-9919-75d6c0c05b4e']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        /*
         *
         * Verzoek tot geheimhouding persoonsgegevens
         *
         */

        $id = Uuid::fromString('0fcc2af9-e164-4cf3-bda1-f3992784a800');
        $processType = new ProcessType();
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setName('Verzoek tot geheimhouding persoonsgegevens');
        $processType->setDescription('Via dit formulier kunt u een verzoek tot geheimhouding van persoonsgegevens aanvragen');
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => '07486a7d-6bd4-45b4-b3ab-14092267369f']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id' => $id]);

        //1ste pagina
        $stage = new Stage();
        $stage->setName('Uw gegevens');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('gegevens');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Uw gegevens');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'e7a2839a-18f9-410f-8416-a8fe3e80d77b']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'ebe854e0-740b-4762-a2a5-1a77fb8fd487']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'c7f87212-5af3-40c7-9e78-6e8c29e2843a']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //2e pagina
        $stage = new Stage();
        $stage->setName('Indienen of intrekken');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('indienen-intrekken');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Indienen of intrekken');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '64c35cbb-a573-49f0-958b-b3f99d257e69']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //3e pagina
        $stage = new Stage();
        $stage->setName('Indienen');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('indienen');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Indienen');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '31bb4f0f-709c-48f0-a9f4-0a263aa685f7']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $section = new Section();
        $section->setName('Gegevens kind(eren)');
        $section->setDescription('Vul hier de gegevens in van het voor wie u het verzoek indient.');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '76272572-677e-4070-88c6-52d4dae172e2']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '70fabe34-a985-49c5-aa8e-36d699ccbc83']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '5cf36c00-2479-4e35-b645-4ca2759187f8']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '6e303208-5bb6-4530-96a9-d50a42d2298d']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '9c7f70f3-68a4-4189-8c8f-f0506580e4ff']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //4e pagina
        $stage = new Stage();
        $stage->setName('Intrekken');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('intrekken');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Intrekken');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '1fabc8f4-3fa0-4011-adf6-53a9f50aed7f']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $section = new Section();
        $section->setName('Gegevens kind(eren)');
        $section->setDescription('Vul hier de gegevens in van het voor wie u het verzoek intrekt.');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'e121bfdf-4ff4-44aa-99b6-33590d2e257d']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '4f381e62-c2ed-47e1-bc49-32553d7ada3b']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '436f9826-832f-41a9-b87f-32ae667e2043']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '18b4e414-bdcb-47d5-932e-5653fe84431a']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'a097f52a-1688-4d30-bdc2-816f1f040b55']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '8e169520-a997-4826-a663-0bf672282205']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        /*
         *
         * Fraude melden
         */

        $id = Uuid::fromString('88295c61-5629-49f1-b5e2-cacbf464e83c');
        $processType = new ProcessType();
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setName('Fraude melden');
        $processType->setDescription('Via dit formulier kunt u fraude melden');
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => 'db64d35b-b6da-4cac-af5d-7d4360d0281f']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id' => $id]);

        //1ste pagina
        $stage = new Stage();
        $stage->setName('Wat wilt u melden?');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('melden');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('wat wilt u melden?');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '665d8321-3467-4772-806a-b98538b4c459']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '3a3e1f91-a9d4-4fb3-aed0-191d7e08c738']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '080bf94d-9cea-43d6-9600-745fcdd5e911']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '39a51fa1-47db-477d-9ada-7a6d4152347b']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '3e576375-8828-43d2-a0cb-85b558f6ae1a']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '70ed113b-0e6c-4b84-be03-d62b148c9fb9']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'a0582b8a-e3ad-49b1-94f8-1ef299889b89']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '503efffb-0844-4d61-b462-7871612aaaeb']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $section = new Section();
        $section->setName('Uitkeringsfraude');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '75b47c21-6c06-4864-b9ae-70d4a4249139']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '135f3b87-1bea-4f7a-91fd-5f6185e1fc92']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '0e865cf8-cee9-4e47-949a-7d70f41c2891']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $section = new Section();
        $section->setName('Zorgfraude');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '7a28282d-a53e-4965-a712-876193ddc11a']),
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
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '7d2a2d81-c85d-4edc-b919-a147eb0004a0']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '087e09c8-d7ef-4575-8936-75fcb40e0379']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '01505a42-5683-4bd1-be36-4d54d16604ef']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'd2299920-9c17-4616-8721-8c591cfd6908']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '9b9fdd00-19ca-4d24-a80e-157b863c3ea5']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        /*
         *
         * Subsidie verantwoording
         */
        $id = Uuid::fromString('78df3dfb-81b4-49a0-8b5e-24674667920c');
        $processType = new ProcessType();
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setName('Subsidie verantwoording');
        $processType->setDescription('Via dit formulier kunt u subsidie verantwoording afleggen');
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => '98901f8f-12ed-4dff-b8f2-ff81842e6b19']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id' => $id]);

        //1ste pagina
        $stage = new Stage();
        $stage->setName('Belangrijk');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('belangrijk');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Belangrijk');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '93dd63c5-df88-441a-922f-fd75763a3ed2']),
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
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'd9aa5bbf-bdb2-42e4-84f4-761dd8d9b354']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'd2b15e79-753a-4d43-80c2-fec1ee55060e']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '9b63971b-5110-49a5-8118-ae2fbc593087']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //3e pagina
        $stage = new Stage();
        $stage->setName('Subsidie gegevens');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('subsidie-gegevens');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Zaaknummer');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'c964d159-abda-4a60-a67e-0b4c7c781561']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $section = new Section();
        $section->setName('Activiteiten');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '7ba2c95b-2602-4018-9f3c-7ff86a686d47']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'f555ea71-bd71-4cda-8b90-4b7aecad08b5']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $section = new Section();
        $section->setName('Verklaring');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'eae63b80-247d-4098-a7cd-7d96a19c8eb6']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //4e pagina
        $stage = new Stage();
        $stage->setName('Verantwoorden');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('verantwoorden');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Verantwoorden');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'eb9aa34f-e21f-49b8-ac8e-da82b55e73f4']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //5e pagina
        $stage = new Stage();
        $stage->setName('Opmerkingen');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('opmerkingen');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Bijlagen algemeen');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '2deda805-836b-4d3b-a150-3dedaa2071bf']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '6629dd17-edd2-4af0-9f40-9d0b59433fbc']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '5b08a870-197e-4800-9363-83a6878053a6']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();
    }
}
