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

class TimFixtures extends Fixture
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

        // formulier Inlichtingen BRP / Burgerlijke stand
        $id = Uuid::fromString('1d101ceb-e485-4e71-bd8c-8161fcc0c347');
        $processType = new ProcessType();
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setName('formulier Inlichtingen BRP / Burgerlijke stand');
        $processType->setDescription('Advocaten, notarissen en gerechtsdeurwaarders gebruiken dit formulier voor een verzoek om inlichtingen uit de Basisregistratie Personen (BRP) of Burgerlijke stand');
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => '4dcf25f2-c2dc-4a82-8a78-33e4d3d7241d']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id' => $id]);

//        //1e pagina
//        $stage = new Stage();
//        $stage->setName('belangrijk');
//        $stage->setIcon('fal fa-users');
//        $stage->setSlug('belangrijk');
//        $stage->setProcess($processType);
//
//        $section = new Section();
//        $section->setName('Belangrijk');
//        $section->setProperties([]);
//        $section->setStage($stage);
//        $section->setStage($stage);
//        $stage->addSection($section);
//        $processType->addStage($stage);
//        $manager->persist($processType);
//        $manager->flush();

        // 2e pagina
        $stage = new Stage();
        $stage->setName('wat vraagt u aan?');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('wat-vraagt-u-aan');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('wat vraagt u aan?');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '898ba684-a579-4690-8a44-42f3bc7c132c']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '2b248c60-8449-4a41-ae2d-0dfa9d7cfd71']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'fba5b39d-6694-4c53-962a-28529fbbab1d']),
        ]);
        $section->setStage($stage);

        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //3e pagina
        $stage = new Stage();
        $stage->setName('bijlage toevoegen');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('bijlage-toevoegen');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('bijlage toevoegen');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '9b72c217-3186-4378-99b1-48cb74438f81']),
        ]);
        $section->setStage($stage);

        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //4e pagina
        $stage = new Stage();
        $stage->setName('Uw gegevens');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('uw-gegevens');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('gegevens kamer van koophandel');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '497d75d0-ea61-4d19-b30f-5c60c005dbb8']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '3805d5d9-4c97-4caf-9513-ddf542259f7c']),
        ]);
        $section->setStage($stage);

        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $section = new Section();
        $section->setName('bedrijfsgegevens');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '17e61185-a7eb-49f7-98ff-c88a5acd69a6']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '2384f44d-4090-4029-b5c3-8c90680daeaf']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'd4c02cd0-5b42-4351-861e-0cd6b4727bf7']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '6b0444bc-9d09-41c1-a72e-c25ebd5a2f10']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '7f14b3b4-3e9c-4558-95ab-a6756ebc5326']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'a6a61256-6ca1-44ef-b1b3-08c62a1a226f']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '938c3043-656e-4222-9030-a14ce72b3d62']),
        ]);
        $section->setStage($stage);

        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //5e pagina
        $stage = new Stage();
        $stage->setName('gegevens contact persoon');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('gegevens-contact-persoon');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('gegevens contact persoon');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '2d8a9acb-653b-468e-8d0d-d5beb16e1c26']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '2330c04a-c026-457d-9dc4-91570a14fd32']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'e080e28c-69d0-4a45-be23-f0d8149c1d44']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'cd93c04c-45f7-431e-9fcd-44006fcc9b5a']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'eb5ce9c9-5718-473d-8fc4-2896b1fb5ed5']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'cc0ceb38-1273-4668-b750-c4f7da9121b4']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'a32e1ed1-a03d-445d-a4c1-27d741a3329c']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'cfb6ab81-a98f-4ccc-b96f-524aa4f103d4']),
        ]);
        $section->setStage($stage);

        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $section = new Section();
        $section->setName('akkoord verklaring');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'f423d067-1aba-44f3-ac77-3923a6c748c6']),
        ]);
        $section->setStage($stage);

        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //6e pagina
        $stage = new Stage();
        $stage->setName('gegevens controleren');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('gegevens-controleren');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('gegevens controleren');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '74125607-0c91-4037-813e-43b87df15972']),
        ]);
        $section->setStage($stage);

        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        // formulier gegevens inzien en aanpassen

        $id = Uuid::fromString('3562f567-9bec-4993-81dd-c339dbb14fc6');
        $processType = new ProcessType();
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setName('formulier gegevens inzien en aanpassen');
        $processType->setDescription('hier kunt u uw eigen gegevens aanpassen en/of bekijken');
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => '4dcf25f2-c2dc-4a82-8a78-33e4d3d7241d']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id' => $id]);

//        // 1e pagina
//        $stage = new Stage();
//        $stage->setName('inloggen digiD');
//        $stage->setIcon('fal fa-users');
//        $stage->setSlug('inloggen-digid');
//        $stage->setProcess($processType);
//
//        $section = new Section();
//        $section->setName('inloggen met digiD');
//        $section->setProperties(['text']);
//        $section->setStage($stage);
//
//        $section->setStage($stage);
//        $stage->addSection($section);
//        $processType->addStage($stage);
//        $manager->persist($processType);
//        $manager->flush();

        //2e pagina
        $stage = new Stage();
        $stage->setName('inloggen');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('inloggen');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('inloggen en controleren');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '07a5c63f-faa2-4a50-8d56-6ac29eb2a20e']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '858eedae-5cab-48ed-94fe-4607af1df047']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'cad8e40a-ce4b-4c6d-a702-3d72f7910402']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'd3070f7f-2762-4d8e-b05b-f36183f60a1e']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'bdd227ca-b2f9-4847-8e40-eaddc070545e']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '6c8ade97-1281-42db-af85-eaeca7385df2']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '8de289e5-e361-4639-9b9e-5c2e88493b6b']),
        ]);
        $section->setStage($stage);

        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //3e pagina
        $stage = new Stage();
        $stage->setName('persoongegevens inzien');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('persoonsgegevens-inzien');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('persoonsgevens inzien');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '195c7e03-e3f5-4c71-bf66-b023d9f1bfe9']),
        ]);
        $section->setStage($stage);

        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //4e pagina
        $stage = new Stage();
        $stage->setName('redenering voor product of dienst');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('reden-product-dienst');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('persoonsgevens inzien');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'a9c105be-3265-4ccb-bd48-c18a571d5fde']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'fa528567-6f94-45f6-a2ca-bf8c2ba261a0']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '1f4f5156-5528-4cdc-b8af-91ea7c60f771']),
        ]);
        $section->setStage($stage);

        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //5e pagina
        $stage = new Stage();
        $stage->setName('controleren');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('controleren');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('controleren');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'f44234ab-1e3e-403e-87a0-6b2945f84969']),
        ]);
        $section->setStage($stage);
        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

// Aanvraagformulier mantelzorgwaardering
        $id = Uuid::fromString('230cb89b-7498-4955-af4a-df7f78b026f0');
        $processType = new ProcessType();
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setName('aanvraagformulier mantelzorgwaardering');
        $processType->setDescription('Omring regelt de mantelzorgwaardering in opdracht van de gemeente Hoorn. Uw gegevens worden ook gebruikt om u te informeren over ondersteuning voor mantelzorgers. ');
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => 'b5007212-5a5d-4203-ba82-704111ed678a']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id' => $id]);

        //1e pagina
        $stage = new Stage();
        $stage->setName('gegevens invoeren');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('gegevens-invoeren');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('gegevens zorgvrager');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '1fb54451-4622-4c44-93b0-5b47d0718f99']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'd0322d63-d10f-4463-998e-09b569625c37']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'f2b28f21-5e46-4221-995d-1db0fe68e307']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'c515f7b9-a4c9-4c2a-8edd-9d2ebc4afaf7']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'cb3f36fb-5d22-4332-bd70-001c5b46d9b4']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '1e4bcf57-da6b-42fe-9a59-b05d6594b5d4']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '19bedf4c-f4c5-4028-8d3d-3b2e8571edeb']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '8111d8c8-b926-45b0-9676-b62b8822cc30']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '3c3d77c4-ebef-41ab-9b7e-8e27c5d57dcb']),
        ]);
        $section->setStage($stage);

        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //2e pagina
        $stage = new Stage();
        $stage->setName('verzorger invoeren');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('verzorger-invoeren');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('gegevens mantelzorger');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '16dde21d-f1ee-44af-a3b5-ee9c8fe18da2']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '25ff8ecc-2ac1-4fa5-8098-114997107092']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '5b5c484a-c0ce-4567-9679-391cc50c0bc4']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '5c6ee285-b370-4197-b065-51dc6f78548d']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'd56aa23a-827a-42e8-9156-8521bc5073d9']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '1e650eb8-df71-42f2-b986-02d4457c9c1c']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '3d4eede1-2607-4c50-839d-0f759137ae07']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '3f83b803-ad8a-4788-b996-d163fad3b124']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'd3fd1220-97a7-4b9c-a14a-ce1d234801fd']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'e2db271d-349f-40f9-b2ef-b89c555a1416']),
        ]);
        $section->setStage($stage);

        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //3e pagina
        $stage = new Stage();
        $stage->setName('beschijving van uw mantelzorg');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('beschijving-mantelzorg');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('beschijving van uw mantelzorg');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '86906596-ab1a-43bc-bd15-36cf3e71d78c']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'd001466a-660b-4132-bbce-190e542f4bd5']),
        ]);
        $section->setStage($stage);

        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //4e pagina
        $stage = new Stage();
        $stage->setName('controleren van uw gegevens');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('gegevens-controleren');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('zijn uw gegevens correct ingevult?');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '1bebc7fc-ef67-4a2b-9999-628ea747a64d']),
        ]);
        $section->setStage($stage);


        //vormulier aansprakelijk stellen
        $id = Uuid::fromString('942fee77-2cb7-420e-a03c-4b1e3a470ec4');
        $processType = new ProcessType();
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setName('formulier aanspraakelijk stellen');
        $processType->setDescription('met dit formulier kunt u schade aanspraakelijk stellen voor de gemeente');
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => '']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id' => $id]);

        //1e pagina
        $stage = new Stage();
        $stage->setName('belangrijke informatie');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('belangrijke-informatie');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('belangrijke informatie');
        $section->setProperties([]);
        $section->setStage($stage);

        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //2e pagina
        $stage = new Stage();
        $stage->setName('uw gegevens');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('uw-gevens');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('uw gevens invullen');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'b93ed2e5-28ea-4ea6-af32-2ff4e6f588c9']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '6442816e-4657-4eb2-9d1b-ace895d01bd0']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '0f7117f2-91bf-4718-99cf-f6334285e03e']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '7a64a89a-ed40-474f-bfda-2e597d55df4f']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'e778b034-42fd-4675-a3de-98a557273d76']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'bd8e85ec-5f4d-4dcf-b5b4-3b808460ad3b']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '93dd4314-22a6-49e4-aab8-ee2ea6c07703']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'd4686644-8093-47d3-b3f8-f32a6843c556']),
        ]);
        $section->setStage($stage);

        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //3 pagina
        $stage = new Stage();
        $stage->setName('schade beschrijven');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('schade-beschrijven');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '0aea6d71-cc37-4385-96aa-d0840ec98c63']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '76eef960-8900-4a48-8d4f-e713bf0482b9']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'b5d4615e-c4b6-46c4-961a-8bf3d603d8c5']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'c6a5f469-33ed-45a1-ad97-12f0c8946247']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'f0cc0767-987b-4aa4-8679-4ef46a8f7e2b']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '7b128adb-c509-4758-83b9-73f4ed90d712']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'bb217564-0cdc-4e4c-929d-540259eddfb2']),
        ]);
        $section->setStage($stage);

        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //4 pagina
        $stage = new Stage();
        $stage->setName('controleren');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('controleren');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('zijn uw gegevens juist ingevult');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '1a195ef3-670b-40f6-8b69-c3f4e35a97d9']),
        ]);
        $section->setStage($stage);

        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        // formulier rioolaansluiting aanvragen
        $id = Uuid::fromString('8d0366b3-aab7-40c1-9dc3-fa29257a66e5');
        $processType = new ProcessType();
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setName('formulier rioolaansluiting aanvragen');
        $processType->setDescription('met dit formulier kunt u op één of meerdere andressen een rioolaansluiting aanvragen');
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => '050e77b5-2b45-420e-882c-a5ba115009dd']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id' => $id]);

        //pagina 1
        $stage = new Stage();
        $stage->setName('belangrijk');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('belangrijk');
        $stage->setProcess($processType);

        // hier moet belangrijke informatie gaan staan
//        $section = new Section();
//        $section->setName('belangrijke informatie');
//        $section->setProperties([]);
//        $section->setStage($stage);

        $section = new Section();
        $section->setName('datum van aansluiting');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'b0ca15ee-5d70-4690-9fff-75648ea27cdc']),
        ]);
        $section->setStage($stage);

        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //pagina 2
        $stage = new Stage();
        $stage->setName('uw gevenes');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('uw-gevens');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('voor hier uw gevens in');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '92b7486f-ac93-4b9f-a9a3-e1c33227ea7f']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '3ec13207-941d-48cb-a42b-165468c3cab9']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '3a90a783-01c2-43d6-b7dc-0f298a44db86']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '9bdeee05-09fb-450d-8389-a9f01c99b31d']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '53453802-05ad-4738-8f90-5f06544e8f39']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'ddd9d839-7eb8-41bb-b5de-25ee6635094b']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'def04167-a740-4c8d-a1a1-04c727cb7b21']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'e14ca727-0222-4119-8d8f-013b6f1aaa17']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'b5778134-3097-44d4-8677-03b688978f09']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '4641523e-7909-4992-8f14-f80a6b8c91aa']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'd7c4f365-4be6-4e7d-af6c-a6acb20702c9']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'e5d0f9ae-b866-46a7-8dcf-3bea33b0ee5d']),
        ]);
        $section->setStage($stage);

        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //pagina 3
        $stage = new Stage();
        $stage->setName('de aanvraag');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('de-aanvraag');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('de aanvraag');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '02ced63e-f5fb-4b4a-9ef2-b08e78131539']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '29475814-d2a7-46e3-9440-6ef9c37c27ee']),
        ]);
        $section->setStage($stage);

        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        // pagina 4
        $stage = new Stage();
        $stage->setName('adres van de aansluiting');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('adres-aansluiting');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('wat is het adres?');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'c8dc79c2-add3-4f18-9e8a-611e99ca3ac5']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '706f5ac6-3868-4dc4-a72b-5bce423b4d25']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '007cb4d4-2250-4f88-b681-19d5073b84f3']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'b009333d-d2ba-412c-a2d0-3cb252efac6f']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '07cc8b83-1994-4897-87fc-d9b0ac2b3bf8']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'd4d4c9ea-d7bf-4bda-9c2c-01b498496992']),
        ]);
        $section->setStage($stage);

        $section = new Section();
        $section->setName('aansluiting');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'b22f8399-348f-4941-a1b5-8f131436318e']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'da34cad8-b0fa-4186-991d-0233fda72c8d']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'd0bc423d-4050-4f47-9670-1082867c35d4']),
        ]);
        $section->setStage($stage);

        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //pagina 5

        $stage = new Stage();
        $stage->setName('bijlage');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('bijalge');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '59ebff67-f354-49b2-ad87-76f458045b4e']),
        ]);
        $section->setStage($stage);

        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        // pagina 6
        $stage = new Stage();
        $stage->setName('controleren');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('controleren');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('uw gegevens controleren');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '08f805cc-d4dd-4e14-a284-452408e67188']),
        ]);
        $section->setStage($stage);

        $section->setStage($stage);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();
    }
}
