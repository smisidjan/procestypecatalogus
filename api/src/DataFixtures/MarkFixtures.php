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
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'a4079fc0-7386-4262-8497-ba2ecb272395']),
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
    }
}
