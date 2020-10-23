<?php

namespace App\DataFixtures;

use App\Entity\ProcessType;
use App\Entity\Section;
use App\Entity\Stage;
use Conduction\CommonGroundBundle\Service\CommonGroundService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ZuiddrechtFixtures extends Fixture
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

        /*
         *  Parkeervergunning
         */
        $id = Uuid::fromString('993cefcc-de42-46f5-9289-5f24df5dd3c7');
        $processType = new ProcessType();
        $processType->setName('Parkeervergunning');
        $processType->setIcon('fas fa-parking');
        $processType->setDescription('Hier kunt u een parkeervergunning aanvragen.');
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => '4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => 'f86591ef-6964-412b-84de-261fd47c3288']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id' => $id]);

        $template = new \App\Entity\Template();
        $template->setName('Ontvangs bevestiging');
        $template->setDescription('Ontvangs bevestiging voor verzoeken');
        $template->setType('pdf');
        $template->setUri($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'templates', 'id'=>'bf8aff0a-ab65-4761-923b-890785c5d2fb']));
        $template->setProcessType($processType);
        $manager->persist($template);
        $manager->flush();

        $stage = new Stage();
        $stage->setName('Is er een eigen parkeergelegenheid bij uw woning?');
        $stage->setDescription('Is er een eigen parkeergelegenheid bij uw woning?');
        $stage->setIcon('fas fa-parking');
        $stage->setSlug('parkeergelegenheid');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Parkeergelegenheid');
        $section->setDescription('Is er een eigen parkeergelegenheid bij uw woning?');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '92461726-dc0a-4132-a466-4968a37f4620']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $stage = new Stage();
        $stage->setName('Vergunning oud adres');
        $stage->setDescription('vergunning oud adres');
        $stage->setIcon('fas fa-parking');
        $stage->setSlug('oud-adres');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('vergunning oud adres');
        $section->setDescription('Ik heb een vergunning op mijn oude adres en wil ook een vergunning op mijn nieuwe adres:');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '3539cb5f-6801-4f45-838f-9c592946a592']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $stage = new Stage();
        $stage->setName('kentekenbewijs');
        $stage->setDescription('kentekenbewijs');
        $stage->setIcon('fas fa-parking');
        $stage->setSlug('kentekenbewijs');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('kentekenbewijs');
        $section->setDescription('Staat uw naam op het kentenbewijs?');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'c3102b38-b07c-4392-8a31-e57d81b39d70']),
        ]);
        $stage->addSection($section);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Kenteken');
        $section->setDescription('');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '0ab3fbc1-ee3c-40d6-881b-84b5b331710f']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $stage = new Stage();
        $stage->setName('type voertuig');
        $stage->setDescription('type voertuig');
        $stage->setIcon('fas fa-parking');
        $stage->setSlug('type-voertuig');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('type voertuig');
        $section->setDescription('U vraagt een parkeervergunning aan voor een:');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'ee8acd31-8a5e-48e9-ac16-0f73543d18c5']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $stage = new Stage();
        $stage->setName('betalen');
        $stage->setDescription('betalen');
        $stage->setIcon('fas fa-parking');
        $stage->setSlug('betalen');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('betalen');
        $section->setDescription('Hoe wilt u betalen?');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'b3ebaedc-578b-43bd-bc7e-91e5a5235de4']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        /*
         *  Contact Formulier
         */
        $id = Uuid::fromString('d1118a40-cede-42e0-b5dd-ff38e837ab0b');
        $processType = new ProcessType();
        $processType->setName('Contact');
        $processType->setIcon('fas fa-envelope');
        $processType->setDescription('Via dit formulier neemt u contact met ons op.');
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => '4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => '3b76447e-1b4b-4b86-a582-8f6b4a5a8c6f']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id' => $id]);

        $stage = new Stage();
        $stage->setName('Contact');
        $stage->setIcon('fas fa-users');
        $stage->setSlug('contact');
        $stage->setDescription('Waarover wilt u contact hebben?');

        $section = new Section();
        $section->setName('Onderwerp');
        $section->setDescription('Waarover wilt u contact hebben?');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '4f34ac1b-8c0c-4f3d-b1c4-07e086be43fd']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '54b86107-aa93-45ce-a02f-8516390fd92b']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '78ede193-a0b4-4851-af0d-84252b1903d1']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $stage = new Stage();
        $stage->setName('Uw gegevens');
        $stage->setIcon('fas fa-users');
        $stage->setSlug('uw-gegevens');
        $stage->setDescription('Hoe kunnen wij u berijken');

        $section = new Section();
        $section->setName('Gegevens');
        $section->setDescription('Contact gegevens');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'beb0f9c5-fe0d-4826-84a6-6c91429f3235']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '1eb5f485-4e26-489f-a65d-9cf035e5da43']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        /*
         *  Ballie Afspraak
         */
        $id = Uuid::fromString('32293766-8b3a-43ee-9f16-ed67234ac309');
        $processType = new ProcessType();
        $processType->setName('Balie afspraak');
        $processType->setIcon('fas fa-calendar');
        $processType->setDescription('Via dit formulier kunt u een balie afspraak bij ons inplannen.');
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => '4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => '32293766-8b3a-43ee-9f16-ed67234ac309']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id' => $id]);

        $stage = new Stage();
        $stage->setName('Afspraak');
        $stage->setIcon('fas fa-users');
        $stage->setSlug('afspraak');
        $stage->setDescription('de details van uw afspraak');

        $section = new Section();
        $section->setName('Afspraak');
        $section->setDescription('Waneer wilt u langskomen bij de ballie?');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'b90265da-379e-4254-b6df-14f962a68212']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '1db8bb40-aa1d-4ddd-b4d7-d43c987869cb']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'bb4fd6ee-5dce-4b9f-a28a-c566d5542d07']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $stage = new Stage();
        $stage->setName('Uw gegevens');
        $stage->setIcon('fas fa-users');
        $stage->setSlug('uw-gegevens');
        $stage->setDescription('Hoe kunnen wij u berijken');

        $section = new Section();
        $section->setName('Contact');
        $section->setDescription('Uw contact gegevens');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '3ed36d5b-349f-42f2-a084-f2feb20899be']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'c4e88952-bd02-4832-886f-316bcbaf6ed4']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        /*
         *  Melding Openbare ruimte
         */
        $id = Uuid::fromString('8a3ec75e-186c-4085-bc7c-4e1c5bf250d0');
        $processType = new ProcessType();
        $processType->setName('Melding openbare ruimte');
        $processType->setIcon('fas fa-dumpster-fire');
        $processType->setDescription('Via dit formulier kunt u melding maken van een probleem in de openbare ruimte.');
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => '4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => '6541d18b-1666-4600-98e3-6f5df1a67423']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id' => $id]);

        $stage = new Stage();
        $stage->setName('Melding');
        $stage->setIcon('fas fa-users');
        $stage->setSlug('melding');
        $stage->setDescription('Wie treed op als belanghebbende?');

        $section = new Section();
        $section->setName('Beschrijf melding');
        $section->setDescription('Probeer het probleem zo zorgvuldig mogenlijk te omschrijven');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '67201efb-73e1-4aab-b28f-28ce5c9b5014']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '2f09a068-410e-4053-983a-604220c4facc']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);

        $stage = new Stage();
        $stage->setName('Uw gegevens');
        $stage->setIcon('fas fa-users');
        $stage->setSlug('uw-gegevens');
        $stage->setDescription('Hoe kunnen wij u berijken');

        $section = new Section();
        $section->setName('Contact');
        $section->setDescription('Uw contact gegevens');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'e7ffde88-60cc-41a7-a670-42ec4e8d17b8']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'b82581b4-04d5-4d9a-8b3f-90646505bf80']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        /*
         *  Huwelijk
         */

        $id = Uuid::fromString('b8955949-2d8d-4bfb-9c73-e5275bffa427');
        $processType = new ProcessType();
        $processType->setIcon('fas fa-rings-wedding');
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => '4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setName('Huwelijk / Partnerschap');
        $processType->setDescription('Als je gaat trouwen moet je veel regelen. Om je wat overzicht te geven hebben we hieronder een lijstje gemaakt van alles wat je met de gemeente moet regelen.');
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => 'd0badfff-1c90-4ddb-80fc-49842d806eaa']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id' => $id]);

        $stage = new Stage();
        $stage->setName('Hoe wilt u trouwen?');
        $stage->setIcon('fas fa-users');
        $stage->setSlug('huwelijk-ceremonie');
        $stage->setDescription('Wie treed op als belanghebbende?');

        $section = new Section();
        $section->setName('Soort huwelijk');
        $section->setDescription('Kies uw soort huwelijk');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '81ea285b-41c1-43ae-80f6-a8dc3c6825ff'])]);
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Plechtigheid');
        $section->setDescription('Kies uw soort plechtigheid');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'd16e3c3b-564b-4d8d-bad2-adb5ffac26ad'])]);
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Partner');
        $section->setDescription('Met wie wilt u trouwen');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '963162eb-c4b7-42f2-9b37-b8bcbf84117a'])]);
        $stage->addSection($section);

        $processType->addStage($stage);

        $stage = new Stage();
        $stage->setName('Ambtenaar');
        $stage->setIcon('fas fa-users');
        $stage->setSlug('ambtenaar-locatie');
        $stage->setDescription('Wie treed op als belanghebbende?');

        $section = new Section();
        $section->setName('Ambtenaar');
        $section->setDescription('Welke ambtenaar');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'c9937faf-ebc2-438c-b3bb-5590a3c63464'])]);
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Locatie');
        $section->setDescription('Locatie van het huwelijk');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '7a59202e-c830-4a2e-839c-c11a1ce62a6a'])]);
        $stage->addSection($section);

        $stage = new Stage();
        $stage->setName('Wanneer wilt u trouwen?');
        $stage->setIcon('fas fa-users');
        $stage->setSlug('datum');
        $stage->setDescription('Wie treed op als belanghebbende?');

        $section = new Section();
        $section->setName('Datum');
        $section->setDescription('Trouwen of partnerschap');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'e85fdb66-f8b6-4ca0-a3fb-32b11aaebcb2'])]);
        $stage->addSection($section);

        $processType->addStage($stage);

        $stage = new Stage();
        $stage->setName('Getuigen');
        $stage->setIcon('fas fa-users');
        $stage->setSlug('getuigen');
        $stage->setDescription('Wie treed op als belanghebbende?');

        $section = new Section();
        $section->setName('Getuigen');
        $section->setDescription('Uw getuigen');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '3a3b2d0e-7d93-4c4b-b313-30f7cdef0c06'])]);
        $stage->addSection($section);

        $processType->addStage($stage);

        $stage = new Stage();
        $stage->setName('Overige gegevens');
        $stage->setIcon('fas fa-users');
        $stage->setSlug('overig');
        $stage->setDescription('Wie treed op als belanghebbende?');

        $section = new Section();
        $section->setName('Naamsgebruik');
        $section->setDescription('Welke naam wilt u gebruiken');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '492f4687-71f3-48f0-aad8-70a2f1f3cd1a'])]);
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Taal');
        $section->setDescription('In welke taak wilt u het huwelijk hebben');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'd07d6fd3-7118-4e75-9ee6-407d494e1613'])]);
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Extras');
        $section->setDescription('hier kunt u kiezen uit extras');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'e6a8c45c-eae2-48a2-b215-81c3b5bf82df'])]);
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Opmerkingen');
        $section->setDescription('hier kunt u eventuele opmerkingen plaatsen');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '8a047a87-61fe-435c-95a8-ffc843a8e362'])]);
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Melding voorgenomen huwelijk');
        $section->setDescription('Wilt u een melding doen voor voorgenomen huwelijk');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'd46c0a9c-b6db-40da-af77-09f0037def57'])]);
        $stage->addSection($section);

        $processType->addStage($stage);

        // Save it all to the db
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id' => $id]);

        // Jeugdlintje
        $id = Uuid::fromString('9f7a7616-179f-4ca1-b91f-1ac73222fe0e');
        $processType = new ProcessType();
        $processType->setName('Aanmeldformulier jeugdlintje');
        $processType->setIcon('fas fa-medal');
        $processType->setDescription('Doe hier een aanvraag voor een jeugdlintje voor iemand in de gemeenschap');
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'466e7a07-1388-40f7-964b-b9d8725d4a60']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage = new Stage();
        $stage->setName('Gegevens van de jeugdige');
        $stage->setSlug('jeugdige-jeugdlintje');
        $stage->setDescription('Gegevens van de jeugdige');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Gegevens van de jeugdige:');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'58240c06-894b-46b0-a1bf-bb7b1782b9c4']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'f52be373-1cda-4361-80c8-e410200c3c70']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'5843033d-da97-487f-8415-92b3b524e7b3']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'198cc25b-1ce3-4e9b-a468-0796527574b8']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'346727c4-2fb6-4fe5-bd5f-edcc209bad43']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'909cb100-fb61-4829-ae40-de5bf0480746']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $stage = new Stage();
        $stage->setName('Gegevens van de aanmelder');
        $stage->setSlug('aanmelder-jeugdlintje');
        $stage->setDescription('Gegevens van de aanmelder');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Gegevens aanmelder:');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'9cca2fd5-1f93-444d-938a-f801aea96e3a']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'4c268c2f-0a79-4c88-a0dc-beb4c389064b']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'57c7dc2c-4ae4-47ef-97ad-af87ed5206a0']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'fad0ad0c-6b56-4a52-bd65-db0fd630a3d7']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $stage = new Stage();
        $stage->setName('Motivatie voor het jeugdlintje');
        $stage->setSlug('Motivatie-jeugdlintje');
        $stage->setDescription('Motiveert u hier zo uitgebreid mogelijk waarom u vindt dat de door u genomineerde jeugdige het jeugdlintje verdient.:');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Laat ons weten waarom de jeugdige een lintje verdient');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'666f81ee-8ed5-4533-9789-ce68ac34b708']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $stage = new Stage();
        $stage->setName('Referenties voor het jeugdlintje');
        $stage->setSlug('referenties-jeugdlintje');
        $stage->setDescription('Referenties voor het jeugdlintje');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Referentie 1:');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'185e24de-1f32-4da3-a81c-0993941b8419']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'a0602115-6d16-41c4-97ef-81de1d4a32d9']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'580ff714-0ce6-4398-93a2-d5a036609c3f']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'8f414746-89fe-440b-a3f0-6c920cab48de']),
        ]);
        $stage->addSection($section);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Referentie 2:');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'99fe1089-bdf4-4db1-be70-fcb85d19efdf']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'5a6f7003-ec42-46fd-b595-ff05dbd01f2e']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'6ee02cdf-b3df-484f-bf6d-d9a309f3f3b0']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'313d1d67-20ef-4886-86b8-ca682099a0a4']),
        ]);
        $stage->addSection($section);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Datum aanmelding');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'e1df079b-22b1-4952-a333-b70384a93f01']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        /*
         *  Chatbot Fixtures
         */

        /*
         *  Vermissingsformulier reisdocument
         */
        $id = Uuid::fromString('473fbb0e-7e73-47e4-bef7-564d25e17799');
        $processType = new ProcessType();
        $processType->setName('Vermissingsformulier reisdocument');
        $processType->setIcon('fas fa-id-card');
        $processType->setDescription('Via dit formulier kunt u bij ons aangeven wanneer u uw reisdocument verloren bent');
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => '4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => '4695d430-6cc2-4499-add4-a5e45ee84761']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id' => $id]);

        $stage = new Stage();
        $stage->setName('Het verloren document');
        $stage->setIcon('fas fa-users');
        $stage->setSlug('verloren-document');
        $stage->setDescription('Welk document bent u verloren?');

        $section = new Section();
        $section->setName('Keuze verloren document');
        $section->setDescription('Kies hier uw verloren document');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '1d92bc85-7e4c-4468-9588-44b7de598d8c']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);

        $stage = new Stage();
        $stage->setName('Uw persoons gegevens');
        $stage->setIcon('fas fa-users');
        $stage->setSlug('document-gegevens');
        $stage->setDescription('De gegevens gekoppeld aan dit reisdocument');

        $section = new Section();
        $section->setName('Persoons Gegevens');
        $section->setDescription('Uw Gegevens');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'f37dad7b-d7f4-4493-b9ba-814b0b0b2a8d']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        /*
         *  Toestemmingsformulier voor reisdocument kind
         */
        $id = Uuid::fromString('b2a1fba8-1fa3-44e9-aed5-fb42a6cdc1cd');
        $processType = new ProcessType();
        $processType->setName('Toestemmingsformulier voor reisdocument kind');
        $processType->setIcon('fas fa-id-card');
        $processType->setDescription('Via dit formulier kunt u bij ons toestemming geven voor een reisdocument van een kind');
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => '4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => '2d353bec-54a2-4a3b-81f3-cee6e5a06c99']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id' => $id]);

        $stage = new Stage();
        $stage->setName('Reisinformatie');
        $stage->setIcon('fas fa-users');
        $stage->setSlug('reis-informatie');
        $stage->setDescription('Ik/wij geef/geven de begeleidende persoon/personen toestemming om met bovengenoemd minderjarig
kind te reizen naar:');

        $section = new Section();
        $section->setName('Gegevens van de beoogde reis en verblijf');
        $section->setDescription('Vul hier de accomodatie en reisgegevens in');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '3daf4dbb-d8e2-4ced-a51e-0f6bf293e410']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '2942fcd0-84f8-444e-ad12-b668b9c17f8f']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '878be633-f3af-4b4a-a885-a35f54bd49cc']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '0964c49a-f640-4e2c-a5b8-21060f59d258']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'c36b3fed-afed-4e04-80c1-c11d1a04ce7c']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '9411c48c-587c-4b86-b56d-d3241daa9cd5']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '82246844-9a3c-4b35-96d4-e0a843992d3e']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'c07374e9-404c-42fa-a62d-e27072a01cd9']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        /*
         *  Emigreren naar het buitenland
         */
        $id = Uuid::fromString('ebaf13d3-b2f1-4a8a-ad6c-23e99c8831b2');
        $processType = new ProcessType();
        $processType->setIcon('fal fa-truck-moving');
        $processType->setSourceOrganization('0000');
        $processType->setName('Emigreren');
        $processType->setDescription('Het doorgeven van een Emigratie aan een gemeente');
        $processType->setRequestType("{$this->commonGroundService->getComponent('vtc')['location']}/request_types/0567df58-aca0-44f7-9efa-3b4585e03fc5");
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage1 = new Stage();
        $stage1->setName('Gegevens');
        $stage1->setIcon('fal fa-map-marked');
        $stage1->setSlug('gegevens');
        $stage1->setDescription('De gegevens van de Emigratie');
        $stage1->setProcess($processType);
        $manager->persist($stage1);

        $section1 = new Section();
        $section1->setStage($stage1);
        $section1->setName('Datum');
        $section1->setDescription('Wat is de Emigratie datum?');
        $section1->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/fc470862-7bf3-41e9-9b98-5f3a7ae9b3bd"]);
        $manager->persist($section1);

        $section2 = new Section();
        $section2->setStage($stage1);
        $section2->setName('Adres');
        $section2->setDescription('Waarheen Emigreerd u?');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '222d82c9-e281-4cd6-9f5b-b6feaa4e86f3']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '1ee404c5-003d-422c-a061-fd89bc4c47ea']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'a0d53f41-5f19-4d5c-b8f0-284e83d78e68']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '75eefbc2-b628-42f3-9c96-4a7ba10dbc28']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '72c1bd35-f385-4a88-8bb1-0fcd628b2f4c']),
        ]);
        $manager->persist($section2);

        $stage2 = new Stage();
        $stage2->setName('Emigrerende');
        $stage2->setDescription('De gegevens van de emigrerende');
        $stage2->setIcon('fal fa-users');
        $stage2->setSlug('emigrerende');
        $stage2->setProcess($processType);
        $manager->persist($stage2);

        $section1 = new Section();
        $section1->setStage($stage2);
        $section1->setName('emigrerende');
        $section1->setDescription('Wie emigreren er mee?');
        $section1->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/1972409b-1262-43c8-ba31-833ab283d171"]);
        $manager->persist($section1);

        //		$stage2= new Stage();
        //		$stage2->setPrevious($stage1);
        //		$stage2->setName('Adress');
        //		$stage2->setIcon('fal fa-map-marked');
        //		$stage2->setSlug('adress');
        //		$stage2->setType('string');
        //		$stage2->setDescription('Wat is het nieuwe adres?');
        //		$stage2->setProcess($processType);
        //		$manager->persist($stage2);
//
        //		$stage3= new Stage();
        //		$stage3->setPrevious($stage2);
        //		//$property->setId('');
        //		$stage3->setName('Wie');
        //		$stage3->setIcon('fal fa-users');
        //		$stage3->setSlug('verhuizenden');
        //		$stage3->setType('array');
        //		$stage3->setDescription('Wie gaan er verhuizen?');
        //		$stage3->setProcess($processType);
        //		$manager->persist($stage3);

        $stage4 = new Stage();
        $stage4->setName('Indienen');
        $stage4->setIcon('fal fa-paper-plane');
        $stage4->setSlug('indienen');
        $stage4->setDescription('Dien uw aanvraag in');
        $stage4->setProcess($processType);
        $manager->persist($stage4);

        $manager->flush();

        /*$id = Uuid::fromString('9d76fb58-0711-4437-acc4-9f4d9d403cdf');
        $processType = new ProcessType();
        $processType->setName('Emigratie');
        $processType->setIcon('fal fa-truck-moving');
        $processType->setDescription('Het doorgeven van een emigratie aan de gemeente \'s-Hertogenbosch');
        $processType->setSourceOrganization('001709124');
        $processType->setRequestType('https://vtc.zaakonline.nl/requestType/9d76fb58-0711-4437-acc4-9f4d9d403cdf');
        $processType->setExtends($processType);
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage1 = new Stage();
        $stage1->setStart(true);
        //$verhuizenNL->setId('');
        $stage1->setName('Email');
        $stage1->setIcon('fal fa-envelope');
        $stage1->setSlug('email');
        $stage1->setDescription('Het e-mail addres dat wordt gebruikt om contact op te nemen (indien nodig) over deze emigratie');
        //		$stage1->setType('string');
        $stage1->setProcess($processType);
        $manager->persist($stage1);

        $stage2 = new Stage();
        $stage2->setPrevious($stage1);
        //$verhuizenNL->setId('');
        $stage2->setName('Telefoon');
        $stage2->setIcon('fal fa-phone');
        $stage2->setSlug('telefoon');
        $stage2->setDescription('Het telefoon nummer dat wordt gebruikt om contact op te nemen (indien nodig) over deze emigratie');
        //		$stage2->setType('string');
        $stage2->setProcess($processType);
        $manager->persist($stage2);*/


        /*
         *  BRP-uittreksel aanvragen
         */
        $id = Uuid::fromString('fab5e59c-db92-43eb-9d99-5dcc0ece069d');
        $processType = new ProcessType();
        $processType->setName('BRP-uittreksel aanvragen');
        $processType->setIcon('fas fa-file-alt');
        $processType->setDescription('Via dit formulier kunt u bij ons een BRP-uittreksel aanvragen');
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => '4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => '9aa0fcf5-ad95-4e2d-b272-d36656e72a82']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id' => $id]);

        $stage = new Stage();
        $stage->setName('Uw persoons gegevens');
        $stage->setIcon('fas fa-users');
        $stage->setSlug('aanvrager-gegevens');
        $stage->setDescription('De gegevens van de aanvrager');

        $section = new Section();
        $section->setName('Persoons Gegevens van de aanvrager');
        $section->setDescription('Uw Gegevens');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'fce828db-1110-4ee7-a828-291517b6bad7']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '3c1c8517-03c2-43f1-9ef4-86136ee3aecd']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '1d21a50d-dd29-4051-80cd-970d6e793f15']),

        ]);
        $stage->addSection($section);

        $processType->addStage($stage);

        $stage = new Stage();
        $stage->setName('Opties voor BRP-uittreksel');
        $stage->setIcon('fas fa-users');
        $stage->setSlug('opties-brpuittreksel');
        $stage->setDescription('Welke optie van de BRP-uittreksel wilt u?');

        $section = new Section();
        $section->setName('Keuze opties BRP-uittreksel');
        $section->setDescription('Kies hier de gewensde optie');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'fb77df2e-d33e-4956-8aa4-5bb2ba5e75c3']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();
    }
}
