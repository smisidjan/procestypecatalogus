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
        $processType->setName('Aanvragen vergunning Drank en Horecaet');
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
    }
}
