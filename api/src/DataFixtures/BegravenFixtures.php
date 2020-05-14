<?php

namespace App\DataFixtures;

use App\Entity\Section;
use App\Entity\Stage;
use App\Entity\ProcessType;
use Conduction\CommonGroundBundle\Service\CommonGroundService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class BegravenFixtures extends Fixture
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
        if (strpos($this->params->get('app_domain'), "begraven.zaakonline.nl") == false && $this->params->get('app_domain') != "begraven.zaakonline.nl") {
            return false;
        }

		/*
		 *  Verhuizen
		 */
        $id = Uuid::fromString('a8b8ce49-d5db-4270-9e42-4b47902fc817');
        $begraven= new ProcessType();
        $begraven->setIcon('fal fa-truck-moving');
        $begraven->setSourceOrganization('0000');
        $begraven->setName('Begraven');
        $begraven->setDescription('Plan een begrafenis op een gekozen begraafplaats');
        $begraven->setRequestType("{$this->commonGroundService->getComponent('vtc')['location']}/request_types/c2e9824e-2566-460f-ab4c-905f20cddb6c");
        $manager->persist($begraven);
		$begraven->setId($id);
		$manager->persist($begraven);
		$manager->flush();
		$begraven = $manager->getRepository('App:ProcessType')->findOneBy(array('id'=> $id));

		$stage1 = new Stage();
		$stage1->setStart(true);
		$stage1->setName('Begraafplaats');
		$stage1->setIcon('fal fa-headstone');
		$stage1->setSlug('begraafplaats');
		$stage1->setDescription('De gegevens van de verhuizing');
		$stage1->setProcess($begraven);
		$manager->persist($stage1);

		$section1 = new Section();
		$section1->setStage($stage1);
		$section1->setStart(true);
		$section1->setName('Gemeente');
		$section1->setDescription('In welke gemeente wilt u iemand begraven?');
		$section1->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/72fdd281-c60d-4e2d-8b7d-d266303bdc46"]);
		$manager->persist($section1);

		$section2 = new Section();
		$section2->setStage($stage1);
		$section2->setName('Begraafplaats');
		$section2->setDescription('Op welke begraafplaats wilt u iemand begraven?');
		$section2->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/bdae2f7b-21c3-4d88-be6d-a35b31c13916"]);
		$section2->setPrevious($section1);
		$manager->persist($section2);

		$section3 = new Section();
		$section3->setStage($stage1);
		$section3->setName('Soort graf');
		$section3->setDescription('Wat voor soort graf wilt u iemand in begraven?');
		$section3->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/3b6a637d-19c6-4730-b322-c03d0d8301b6"]);
		$section3->setPrevious($section2);
		$manager->persist($section3);

		$stage2 = new Stage();
		$stage2->setName('Datum en tijd');
		$stage2->setDescription("Wanneer gaat het afscheid plaatsvinden?");
		$stage2->setIcon('fal fa-calendar');
		$stage2->setSlug('datum');
		$stage2->setProcess($begraven);
		$stage2->setPrevious($stage1);
		$manager->persist($stage2);

		$section1 = new Section();
		$section1->setStage($stage2);
		$section1->setStart(true);
		$section1->setName('Datum en tijd');
		$section1->setDescription('Wanneer vindt het afscheid plaats?');
		$section1->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/b1fd7b38-384b-47ec-a0f2-6f81949cdece"]);
		$manager->persist($section1);

		$stage3= new Stage();
		$stage3->setPrevious($stage1);
		$stage3->setName('Artikelen');
		$stage3->setIcon('fal fa-map-tasks');
		$stage3->setSlug('artikelen');
		$stage3->setType('string');
		$stage3->setDescription('Wat is het nieuwe adres?');
		$stage3->setProcess($begraven);
		$manager->persist($stage2);

        $section1 = new Section();
        $section1->setStage($stage2);
        $section1->setStart(true);
        $section1->setName('Artikelen');
        $section1->setDescription('Selecteer hier de artikelen voor de begrafenis.');
        $section1->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/8f9adb13-d5e0-40de-a08c-a2ce5a648b1e"]);
        $manager->persist($section1);

		$stage4= new Stage();
		$stage4->setPrevious($stage3);
		//$property->setId('');
		$stage4->setName('Overledene');
		$stage4->setIcon('fal fa-users');
		$stage4->setSlug('overledene');
		$stage4->setType('array');
		$stage4->setDescription('Wie gaan er begraven?');
		$stage4->setProcess($begraven);
		$manager->persist($stage4);

        $section1 = new Section();
        $section1->setStage($stage2);
        $section1->setStart(true);
        $section1->setName('Overledene');
        $section1->setDescription('Wie is er overleden?');
        $section1->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/db69ce35-4ae1-4aac-936f-bdb5d4d1ff18"]);
        $manager->persist($section1);

		$stage4= new Stage();
		$stage4->setPrevious($stage3);
		//$property->setId('');
		$stage4->setName('Belanghebbende');
		$stage4->setIcon('fal fa-users');
		$stage4->setSlug('belanghebbende');
		$stage4->setType('array');
		$stage4->setDescription('Wie gaan er begraven?');
		$stage4->setProcess($begraven);
		$manager->persist($stage4);

        $section1 = new Section();
        $section1->setStage($stage2);
        $section1->setStart(true);
        $section1->setName('Belanghebbende');
        $section1->setDescription('Wie treed er op als belanghebbende?');
        $section1->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/db69ce35-4ae1-4aac-936f-bdb5d4d1ff18"]);
        $manager->persist($section1);

		$manager->flush();
		var_dump($begraven->getId());


		$manager->flush();
	}
}
