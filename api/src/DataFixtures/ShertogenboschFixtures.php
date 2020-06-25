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

class ShertogenboschFixtures extends Fixture
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
        // Lets make sure we only run these fixtures on larping enviroment
        if (
            $this->params->get('app_domain') != 'shertogenbosch.commonground.nu' &&
            strpos($this->params->get('app_domain'), 'shertogenbosch.commonground.nu') == false &&
            $this->params->get('app_domain') != 's-hertogenbosch.commonground.nu' &&
            $this->params->get('app_domain') != 'verhuizen.accp.s-hertogenbosch.nl' &&
            strpos($this->params->get('app_domain'), 'verhuizen.accp.s-hertogenbosch.nl') == false &&
            $this->params->get('app_domain') != 'verhuizen=.s-hertogenbosch.nl' &&
            strpos($this->params->get('app_domain'), 'verhuizen.s-hertogenbosch.nl') == false &&
            strpos($this->params->get('app_domain'), 's-hertogenbosch.commonground.nu') == false &&
            $this->params->get('app_domain') != "zuid-drecht.nl" && strpos($this->params->get('app_domain'), "zuid-drecht.nl") == false
        ) {
            return false;
        }

        /*
         *  Verhuizen
         */
        $id = Uuid::fromString('c8de2851-332d-4284-b86e-ba0615694427');
        $processType = new ProcessType();
        $processType->setName('Verhuizen');
        $processType->setIcon('fal fa-truck-moving');
        $processType->setDescription('Het doorgeven van een verhuizing aan een gemeente ');
        $processType->setSourceOrganization('001709124');
        $processType->setRequestType($this->commonGroundService->cleanUrl(["component"=>"vtc","type"=>"request_types","id"=>"37812338-fa7c-46c5-a914-bcf17339a4c5"]));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage = new Stage();
        $stage->setName('Waarheen en Waneer');
        $stage->setDescription('Waarheen en waneer wilt u verhuizen');
        $stage->setIcon('fal fa-calendar');
        $stage->setSlug('gegevens');
        $stage->setProcess($processType);
        $manager->persist($stage);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Datum en tijd');
        $section->setDescription('Wanneer vindt het afscheid plaats?');
        $section->setProperties([]);

        $section->setProperties([
            $this->commonGroundService->cleanUrl(["component"=>"vtc","type"=>"properties","id"=>"77aa09c9-c3d5-4764-9670-9ea08362341b"]),
            $this->commonGroundService->cleanUrl(["component"=>"vtc","type"=>"properties","id"=>"4b77bd59-d198-4aaf-ae0c-f66b16a6893d"])
        ]);
        $manager->persist($section);

        $manager->flush();
    }
}
