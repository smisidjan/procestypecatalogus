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

class LucasFixtures extends Fixture
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
            $this->params->get('app_domain') != 'zuid-drecht.nl' && strpos($this->params->get('app_domain'), 'zuid-drecht.nl') == false &&
            // Dev enviroment
            $this->params->get('app_env') != 'dev' && strpos($this->params->get('app_env'), 'dev') == false

        ) {
            return false;
        }

        // Documenten Inleveren
        $id = Uuid::fromString('f5b473e9-a2d8-4383-b268-265c340f4bc5');
        $processType = new ProcessType();
        $processType->setName('Documenten inleveren');
        $processType->setIcon('fas fa-file-alt');
        $processType->setDescription('Hier kunt u aanvullende documenten of informatie inleveren.');
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'ff3a0263-350f-407a-84d4-bd12e89ce040']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage = new Stage();
        $stage->setName('Documenten Inleveren');
        $stage->setDescription('Aanvullende documenten inleveren!');
        $stage->setSlug('documenten-inleveren');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Documenten Inleveren');
        $section->setDescription('Aanvullende documenten inleveren!');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'d1ef9c92-06ed-4f2c-9c6d-86247da1edf1']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'1f36f5c1-5b69-4c07-91d9-dd1eac0e18fc']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'3df6b0e8-ca2b-4767-add9-72f37f103089']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'4b570558-9aff-4a96-9304-0b1f1aa933fc']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();


        // Vraag Stellen
        $id = Uuid::fromString('3e758293-b910-490d-bc22-3941d61f9363');
        $processType = new ProcessType();
        $processType->setName('Vraag stellen');
        $processType->setIcon('fas fa-question');
        $processType->setDescription('Algemeen contactformulier');
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'cf2482fd-5bed-4843-8f54-895cabdf6251']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage = new Stage();
        $stage->setName('Omschrijving');
        $stage->setDescription('De omschrijving van de vraag die u heeft.');
        $stage->setSlug('omschrijving');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Omschrijving');
        $section->setDescription('De vraag die u wilt stellen.');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'3de7512b-1fe0-4c70-8667-d765ef6c1e88']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'c9e351f1-41c1-4274-af38-ed9f18611cf5']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'d2dae617-12f2-41d4-b976-e78dd86c08ea']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $stage = new Stage();
        $stage->setName('Uw gegevens');
        $stage->setDescription('Uw gegevens invullen.');
        $stage->setSlug('uw-gegevens');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Uw gegevens');
        $section->setDescription('Uw gegevens invullen.');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'66df1173-ccb4-45f6-86e3-689f517a693c']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'147583a4-6a01-4422-9c60-fbe6e705bc3e']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'59d82428-0caf-47eb-a8df-2daf996b8f2f']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'fa4fb441-bc3e-4e4f-8ec0-df5386260917']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'3f2a0ecb-5f4f-4519-abc1-857a9b36fe38']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'e48c567d-c542-409e-b9dd-3f2934bc874f']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        // Kraskaarten
        $id = Uuid::fromString('30f26d23-acb4-4dda-b944-b336ef00ff52');
        $processType = new ProcessType();
        $processType->setName('Kraskaarten');
        $processType->setIcon('fas fa-money-check-alt');
        $processType->setDescription('Via dit formulier kunt u kraskaarten aanvragen.');
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'c64bb62c-670a-4cde-bd29-f50c220a6442']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage = new Stage();
        $stage->setName('Uw gegevens');
        $stage->setDescription('Uw persoonlijke gegevens invullen.');
        $stage->setSlug('uw-gegevens');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Uw gegevens');
        $section->setDescription('Uw persoonlijke gegevens invullen.');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'aa636080-5e9d-4909-80fd-0df8a6cb8754']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'87eec012-befe-45f8-b64d-62f3b2d26f11']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'1ec4376e-c5e9-47cf-aa36-617615bf5b28']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $stage = new Stage();
        $stage->setName('Kraskaarten');
        $stage->setDescription('Kraskaart kopen');
        $stage->setSlug('kraskaart');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Kraskaarten');
        $section->setDescription('Kraskaart kopen');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'bed1d4f6-b16f-414d-a951-1ca7c41be66e']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'19f3f27c-ae2f-41b2-874d-883020a7f472']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'2762debf-a021-40c2-8f5b-83c29bb833cc']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'eace7bd9-8bff-4f6c-badb-e028a338890f']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        // Starterslening
        $id = Uuid::fromString('3bfc975f-6ca6-4c65-813a-6c4da973f6e0');
        $processType = new ProcessType();
        $processType->setName('Starterslening');
        $processType->setIcon('fas fa-piggy-bank');
        $processType->setDescription('Een starterslening aanvragen');
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'2f3f2c71-f9b0-463d-8cf3-8dc5cdfeeaeb']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage = new Stage();
        $stage->setName('Uw gegevens');
        $stage->setDescription('Uw persoonlijke gegevens invullen.');
        $stage->setSlug('uw-gegevens');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Uw gegevens');
        $section->setDescription('Uw persoonlijke gegevens invullen.');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'3770c5d1-8f65-4621-96d1-d48fd2edc1bb']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'0ddd501e-e027-425f-a244-fa56f25e2fe8']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'0f733b39-345e-4932-aae3-aac2db039fc2']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $stage = new Stage();
        $stage->setName('Uw aanvraag');
        $stage->setDescription('Uw aanvraag invullen');
        $stage->setSlug('uw-aanvraag');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Uw aanvraag');
        $section->setDescription('Uw aanvraag invullen!');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'2c039392-2a56-44eb-bccd-abff50a738be']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'3c202c35-e52f-4ff4-8b76-98ab89908453']),
        ]);
        $stage->addSection($section);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Bestaand of nieuw');
        $section->setDescription('Is het bestaand of nieuw!');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'56373990-5ec5-4b38-83ac-b01d8a803e54']),
        ]);
        $stage->addSection($section);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Adres');
        $section->setDescription('Wat is het adres van het huis?');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'6f9aced9-6efe-40ff-b375-2d0b00681cc9']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'9195fc6b-a88b-495e-94d0-ba592f42deaf']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'13cfc0b4-c058-4f65-a249-aa0de1b8de1b']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'7532c9c8-a1bb-483b-8d77-57756080f9fc']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'bef59e64-9bad-41d0-b45d-f8c3dfa64e95']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'e0037ba7-84ce-4404-bd73-63fc5ce160f0']),
        ]);
        $stage->addSection($section);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Informatie Betalen');
        $section->setDescription('Uw betaalgegevens invullen!');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'50c04e5d-b834-4d52-af52-86f76707b022']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'04676a04-a19f-4766-9ead-f01cced3e965']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'28c62604-c111-44b2-aab2-9bf9372d4a82']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'01f523c7-d16b-406f-bae9-b08bab07fb4b']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'6a7eb28c-ac99-4b9c-80d3-0b32c8fcf47d']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();
    }
}
