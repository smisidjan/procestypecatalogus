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

        /*
            * Opdracht contact formulier
            */

        $id = Uuid::fromString('c836945e-ef8e-48a5-bdfa-a89b22a0beff');
        $processType = new ProcessType();
        $processType->setName('Contact formulier');
        $processType->setDescription('Neem contact met ons op.');
        $processType->setRequestType($this->commonGroundService->clearUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => '47e9675d-fd72-435b-93c9-32aea32815ed']));
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id' => $id]);

        $stage = new Stage();
        $stage->setName('Contact');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('contactform');
        $stage->setDescription('Neem contact met ons op.');

        $section = new Section();
        $section->setName('Onderwerp');
        $section->setDescription('Waarover wilt u contact hebben?');
        $section->setProperties([
            $this->commonGroundService->clearUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '0ab6b17e-4020-47f7-9b33-beb10275ba7b']),
            $this->commonGroundService->clearUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '708dbd31-4365-47f1-85fa-facde400afcb'])
        ]);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $stage = new Stage();
        $stage->setName('Uw gegevens');
        $stage->setSlug('uw-gegevens');
        $stage->setDescription('Uw contact gegevens');

        $section = new Section();
        $section->setName('Uw gegevens');
        $section->setDescription('Uw contact gegevens');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '91d4faea-2fec-4a48-85f1-4b03a261a56b']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '303b4bc2-198d-4fd7-9123-7c736fc45e80'])
        ]);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();



        //zorg formulier
        $id = Uuid::fromString('6ea049ca-a24a-40b8-b854-2544c9b813c3');
        $processType = new ProcessType();
        $processType->setName('Direct zorg aanvragen.');
        $processType->setDescription('Dit aanmeldformulier is voor bewoners van Zuid Drecht die zorg en/of ondersteuning nodig hebben. De gegevens uit dit aanmeldformulier worden opgeslagen en besproken binnen het team van Zuid Drecht.');
        $processType->setRequestType($this->commonGroundService->clearUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => 'ffa22c00-6622-4cf3-8e97-682459a28d2d']));
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id' => $id]);

        //1ste pagina
        $stage = new Stage();
        $stage->setName('Aanmelden');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('zorgform');
        $stage->setDescription('Dit aanmeldformulier is voor bewoners van Zuid Drecht die zorg en/of ondersteuning nodig hebben. De gegevens uit dit aanmeldformulier worden opgeslagen en besproken binnen het team van Zuid Drecht');

        $section = new Section();
        $section->setProperties([
            $this->commonGroundService->clearUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '621a9799-0eb8-4242-b2d5-aa4c7ac5e62b']),
            $this->commonGroundService->clearUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'e5b77291-5ba1-49f3-a8c7-0e94a1df0dfe']),
            $this->commonGroundService->clearUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '5e286dc3-c7b8-4f09-8bd0-7daa0db21881'])
        ]);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //2e pagina
        $stage = new Stage();
        $stage->setName('Contactgegevens');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('contact');

        $section = new Section();
        $section->setProperties([
            $this->commonGroundService->clearUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'fb2fd447-3492-4f32-9850-d48e1f8b34c3']),
            $this->commonGroundService->clearUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '033730a1-0beb-40a4-9f5d-9fae5ceb27cf']),
            $this->commonGroundService->clearUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '1bfea7c2-bf99-4c40-bcf9-6297960c8e47']),
            $this->commonGroundService->clearUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '21aac5fd-a0a3-4613-a181-b124dd5e236e']),
            $this->commonGroundService->clearUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '63a2ac70-2b93-4538-b777-27264f96b7f9']),
            $this->commonGroundService->clearUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '3e654833-dd90-41dd-befb-88aa70b095b4']),
            $this->commonGroundService->clearUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '9d20977b-9297-4f39-8102-4d4cbf31bb1d']),
            $this->commonGroundService->clearUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '87e71ad1-f985-4f0a-a03f-524b1d045588']),
            $this->commonGroundService->clearUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'ff25b852-280c-423f-882a-37e6e8450569']),
            $this->commonGroundService->clearUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '56e115f6-aaa4-437f-80f6-252ff4ea0b84']),
            $this->commonGroundService->clearUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'b8835509-40a0-4d7a-958d-f4c72f726bfe']),
            $this->commonGroundService->clearUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '2b22534f-7982-42b6-98d5-c91f5b93eddd']),
            $this->commonGroundService->clearUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '642c8a72-8f73-4531-ad1b-63e0580a7a77'])

        ]);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //3de pagina
        $stage = new Stage();
        $stage->setName('Taal');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('taal');

        $section->setProperties([
            $this->commonGroundService->clearUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '688a2e68-55c3-4dde-aaf6-339b918ae137'])
        ]);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //4de pagina
        $stage = new Stage();
        $stage->setName('Betrokkenen');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('betrokkenen');

        $section->setProperties([
            $this->commonGroundService->clearUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '5c3ba3db-bf7a-40d3-8f94-201a885f8df0']),
            $this->commonGroundService->clearUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '88f0d590-7fc4-4097-90fa-8406799ea13c']),
            $this->commonGroundService->clearUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '0d1ffdb0-23cf-4431-8c6e-1db2a88b7e4c'])

        ]);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //5de pagina
        $stage = new Stage();
        $stage->setName('Reden van aanmelding');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('reden-aanmelding');

        $section->setProperties([
            $this->commonGroundService->clearUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '0a2ff1c2-0712-4c08-964e-524b1ad66513']),
            $this->commonGroundService->clearUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '4276abce-e9b5-4360-a255-1d45a4a94bcc']),
            $this->commonGroundService->clearUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'cc9d2eba-b050-46e2-bc90-407e0bde4baf'])

        ]);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        //6de pagina
        $stage = new Stage();
        $stage->setName('Overige opmerkingen');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('overige-opmerkingen');

        $section->setProperties([
            $this->commonGroundService->clearUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '1cbd9f75-6689-405e-9d84-e6459870a941']),
            $this->commonGroundService->clearUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '65002f0c-8b16-496f-9298-70e89c08b67f'])
        ]);
        $stage->addSection($section);
        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();
    }
}
