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
            $this->params->get('app_domain') != 'zuid-drecht.nl' && strpos($this->params->get('app_domain'), 'zuid-drecht.nl') == false ||
            // Dev enviroment
            $this->params->get('app_env') != 'dev' && strpos($this->params->get('app_env'), 'dev') == false
        ) {
            return false;
        }

        return false;

        // formulier Inlichtingen BRP / Burgerlijke stand
        $id = Uuid::fromString('1d101ceb-e485-4e71-bd8c-8161fcc0c347');
        $processType = new ProcessType();
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setName('Inlichtingen BRP / Burgerlijke stand');
        $processType->setDescription('Advocaten, notarissen en gerechtsdeurwaarders gebruiken dit formulier voor een verzoek om inlichtingen uit de Basisregistratie Personen (BRP) of Burgerlijke stand');
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => '4dcf25f2-c2dc-4a82-8a78-33e4d3d7241d']));
        $processType->setIcon('fas fa-info');
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
        $stage->setDescription('selecteer hier hoe vaak u wat aanvraagt');
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
        $stage->setName('bijlagen toevoegen');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('bijlagen-toevoegen');
        $stage->setDescription('u kunt hier uw bijlage toevoegen door op bladeren te klikken');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('bijlagen toevoegen');
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
        $stage->setDescription('voer hier uw gegevens in');
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
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '38f796bc-d31c-4285-957b-1efbec38a653']),
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
        $stage->setDescription('voer hier de gegevens van de contact persoon in');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('gegevens contact persoon');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '2d8a9acb-653b-468e-8d0d-d5beb16e1c26']),
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
        $stage->setDescription('controleer hier of uw gegevens correct zijn');
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
        $processType->setName('gegevens inzien en aanpassen');
        $processType->setDescription('hier kunt u uw eigen gegevens aanpassen en/of bekijken');
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => '4dcf25f2-c2dc-4a82-8a78-33e4d3d7241d']));
        $processType->setIcon('fas fa-edit');
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
        $stage->setDescription('u kunt hier inloggen via DIGID en daarmee uw gegevens laten invullen');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('inloggen en controleren');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '1293b6df-12ac-4d3d-a35f-3b51d9c0a27a']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'e1257a68-651f-4ef9-a161-2e27e94d52e1']),
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
        $stage->setDescription('hier kunt u uw gegevens bekijken');
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
        $stage->setDescription('geef hier de reden waarvoor u de dienst of product aanvraagt');
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
        $stage->setDescription('controleer hier of uw gegevens correct zijn');
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
        $processType->setIcon('fas fa-user-nurse');
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
        $stage->setDescription('voer hier uw gegevens in');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('gegevens zorgvrager');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '1fb54451-4622-4c44-93b0-5b47d0718f99']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'd0322d63-d10f-4463-998e-09b569625c37']),
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
        $stage->setDescription('hier kunt u de informatie van uw mantelzorger invullen');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('gegevens mantelzorger');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '16dde21d-f1ee-44af-a3b5-ee9c8fe18da2']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '25ff8ecc-2ac1-4fa5-8098-114997107092']),
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
        $stage->setDescription('leg hier uit wat voor zorg u heeft ontvangen');
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
        $stage->setDescription('controleer hier uw gevens');
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
        $processType->setName('aanspraakelijk stellen');
        $processType->setDescription('met dit formulier kunt u schade aanspraakelijk stellen voor de gemeente');
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => '']));
        $processType->setIcon('fas fa-dumpster-fire');
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id' => $id]);

//        //1e pagina
//        $stage = new Stage();
//        $stage->setName('belangrijke informatie');
//        $stage->setIcon('fal fa-users');
//        $stage->setSlug('belangrijke-informatie');
//        $stage->setProcess($processType);
//
//
//        $section = new Section();
//        $section->setName('belangrijke informatie');
//        $section->setProperties([]);
//        $section->setStage($stage);
//
//        $section->setStage($stage);
//        $stage->addSection($section);
//        $processType->addStage($stage);
//        $manager->persist($processType);
//        $manager->flush();

        //2e pagina
        $stage = new Stage();
        $stage->setName('uw gegevens');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('uw-gevens');
        $stage->setDescription('voer hier uw eigen gegevens in');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('uw gevens invullen');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'b93ed2e5-28ea-4ea6-af32-2ff4e6f588c9']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '6442816e-4657-4eb2-9d1b-ace895d01bd0']),
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
        $stage->setDescription('beschrijf hier de schade');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setName('schade beschrijven');
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
        $stage->setDescription('controleer hier of uw gegevens kloppen');
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
    }
}
