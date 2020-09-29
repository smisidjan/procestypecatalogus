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

class CheckinFixtures extends Fixture
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
            $this->params->get('app_domain') != 'checking.nu' && strpos($this->params->get('app_domain'), 'checking.nu') == false &&
            $this->params->get('app_domain') != 'zuid-drecht.nl' && strpos($this->params->get('app_domain'), 'zuid-drecht.nl') == false
        ) {
            return false;
        }

        /*
         *  Deelname verzoek horeca ondernemer (Checkin)
         */
        $id = Uuid::fromString('fdb7186c-0ce9-4050-bd6d-cf83b0c162eb');
        $processType = new ProcessType();
        $processType->setName('Deelnemen aan het checking platform');
        $processType->setIcon('fa fa-user');
        $processType->setDescription('Om als horeca gebruik te kunnen maken van de checking functionaliteit moet u deelnemen aan het platform, en een abonement afsluiten.');
        $processType->setInstructionText(file_get_contents(dirname(__FILE__).'/Resources/chin/onboarding/instruction.html.twig', 'r'));
        $processType->setSubmitText(file_get_contents(dirname(__FILE__).'/Resources/chin/onboarding/submit.html.twig', 'r'));
        $processType->setSubmittedText(file_get_contents(dirname(__FILE__).'/Resources/chin/onboarding/submitted.html.twig', 'r'));
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'c328e6b4-77f6-4c58-8544-4128452acc80']));
        $processType->setLogin('none');
        $processType->setShowInstructionStage(false);
        $processType->setShowSubmitStage(false);
        $processType->setShowSubmittedStage(false);
        $processType->setSubmitText(false);
        $processType->setShowBackButton(false);
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage = new Stage();
        $stage->setName('Gegevens');
        $stage->setIcon('fas fa-user');
        $stage->setSlug('gegevens');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Uw gegevens');
        $section->setDescription('Wat zijn uw contactgegevens?');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'55dde78d-4a14-43c6-a0ff-d33b7b5f8bae']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Koningklijke horeca nederland');
        $section->setDescription('Als u lid bent van koningklijke horeca nederland kunt u hier uw lidmaarschats nummer opvoeren voor korting');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'587babac-f23a-4fb0-8df8-ccd083a079cc']),
        ]);

        $stage->addSection($section);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Abonnement');
        $section->setDescription('<p>Om deel te kunnen nemen aan dit platform heeft u normaal gesproken een abonnement nodig. De kosten hiervoor zijn opgebouwd met een vast bedrag van &euro;25 per maand (excl btw) en kosten per check in van &euro;0.40 per check in deze worden achteraf betaald. <b>Voor de twee weken pilot is dit gratis.</b></p><p> We gaan uit van een &ldquo;Fair-use&rdquo; door de deelnemers van dit platform. Dat betekent dat als iemand overmatig gebruik gaat maken hiervoor gaat betalen. De grens ligt bij 1500 check ins per maand. Kom je hier overheen dan zal er een opslag gelden van &euro;0.05 per check in worden gerekend.</p>');
        $section->setProperties([]);

        $stage->addSection($section);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Voorwaarden');
        $section->setDescription('Omdat we voor u gaan optreden als gegevens verwerker is het belangrijk dat we een aantal dingen goed regelen');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'fa79e0cd-2fcd-44bf-84e3-01e9253bdd7b']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'ce876e7e-8157-4468-b4ae-f72e04eabb74']),
        ]);

        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        /*
         *  Deelname verzoek ondernemer (Checkin)
         */
        $id = Uuid::fromString('3c296ef7-7b40-4ee8-b7ab-411f48dca4da');
        $processType = new ProcessType();
        $processType->setName('Deelnemen aan het checking platform als ondernemer');
        $processType->setIcon('fa fa-user');
        $processType->setDescription('');
        $processType->setInstructionText(file_get_contents(dirname(__FILE__).'/Resources/chin/onboarding/instruction_organization.html.twig', 'r'));
        $processType->setSubmitText(file_get_contents(dirname(__FILE__).'/Resources/chin/onboarding/submit_organization.html.twig', 'r'));
        $processType->setSubmittedText(file_get_contents(dirname(__FILE__).'/Resources/chin/onboarding/submitted_organization.html.twig', 'r'));
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'c328e6b4-77f6-4c58-8544-4128452acc80']));
        $processType->setLogin('none');
        $processType->setRetractable(false);
        $processType->setShowInstructionStage(true);
        $processType->setShowSubmitStage(true);
        $processType->setShowSubmittedStage(true);
        $processType->setShowBackButton(false);
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage = new Stage();
        $stage->setName('Gegevens');
        $stage->setIcon('fas fa-user');
        $stage->setSlug('gegevens');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Uw gegevens');
        $section->setDescription('Wat zijn uw contactgegevens?');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'55dde78d-4a14-43c6-a0ff-d33b7b5f8bae']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'f063f230-446d-468d-891d-0652e3ed9cad']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'6030339b-c807-47d9-bb69-118a5aded1d5']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'db597628-8cf4-493b-8488-131a7351a949']),

        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Abonnement');
        $section->setDescription('Om deel te kunnen nemen aan dit platform heeft u een abonnement nodig, dit kost €25 per maand (excl btw) en moet vooraf worden betaald. We gaan uit van een “Fair-use” door de deelnemers van dit platform. Dat betekent dat als iemand overmatig gebruik gaat maken hiervoor gaat betalen. De grens ligt bij 500 check ins per maand. Kom je hier overheen dan zal er een opslag gelden van €0.05 per check in worden gerekend. <br> De eerste week is echter een proef periode en (binnen de gestelde voorwaarde van het platform) gratis. Na deze week zal het abonnement ingaan.');
        $section->setProperties([]);

        $stage->addSection($section);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Voorwaarden');
        $section->setDescription('Omdat we voor u gaan optreden als gegevens verwerker is het belangrijk dat we een aantal dingen goed regelen');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'fa79e0cd-2fcd-44bf-84e3-01e9253bdd7b']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'1356dc18-1dba-4ff8-9c69-df181425842c']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'ce876e7e-8157-4468-b4ae-f72e04eabb74']),
        ]);

        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        /*
       *  Opvragen gegevens door GGD (Checkin)
       */
        $id = Uuid::fromString('7ea9a041-d96f-4f4b-adc1-e1a46ea8463d');
        $processType = new ProcessType();
        $processType->setName('Aanvraag GGD');
        $processType->setIcon('fa fa-user');
        $processType->setDescription('Via dit process kunt een GGD aanvraag voor bezoekers gegevens aan ons doorgeven zodat wij deze gegevens bij de GGD kunnen aanleveren');
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'b816e7d8-f7e3-4fd4-9e6f-5c5b29072b94']));
        $processType->setLogin('none');
        $processType->setShowInstructionStage(false);
        $processType->setShowSubmitStage(false);
        $processType->setShowSubmittedStage(false);
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage = new Stage();
        $stage->setName('Gemeentenlijke Gezondheids Dienst');
        $stage->setDescription('Om gegevens te verstrekken aan de GGD hebben wij twee zaken van u nodig, de gegevens van de GGD en een explicitie opdracht om deze gegevens te verstrekken');
        $stage->setIcon('fa fa-user');
        $stage->setSlug('gegevens-ggd');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Context van de aanvraag');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'5fe949b5-6ce7-4394-a4c9-6ae0297dad5d']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'7e536da6-cd5b-4141-9ef8-0c14fe5a238a']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'0e282256-ca2e-494c-8ebc-66839ec7534d']),
        ]);
        $stage->addSection($section);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Opdracht bevestiging');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'6035561c-8d93-40c2-82bb-1ddbf22b84cc']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'86ef664f-7ab4-43d7-8bea-8eece272d4ef']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        /*
       *  Opvragen gegevens door gebruiker (Checkin)
       */
        $id = Uuid::fromString('7f5bd18e-e3dd-4864-a2fb-24d118462396');
        $processType = new ProcessType();
        $processType->setName('Gegevens opvragen');
        $processType->setIcon('fa fa-user');
        $processType->setDescription('Als u positief getest bent voor covid-19 zal de GGD bij u gegevens opvragen ivm een contact onderzoek. U kunt deze gegevens hier downloaden');
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'39fe2fed-b5dc-42ce-9f9e-64101351b566']));
        $processType->setLogin('none');
        $processType->setShowInstructionStage(false);
        $processType->setShowSubmitStage(false);
        $processType->setShowSubmittedStage(false);
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage = new Stage();
        $stage->setName('Gegevens');
        $stage->setDescription('Waar moeten wij uw gevens naartoe verzenden?');
        $stage->setIcon('fa fa-user');
        $stage->setSlug('gegevens-gebruiker');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Uw contact gegevens');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'79c03b9d-204c-4650-a974-6756c06638ea']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'bf268ea7-4f08-4730-a5eb-fa6df870a24d']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        /*
       *  Contact Formulier (Checkin)
       */
        $id = Uuid::fromString('0465a588-b82a-436c-b9a5-2528c3608ec0');
        $processType = new ProcessType();
        $processType->setName('Contact formulier');
        $processType->setIcon('fas fa-clipboard-list');
        $processType->setDescription('Door dit proces te doorlopen kunt u contact opnemen met Conduction');
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'16b09e78-bca7-426d-b035-abfa101a9259']));
        $processType->setLogin('none');
        $processType->setShowInstructionStage(false);
        $processType->setShowSubmitStage(false);
        $processType->setShowSubmittedStage(false);
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage = new Stage();
        $stage->setName('Formulier');
        $stage->setDescription('Waarvoor wilt u contact opnemen? En wat zijn uw contact gegevens?');
        $stage->setIcon('fas fa-clipboard-list');
        $stage->setSlug('contactformulier');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Contact formulier');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'0586ea46-640f-43aa-af50-04c76268f912']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'20064385-f73b-401c-bfe3-2ec2b1fa6411']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Uw contact gegevens');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'54c7cfd5-bd6b-491e-a84e-047b26b4eebf']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        /*
       *  Idee Formulier (Checkin)
       */
        $id = Uuid::fromString('1e814be2-1a60-4869-9386-053826de19c4');
        $processType = new ProcessType();
        $processType->setName('Idee formulier');
        $processType->setIcon('fas fa-clipboard-list');
        $processType->setDescription('Door dit proces te doorlopen kunt u uw idee opsturen naar Conduction');
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'d92f1462-6a69-449f-8491-e6038af5ca82']));
        $processType->setLogin('none');
        $processType->setShowInstructionStage(false);
        $processType->setShowSubmitStage(false);
        $processType->setShowSubmittedStage(false);
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage = new Stage();
        $stage->setName('Formulier');
        $stage->setDescription('Wat is uw idee? En wat zijn uw contact gegevens?');
        $stage->setIcon('fas fa-clipboard-list');
        $stage->setSlug('ideeformulier');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Idee formulier');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'f7a04eea-8a00-46b1-bbe8-9ffd04fcb9c0']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'8dfc477e-dd31-43bb-8325-eac600a1f228']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'c8b4a8bf-f19c-4bd6-9e3f-3e7771cbf1b5']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Uw contact gegevens');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'c342f6c8-2cd6-4e11-96ae-20a26260fdf4']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();
    }
}
