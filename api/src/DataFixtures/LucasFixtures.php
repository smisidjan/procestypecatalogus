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
            $this->params->get('app_domain') != 'zuid-drecht.nl' && strpos($this->params->get('app_domain'), 'zuid-drecht.nl') == false
        ) {
            return false;
        }

        // Documenten Inleveren

        $id = Uuid::fromString('f5b473e9-a2d8-4383-b268-265c340f4bc5');
        $processType = new ProcessType();
        $processType->setName('Documenten inleveren');
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


        // Jeugdlintje
        $id = Uuid::fromString('a7b3f4d3-3973-4390-b10a-d10a7d99ff2b');
        $processType = new ProcessType();
        $processType->setName('Jeugdlintje - neem contact met mij op');
        $processType->setDescription('Gemeentelijke onderschijding (Jeugdlintje)');
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'f74294c8-f7af-4357-a819-738989e1da0b']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

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
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'7383ba2f-79e3-4419-8ba6-e959c708eb7a']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'5f2b3a7f-0c81-4f7a-baeb-7dafa453a23c']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'f8623f03-aa64-4a7b-809a-34996192e8e7']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'ca88b58c-e791-4b60-9d09-53bb69b64baf']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'b17119cc-303e-4f3a-a192-124821b71f3d']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'3bf1e76b-0cc7-4e5d-b7d9-1e963f7f7ff5']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        // Vraag Stellen
        $id = Uuid::fromString('3e758293-b910-490d-bc22-3941d61f9363');
        $processType = new ProcessType();
        $processType->setName('Vraag stellen');
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
    }
}
