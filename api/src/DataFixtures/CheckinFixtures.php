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
            $this->params->get('app_domain') != 'zuiddrecht.nl' && strpos($this->params->get('app_domain'), 'zuiddrecht.nl') == false &&
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
        $processType->setDescription('Om als ondernemer gebruik te kunnen maken van de checking functionaliteit moet u deelnemen aan het platform, en een abonement afsluiten.');
        $processType->setInstructionText(file_get_contents(dirname(__FILE__).'/Resources/chin/onboarding/instruction.html.twig', 'r'));
        $processType->setSubmitText(file_get_contents(dirname(__FILE__).'/Resources/chin/onboarding/submit.html.twig', 'r'));
        $processType->setSubmittedText(file_get_contents(dirname(__FILE__).'/Resources/chin/onboarding/submitted.html.twig', 'r'));
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'c328e6b4-77f6-4c58-8544-4128452acc80']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage = new Stage();
        $stage->setName('Gegevens');
        $stage->setDescription('Wat zijn de gegevens van u en uw ondernemening?');
        $stage->setIcon('fas fa-user');
        $stage->setSlug('gegevens');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Uw gegevens');
        $section->setDescription('Wat zijn uw contactgegevens?');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'5fe949b5-6ce7-4394-a4c9-6ae0297dad5d']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Onderneming');
        $section->setDescription('Wat zijn de gegevens van uw onderneming');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'55dde78d-4a14-43c6-a0ff-d33b7b5f8bae']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'587babac-f23a-4fb0-8df8-ccd083a079cc']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'9e5c34dc-99da-423d-9a88-a4a3875a66fb']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'41122a46-4788-4ba1-aba9-b48f7f640ef8']),
        ]);

        $stage->addSection($section);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Abonnement');
        $section->setDescription('Om deel te kunnen nemen aan dit platform heeft u een abonement nodig, dat kost €25 per maand (excl btw) en moet vooraf worden gefactureerd en betaald. Daarnaast zijn er aditionele kosten voor het gebruik van IDIN en is er een fair use policy van 1500 checkins per maand. Meer details daarover vind u hier <a href=""></a>.</p><p>De eerste maand is echter een proef periode en (binnen de gestelde voorwaarde van het platform) gratis. Om na deze maand gebruik te kunnen maken van het platform kunt u via de ondernemings pagina een abonement afsluiten');
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
       *  Opvragen gegevens door GGD (Checkin)
       */
        $id = Uuid::fromString('7ea9a041-d96f-4f4b-adc1-e1a46ea8463d');
        $processType = new ProcessType();
        $processType->setName('Aanvraag GGD');
        $processType->setIcon('fa fa-user');
        $processType->setDescription('Via dit process kunt een GGD aanvraag voor bezoekers gegevens aan ons doorgeven zodat wij deze gegevens bij de GGD kunnen aanleveren');
        $processType->setInstructionText(file_get_contents(dirname(__FILE__).'/Resources/chin/onboarding/instruction.html.twig', 'r'));
        $processType->setSubmitText(file_get_contents(dirname(__FILE__).'/Resources/chin/onboarding/submit.html.twig', 'r'));
        $processType->setSubmittedText(file_get_contents(dirname(__FILE__).'/Resources/chin/onboarding/submitted.html.twig', 'r'));
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'c328e6b4-77f6-4c58-8544-4128452acc80']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage = new Stage();
        $stage->setName('Gemeentenlijke Gezondheids Dienst');
        $stage->setDescription('Om gegevens te verstrekken aan de GGD hebben wij twee zaken van u nodig, de gegevens van de GGD en een explicitie opdracht om deze gegevens te verstrekken');
        $stage->setIcon('fas fa-money-check');
        $stage->setSlug('gegevens');
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

        /*
       *  Opvragen gegevens door gebruiker (Checkin)
       */
        $id = Uuid::fromString('7f5bd18e-e3dd-4864-a2fb-24d118462396');
        $processType = new ProcessType();
        $processType->setName('Gegevens opvragen');
        $processType->setIcon('fa fa-user');
        $processType->setDescription('Als u positief getest bent voor covid-19 zal de GGD bij u gegevens opvragen ivm een contact onderzoek. U kunt deze gegevens hier downloaden');
        $processType->setInstructionText(file_get_contents(dirname(__FILE__).'/Resources/chin/onboarding/instruction.html.twig', 'r'));
        $processType->setSubmitText(file_get_contents(dirname(__FILE__).'/Resources/chin/onboarding/submit.html.twig', 'r'));
        $processType->setSubmittedText(file_get_contents(dirname(__FILE__).'/Resources/chin/onboarding/submitted.html.twig', 'r'));
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'c328e6b4-77f6-4c58-8544-4128452acc80']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage = new Stage();
        $stage->setName('Gegevens');
        $stage->setDescription('Waar moeten wij uw gevens naartoe verzenden?');
        $stage->setIcon('fas fa-money-check');
        $stage->setSlug('gegevens');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Uw contact gegevens');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'79c03b9d-204c-4650-a974-6756c06638ea']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'bf268ea7-4f08-4730-a5eb-fa6df870a24d']),
        ]);
        $stage->addSection($section);
    }
}
