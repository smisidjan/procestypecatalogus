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
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'f423d067-1aba-44f3-ac77-3923a6c748c6']),
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
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'f44234ab-1e3e-403e-87a0-6b2945f84969']),
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
    }
}
