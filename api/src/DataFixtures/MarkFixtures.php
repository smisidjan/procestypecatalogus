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

class MarkFixtures extends Fixture
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
        //JA/NEE sticker bestellen
        $id = Uuid::fromString('5b24880e-708a-4fd9-84e7-c5427740fad6');
        $processType = new ProcessType();
        $processType->setName('Aanvraag JA/NEE of NEE/NEE sticker');
        $processType->setDescription('Hier kunt u een JA/NEE NEE/NEE sticker aanvragen.');
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'7e3998c0-4e9d-41e2-b9dc-f0840efc44d9']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage = new Stage();
        $stage->setName('Welke sticker wilt u bestellen?');
        $stage->setDescription('Welke sticker wilt u bestellen?');
        $stage->setSlug('sticker-bestellen');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Sticker');
        $section->setDescription('Welke sticker wilt u hebben?');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'c77cb790-7a93-46c6-a280-7f35bb29097f']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $stage = new Stage();
        $stage->setName('Uw gegevens');
        $stage->setSlug('uw-gegevens');
        $stage->setDescription('Uw gegevens');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Uw gegevens');
        $section->setDescription('Waar moet de sticker naartoe?');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'c9ed0d31-6296-4e65-9416-aa2a1c366ecd']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'f0ab2b61-2a98-48c0-b984-58ab5fa8568f']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'afcf73a4-9d31-4104-baf2-039c0fae85e2']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'a48ca6a1-0dbe-4497-9034-8760e407c662']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'5fc37fbe-14e8-48cf-ad32-0de22fa3bc57']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'825b1050-6dde-4d17-b180-6bde3204364f']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //Contactformulier bijzondere bijstand

        $id = Uuid::fromString('f7e630cb-c521-4e53-83ed-33775a50f9d1');
        $processType = new ProcessType();
        $processType->setName('Contactformulier bijzondere bijstand');
        $processType->setDescription('Wilt u weten of u in aanmerking komt voor bijzondere bijstand? Dat kan via dit contactformulier. Let op: dit is alleen een contactformulier en nog geen aanvraag.');
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'2d39a167-ea2e-49d9-96aa-fc5d199bd57c']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage = new Stage();
        $stage->setName('Uw situatie');
        $stage->setSlug('uw-situatie');
        $stage->setDescription('Uw situatie');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Uw situatie');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'8835b122-7a8a-4dfc-86d9-e12254e9f676']),
        ]);
        $stage->addSection($section);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Uw gegevens');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'a0162fb5-bf38-4476-b834-dbb298b9ac9f']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'91284651-b7a5-4b47-9108-24a7840c035e']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'52339b15-cd83-4710-b102-c06fc72cd727']),
        ]);
        $stage->addSection($section);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Waarheid gegevens');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'b2c127a1-c963-46dd-ae77-1a63de2c0b4c']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //Formulier Stel uw vraag aan Zuid-drecht
        $id = Uuid::fromString('c09fc57f-f03a-42fc-9d1f-e6e1f73e8002');
        $processType = new ProcessType();
        $processType->setName('Stel uw vraag aan Zuid-Drecht');
        $processType->setDescription('Dit formulier gebruikt u als u een algemene vraag over zorg en ondersteuning wilt stellen. Als u uw gegevens invult, ontvangt u een antwoord via e-mail of telefoon. U kunt ook anoniem een melding maken. Als u hiervoor kiest, kunnen wij geen contact met u opnemen.');
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'a3844f30-74d7-4fcc-84c0-5c81fea5dc2e']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage = new Stage();
        $stage->setName('Informatie over vraag of melding.');
        $stage->setSlug('vraag');
        $stage->setDescription('Informatie over vraag of melding.');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Gegevens contactpersoon');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'9410db4d-331f-4a54-9322-5db9148b9c90']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'3493c557-83b8-4284-9653-09f7028b5676']),
        ]);
        $stage->addSection($section);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Stel hier uw vraag of meld een probleem');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'24d9151f-abfe-45c6-9b87-5b543acae91d']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'36708885-716b-4e12-a93a-614952217b4e']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'12e64bca-dd12-4c25-b119-01e9416fb1be']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //Formulier aanvragen evenement
        $id = Uuid::fromString('f4a93355-7298-46ec-abfd-89b5da4db012');
        $processType = new ProcessType();
        $processType->setName('Activiteit organiseren');
        $processType->setDescription('Is de criteria voor een groot evenement niet voor u van toepassing dan kunt u volstaan met een melding. Zeven dagen voorafgaand aan het evenement.');
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'6a2b39fc-669d-4b6e-bbcc-27c8d8063f4e']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage = new Stage();
        $stage->setName('Omschrijf uw evenement.');
        $stage->setSlug('omschrijf-evenement');
        $stage->setDescription('Omschrijf uw evenement.');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Algemene gegevens:');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'3210089c-30e7-4e32-b0ee-c7120924ff4a']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'a92e3830-0c45-406b-a955-dfd00e01905c']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'a4079fc0-7386-4262-8497-ba2ecb272395']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $stage = new Stage();
        $stage->setName('Wanneer vind uw evenement plaats.');
        $stage->setSlug('tijd-evenement');
        $stage->setDescription('Wanneer vind uw evenement plaats.');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Wanneer vind uw evenement plaats:');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'b7415265-4f0f-4e35-9ee1-1774c5242ee3']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'2b34d5f1-37fb-40a9-b171-61a9ccea3e16']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'ef793831-d09b-428f-a2d5-338943abe8b5']),

        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $stage = new Stage();
        $stage->setName('Waar vind het evenement plaats');
        $stage->setSlug('plek-evenement');
        $stage->setDescription('Waar vind het evenement plaats.');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Waar vind uw evenement plaats:');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'dc3d50fb-106d-4fea-acb8-1323ac412744']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'ee10e23b-0722-4744-95d9-db3d3a77291f']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'4b3faaf9-f8f4-422c-869b-19103892316f']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'abed58a6-3e16-42fb-bb15-8b4f197fb7fc']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'234daa9c-f4ae-4a54-b1d2-a57ae7cbaeff']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'145f99ba-3319-41d9-b035-a178239eeec1']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $stage = new Stage();
        $stage->setName('Extra informatie over het evenement');
        $stage->setSlug('info-evenement');
        $stage->setDescription('Extra informatie over het evenement');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Documenten en info evenement:');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'18271026-961a-4577-834b-f00c68df6a7a']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'5a57828b-1232-4225-ad59-50c9347fbb98']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'81000444-8880-4ad4-82a3-0b53e9c1a233']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //Formulier Drank en horecawet
        $id = Uuid::fromString('c47285f2-90b4-4080-be56-c2992f677b41');
        $processType = new ProcessType();
        $processType->setName('Aanvragen vergunning Drank en Horecawet');
        $processType->setDescription('Een ondernemer moet een drank- en horecavergunning hebben om alcoholische dranken te schenken, vraag deze aan met dit formulier.');
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'30d63557-53e5-4393-a613-ca1debf278f4']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage = new Stage();
        $stage->setName('Opgeven bedrijfsgegevens');
        $stage->setSlug('aanmelden-vergunning');
        $stage->setDescription('Opgeven bedrijfsgegevens');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Vul de bedrijfsgegevens in:');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'889d5fc0-6709-42c5-b910-b992638e2755']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'7130e972-64e1-4e8b-8a6e-fe6f61ad4db3']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'b2163bf1-1247-4670-a146-d9bd2ce703ef']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'9d3e1f91-51c3-4c55-9440-0e09aa19957a']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'01a07273-6977-4b1b-87e6-96cf4930552d']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'cb87cae2-1a8c-42de-8587-ee821b400032']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $stage = new Stage();
        $stage->setName('Aanvraag en vergunning informatie');
        $stage->setSlug('informatie-vergunning');
        $stage->setDescription('Aanvraag en vergunning informatie');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Vergunninghouder:');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'574e80ce-8ec5-4c85-9a06-0057d6c20b5e']),
        ]);
        $stage->addSection($section);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Algemene vragen over de aanvraag:');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'d739487d-6e6a-4dce-be87-58b52194e955']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'55de8ff7-0513-4b09-b8de-dbec3f1ae343']),
        ]);
        $stage->addSection($section);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Vragen over de inselling:');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'9f05249d-bcc2-4f24-8580-0fd3de0a6d4d']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $stage = new Stage();
        $stage->setName('Omschrijf de ruimte waar alcohol geschonken wordt');
        $stage->setSlug('bedrijf-vergunning');
        $stage->setDescription('Omschrijf de ruimte waar alcohol geschonken wordt');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('In welke ruimte wordt er alcohol geschonken?');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'bd54116a-70d4-417f-8f98-b53b4309a9a9']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'5b6f5604-3188-4584-a936-c6ec3ea20994']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'bacf6482-7ed8-4231-9a01-dca12c292d8f']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $stage = new Stage();
        $stage->setName('Wanneer wordt er alcohol geschonken?');
        $stage->setSlug('opening-vergunning');
        $stage->setDescription('Wanneer wordt er alcohol geschonken?');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Vul de openingstijden in:');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'aebb8c79-8729-4cd8-8f3c-1e9ba3d201fa']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'f3e3c0e1-0793-4e09-a915-cbcadce69c8c']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'98edf464-7bc6-454b-9d50-ec53dbe11083']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'6f80c433-e692-44b2-aa53-99938da49455']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'a5256e20-c054-4ebf-a730-dae71f3c5bea']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'e18fef01-b3ac-4ddd-8ae6-5b2e299d6a77']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'7ecf8afe-c190-4a9d-9a8c-a7d261d056a8']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $stage = new Stage();
        $stage->setName('Bijlagen en extra informatie');
        $stage->setSlug('extra-vergunning');
        $stage->setDescription('Bijlagen en extra informatie');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Leidinggevenden');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'704c0be6-1f9c-4623-8761-98ab5c8e9b15']),
        ]);
        $stage->addSection($section);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Bijlagen:');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'3d417e45-b0b3-405e-b725-83f2ae355268']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'0bdf1d97-0d24-415a-9371-7a7d60f4bd40']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'27864281-d32b-4eeb-816a-6edc691a83ea']),
        ]);
        $stage->addSection($section);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Tot slot:');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'66ccac5c-969a-4879-9f6a-a151f414c3f4']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'a61c80cb-54d6-415a-8e46-ef5caa9fbd09']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        /*
         * Aanvraag Blijverslening
         *
         */
        $id = Uuid::fromString('4f50e288-72da-4cab-9d25-a9bee006c648');
        $processType = new ProcessType();
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setName('Aanvraag Blijverslening');
        $processType->setDescription('Via dit formulier vraagt u een Blijverslening aan');
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => '1dcfbd45-3140-4d9b-ba20-7fb97dfc32b6']));
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
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '1172021a-9902-42b7-ab08-2cb169b589da']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '6e93748f-2822-4c77-823d-d35ef3246c06']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'abc993e6-c030-49ce-81b5-e0c8641aa239']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $section = new Section();
        $section->setName('Gegevens partner:');
        $section->setDescription('heeft u een partner? Vul dan hieronder de gegevens van uw partner in.');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '55027bb1-5639-4ea2-a92b-878971c3776e']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '7af29a03-4b98-44c5-81fa-84186ff86ad0']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'bb7ace53-1c74-4218-bbc7-ec592cad6b0f']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '813286e8-0743-4353-ac32-1a04a819f333']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $stage = new Stage();
        $stage->setName('Gegevens van uw woning');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('woning');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Wat is het adres van de woning waarvoor u een blijverslening wilt aanvragen?');
        $section->setDescription('gegevens woning:');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'f9f7bf4e-a798-45b9-9fab-e5e68aa48718']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'c5d64190-bf92-40ce-93bc-f83bb386c414']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '97626d6b-4e51-4f7a-99e1-3c7daca0ba76']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'a012a629-3f02-43f8-8037-9f91609385fc']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'c4c936c8-6973-4578-b6cb-1e63b94bb8f0']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '37a86de8-4c81-4fea-b311-4755e837d830']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'a8e8ed68-b6d5-45e9-a245-7d03f73cbbbb']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //2e pagina
        $stage = new Stage();
        $stage->setName('Aanpassingen aan de woning');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('aanpassingen');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Aanpassingen aan de woning');
        $section->setDescription('Welke maatregelen of werkzaamheden aan uw woning gaat u uitvoeren?');
        $section->setProperties([
            //formElement moet nog gemaakt worden
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '700d1c83-e911-4c2c-ad3b-ee9a5292b314']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'ff8161eb-41ae-4d01-b236-7091e2d1413d']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'b1ef428f-7be4-4004-9455-1b3dbff64bf9']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '777ba2ae-57d7-4a4c-baa9-5bb81f874ab0']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'd33f4a30-68f6-4252-a47c-47c384177be5']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'b45d9af4-cdf1-4820-b2e9-49e645dea203']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //3e pagina
        $stage = new Stage();
        $stage->setName('Soort ondersteuning');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('ondersteuning');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Soort ondersteuning');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'c61437cc-684e-4e3e-ae9f-8ee60cf7904a']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'e389e377-bd92-4493-a8b9-cdfe1f8024c3']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'c2b90250-70d2-47b0-b031-38a34c188d85']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '89a39f41-9ede-4b1c-a480-021d9e732efd']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '69077361-27b0-4017-bf73-c2c83990071c']),
        ]);
        $section->setStage($stage);

        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $stage = new Stage();
        $stage->setName('Lening en bijlagen');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('lening');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Lening');
        $section->setDescription('Een lening is alleen mogelijk voor de geoffreerde kosten min de ontvangen subsidies of ondersteuning.');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '135d2d77-5d61-4115-b0b9-08d76139230d']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '2fb057a5-06c0-43f3-b605-0adffc383f9a']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $section = new Section();
        $section->setName('Bijlagen');
        $section->setDescription('Stuur bij uw aanvraag de volgende bijlagen mee: Kopie recente offerte(s) van een aannemer/installateur/leverancier voor de te treffen maatregelen. Kopie van de benodigde vergunning(en) (indien van toepassing)');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'fe9c3737-1a02-44f1-ba57-940173bf99af']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $section = new Section();
        $section->setName('Tot slot');
        $section->setDescription('Ik ga akkoord met het volgende: alle verstrekte gegevens naar waarheid te hebben ingevuld inclusief de bijlage(n)');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '8064ccf3-f853-4a65-9109-ce2dc11abcf9']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //Formulier vraag (ver)bouwen
        $id = Uuid::fromString('9b3c3c9c-b128-4d37-900e-b86203c37fb5');
        $processType = new ProcessType();
        $processType->setName('Vraag stellen over (ver)bouwen');
        $processType->setDescription('Wilt u iets (ver)bouwen vraag dit hier aan.');
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'15fa03c2-a654-45be-8153-f2df32bcc6cb']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage = new Stage();
        $stage->setName('Bouwvraag & locatieinformatie');
        $stage->setSlug('bouwvraag');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Stel uw vraag en omschrijf de locatie');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '55d44ad8-8dca-44a3-9b5d-c001d0149a34']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '6330becc-b082-48e6-9517-a6000dfc8826']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $section = new Section();
        $section->setName('Adresgegevens locatie:');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '0309ca91-7c12-4046-a7b0-f390acddff40']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '2e18a86a-4e6a-4de4-972a-184a86446dc8']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'e796c513-706e-4545-97cd-e5a75576c9fd']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '6c1944c5-7931-4608-a9a2-b65bd751b729']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'df6d8c3b-d50c-4442-8596-2768a60eb071']),
        ]);
        $section->setStage($stage);

        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $stage = new Stage();
        $stage->setName('Persoonsgegevens aanvrager');
        $stage->setSlug('gegevens');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Uw gegevens');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '56568eef-388e-4549-b3c2-c10dce672453']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'de0d08d5-27f2-42d4-8984-af4d07b20350']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '3630286c-4a83-41ab-8fcb-07a596d4597d']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //formulier begraven
        $id = Uuid::fromString('4bfc134f-294b-4070-8de3-cc667bfa1dd8');
        $processType = new ProcessType();
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setName('Melden begraafenis');
        $processType->setDescription('Hier kunt u een begravenis melden');
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => 'b24a6663-2691-4568-8b3e-74e8e1b17c3f']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id' => $id]);

        $stage = new Stage();
        $stage->setName('Gegevens bedrijf');
        $stage->setSlug('gegevens');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Gegevens bedrijf');
        $section->setDescription('Gegevens kamer van koophandel');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '39ec384d-4209-4234-ad68-0d43592f236f']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'd6f14882-5720-43e6-96be-69b2551720ab']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Bedrijfsgegevens');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '6996b2fe-c4e5-43e9-b5e9-34deb886842e']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '1f479217-9ee0-4a62-acb0-8ef9160cfa17']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'a918ca80-ef3f-44fe-812d-79f89de0c162']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'b1a98254-7a8c-4cf3-bc88-fd7edc4da7d8']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'cecbddfa-207e-4d9b-811c-a1c0962904d6']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '94052578-250b-43de-9993-e16c481e8d5b']),
        ]);
        $section->setStage($stage);

        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $stage = new Stage();
        $stage->setName('Gegevens contactpersoon');
        $stage->setSlug('contactpersoon');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Contactpersoon');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '2e82f135-1258-4c48-a34b-b8bd8a0b7cc6']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '6b7fa325-5956-45df-bb63-7075dce2ebb4']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'ca518de8-4d19-482c-abd7-f5e8e64139d5']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'e2bc6133-e279-488e-8f98-496ed103e1f5']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'd0f2b60e-cd79-4bc4-b7c8-a47ee53b5a6e']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'c98deeb0-481b-40e3-99e4-9b4e5c4efcab']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '62e33ac8-3122-4b0d-bbaa-af127c90fafe']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '4ce30cab-96de-406d-b3f2-cccb8dd79e68']),
        ]);
        $section->setStage($stage);

        $stage->addSection($section);

        $section = new Section();
        $section->setName('Waarheid gegevens');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '7acf03f2-4730-4e46-bdaf-f2dbcf89c618']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $stage = new Stage();
        $stage->setName('Persoonsgegevens');
        $stage->setSlug('overledene');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Gegevens van de overledene');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'baea7811-3aef-447a-82e2-841f96e3e31d']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '734fc710-ce4d-4ee6-9b02-8e8288e99edd']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '5452777e-7ca6-4ca1-8bb9-bbdf095287c6']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '338b4229-6c00-454a-b72b-6b9f398d0bd7']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'a5fc48a3-1d2a-4934-910e-1e8e9e8c5d2b']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '718ae5fe-e672-407a-b56e-47924af0e685']),
        ]);
        $section->setStage($stage);

        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $stage = new Stage();
        $stage->setName('Gegevens rechthebbende');
        $stage->setSlug('rechthebbende');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Gegevens van de rechthebbende / opdrachtgever');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'efc87f8a-e503-4648-b465-28d7c98f25ba']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'b0530640-9213-4b06-a213-14fbcdf763d2']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '95c5a62b-d8c8-464d-8059-cd3b8995ab0f']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '867adfe6-ec0a-4c32-bac0-1c5edfb4fdec']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '9ca27a26-2b85-417e-ad6c-2b08fd48ed87']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '259efb62-4cf1-4ba4-8238-b29c777ccb11']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'eca0cb14-bfac-4af4-9457-734741235a03']),
        ]);
        $section->setStage($stage);

        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $stage = new Stage();
        $stage->setName('Gegevens van de begraafplaats');
        $stage->setSlug('begraafplaats');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Gegevens begraafplaats');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'c2e71f55-3e7a-4a89-ac52-d0c11e091aa3']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '8c7040d0-7f55-4ee3-b039-173e17f56b98']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '10ddf74e-3c4d-4d86-b713-b6d7b1260003']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '261744fd-507d-47c7-8887-e3a1c2a22048']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '35800e31-0227-4537-89fd-ff8a4cc0275c']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'fb1f9e6e-e149-443a-aa40-689f6b0df1de']),
        ]);
        $section->setStage($stage);

        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $stage = new Stage();
        $stage->setName('Gegevens van de uitvaart');
        $stage->setSlug('uitvaart');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Gegevens uitvaart');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '55298664-0121-4272-933c-ee217628dc33']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '8c00a8d2-041d-4b97-a479-d64cfcc63f9f']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '07fe5203-ba2d-416c-87b1-ea29b4f6273e']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //formulier aangeven overleiden
        $id = Uuid::fromString('2e9b0775-5efc-4954-b1e4-da0382db2fbf');
        $processType = new ProcessType();
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setName('Aangeven overleiden');
        $processType->setDescription('Met dit formulier kan de uitvaartverzorger een overleden persoon digitaal aangeven bij de gemeente Zuid-Drecht.');
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => '24962583-a3a2-4453-88b8-970114ebb89b']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id' => $id]);

        $stage = new Stage();
        $stage->setName('Gegevens van het bedrijf');
        $stage->setSlug('gegevens');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Gegevens bedrijf');
        $section->setDescription('Gegevens kamer van koophandel');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'cb4bbbdc-74d5-461c-accd-dd032dfefb75']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '4e9697ac-b44f-4094-84cf-4552ae8859f0']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Bedrijfsgegevens');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '486950fe-f884-4f28-99d4-82058a29cbca']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '7ce30df4-fcf6-4429-acfb-a72091490443']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '2f187ded-547a-43bb-b8d7-dcd0809159c7']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '582bc39a-251a-4c9e-bafa-f1f186b63ef4']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'fbb74614-c969-421c-bb72-1465ce65f06e']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '48e083f6-0de2-4196-9cc8-34cb3592959b']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $stage = new Stage();
        $stage->setName('Gegevens van de aangever');
        $stage->setSlug('aangever');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Gegevens aangever:');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'b3aa2e1e-8d3f-458e-96e9-c37aa194512f']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '7872224c-10ec-488c-8b70-703ea42fbdf3']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '8d55d760-d5a6-4967-a29b-f41a80bb9109']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '6a23a136-0dce-457b-9b15-fbd60ac5f835']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '90594152-2302-43e9-a544-ae120bb249da']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '75dcaddf-9a42-48d7-a2b6-4eb0e527e4cd']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'eb1314d1-cee4-433e-a61e-07d0c4822c2f'])
        ]);
        $section->setStage($stage);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $stage = new Stage();
        $stage->setName('Gegevens van de overledene');
        $stage->setSlug('overledene');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Plaats overleiden');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '1abb6b5a-4534-4957-8ab1-6e5a46a864bf']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Gegevens overledene:');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '9c90a629-5aab-4194-a8bf-39ea57f219a6']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'c49b417a-f0d2-49b2-bcfb-11946b2636f0']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '2ff7dbf5-099c-4f24-9419-584ed6bc2e55']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'a3cd3ea3-762c-4022-94eb-bb698083d62f']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'c2393ead-43ea-4d0d-a6d1-28836e46b7f0']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'dd1bdc9a-87bd-429e-921c-7b39f53c6033']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $stage = new Stage();
        $stage->setName('Gegevens van de overledene');
        $stage->setSlug('overledene');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('Informatie overleiden');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'cb4bbbdc-74d5-461c-accd-dd032dfefb75']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '4e9697ac-b44f-4094-84cf-4552ae8859f0']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Gegevens overledene');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'eb896755-7731-4c9b-8b3d-57ccffce9e3b']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'b6669bed-9c50-4bb5-9e9d-4c9a36e7ff2c']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '8cb78060-35a6-4deb-9e2c-8bcf305739b5']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '447168d3-2fb7-4bfc-bcb6-1289d9eb83f3']),
        ]);
        $section->setStage($stage);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();
    }
}
