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

class ConductionFixtures extends Fixture
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
            $this->params->get('app_domain') != 'conduction.nl' && strpos($this->params->get('app_domain'), 'conduction.nl') == false
        ) {
            return false;
        }

        /*
         *  Opdracht uitzetten
         */
        $id = Uuid::fromString('abff7693-ee71-4121-b286-db95627b40bf');
        $processType = new ProcessType();
        $processType->setName('Opdracht uitzetten');
        $processType->setIcon('fas fa-briefcase');
        $processType->setDescription('Een nieuwe opdracht uitzetten');
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'6a001c4c-911b-4b29-877d-122e362f519d']));
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'b8a221d2-4b5e-4439-9880-dbcd9d22f6b8']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage = new Stage();
        $stage->setName('Organisatie');
        $stage->setDescription('organisatie');
        $stage->setIcon('fas fa-building');
        $stage->setSlug('organisatie');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Organisatie');
        $section->setDescription('Bij welke organisatie werkt u?');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'b58bcc05-ce2f-494a-ab38-94bcde883bc9']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $stage = new Stage();
        $stage->setName('Opdracht titel');
        $stage->setDescription('opdracht titel');
        $stage->setIcon('fas fa-briefcase');
        $stage->setSlug('opdracht-titel');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Opdracht titel');
        $section->setDescription('Wat is de titel voor uw opdracht?');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'de43ecc0-4833-4d9d-a6ff-74ef8968b36e']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $stage = new Stage();
        $stage->setName('Opdracht beschrijving');
        $stage->setDescription('opdracht beschrijving');
        $stage->setIcon('fas fa-briefcase');
        $stage->setSlug('opdracht-beschrijving');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Opdracht beschrijving');
        $section->setDescription('Hoe zou u uw opdracht beschrijven?');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'6e911c19-13ac-47da-a329-6328cbfaf449']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        // Save it all to the db
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $manager->flush();
    }
}
