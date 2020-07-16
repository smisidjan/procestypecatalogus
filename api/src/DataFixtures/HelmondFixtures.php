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

class HelmondFixtures extends Fixture
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
         *  Geboorte aangifte
         */
        $id = Uuid::fromString('504b2a88-223f-4e35-8043-f061ea8a6623');
        $processType = new ProcessType();
        $processType->setName('geboorte aangifte');
        $processType->setIcon('fas fa-parking');
        $processType->setDescription('Geboorte aangifte doen');
        $processType->setSourceOrganization('001709124');
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'504b2a88-223f-4e35-8043-f061ea8a6623']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $manager->flush();

        $stage = new Stage();
        $stage->setName('Geboorte aangifte');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('geboorte');
        $stage->setDescription('Geboorte aangifte');

        $section = new Section();
        $section->setName('Geboortedatum');
        $section->setDescription('Wanneer is uw kind geboren');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'2c4446ed-1b3a-42c4-86bd-2587f010895b']),
        ]);
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Ouders');
        $section->setDescription('Gegevens van de ouders');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'467d0c0e-6533-46fa-8ff5-2508e40cca65'])]);
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Naam');
        $section->setDescription('Naam van uw kind');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'c00cacae-1edd-44dc-bda2-9eb0c970318e'])]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();
    }
}
