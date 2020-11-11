<?php

namespace App\DataFixtures;

use App\Entity\ProcessType;
use App\Entity\Section;
use App\Entity\Stage;
use Conduction\CommonGroundBundle\Service\CommonGroundService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class CommongroundNuFixtures extends Fixture
{
    private CommonGroundService $commonGroundService;
    private ParameterBagInterface $params;

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
            ($this->params->get('app_domain') != 'commonground.nu' && strpos($this->params->get('app_domain'), 'commonground.nu') == false)
        ) {
            return false;
        }

        $process = new ProcessType();
        $process->setName('Cluster aanvragen');
        $process->setDescription('Proces om een cluster aan te vragen op Commonground.nu');
        $process->setLogin('none');
        $process->setAudience('public');
        $process->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'d280c4d3-6310-46db-9934-5285ec7d0d5e']));
        $process->setRequestType($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'3d69a87a-d9c7-403d-9ee3-be5fe5f50671']));

        $manager->persist($process);
        $manager->flush();

        $stage = new Stage();
        $stage->setName('Gegevens');
        $stage->setOrderNumber(1);
        $stage->setSlug('gegevens');
        $stage->setDescription('De gegevens die nodig zijn om het cluster te kunnen opstarten');

        $section = new Section();
        $section->setName('Naam');
        $section->setDescription('De naam van het cluster');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'234d4603-32db-4fd8-8513-813e103ad49c'])]);
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Gemeente');
        $section->setDescription('De gemeente waarvoor het cluster wordt aangevraagd');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'9121aa72-3803-4755-87d3-156a73123bbc'])]);
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Contactpersoon');
        $section->setDescription('De contactpersoon voor het cluster');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'fe5d83c9-d3bc-47b1-a926-c00ef1d564fa'])]);
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Betaalgegevens');
        $section->setDescription('De betaalgegevens van de gemeente');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'fe5d83c9-d3bc-47b1-a926-c00ef1d564fa'])]);
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Factuurgegevens');
        $section->setDescription('De factuurgegevens van de gemeente');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'fe5d83c9-d3bc-47b1-a926-c00ef1d564fa'])]);
        $stage->addSection($section);

        $manager->flush();
    }
}
