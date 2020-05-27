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

class AppFixtures extends Fixture
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
        if ((strpos($this->params->get('app_domain'), 'zuiddrecht.nl') == false && strpos($this->params->get('app_domain'), 'zaakonline.nl') == false)
            || ($this->params->get('app_domain') != 'zuiddrecht.nl' && $this->params->get('app_domain') != 'zaakonline.nl')
            || $this->params->get('begraven.zaakonline.nl') || $this->params->get('westfriesland.commonground.nu')) {
            return false;
        }
        /*
         *  Bezwaar
         */
        $id = Uuid::fromString('282f203c-4ecf-4578-9597-343ceccf8f43');
        $processType = new ProcessType();
        $processType->setIcon('fal fa-file-certificate');
        $processType->setSourceOrganization('0000');
        $processType->setName('VOG');
        $processType->setDescription('Aanvraag verklaring omtrend gedrag');
        $processType->setRequestType('https://vtc.zaakonline.nl/requestType/282f203c-4ecf-4578-9597-343ceccf8f43');
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage1 = new Stage();
        $stage1->setStart(true);
        $stage1->setName('Aanvraag');
        $stage1->setIcon('fal fa-calendar-day');
        $stage1->setSlug('form');
        //		$stage1->setType('string');
        $stage1->setDescription('Wat is de verhuisdatum?');
        $stage1->setProcess($processType);
        $manager->persist($stage1);

        $stage2 = new Stage();
        $stage2->setPrevious($stage1);
        $stage2->setName('Indienen');
        $stage2->setIcon('fal fa-paper-plane');
        $stage2->setSlug('indienen');
        $stage2->setDescription('Wie zijn de getuigen van partner?');
        $stage2->setProcess($processType);
        $manager->persist($stage2);

        /*
         *  Bezwaar
         */
        $id = Uuid::fromString('2a86f09a-5cfc-443e-a54e-4f4b2f2693da');
        $processType = new ProcessType();
        $processType->setIcon('fal fa-id-card');
        $processType->setSourceOrganization('0000');
        $processType->setName('Rijbewijs');
        $processType->setDescription('Het maken van bezwaar tegen een genomen besluit');
        $processType->setRequestType('https://vtc.zaakonline.nl/requestType/2a86f09a-5cfc-443e-a54e-4f4b2f2693da');
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage1 = new Stage();
        $stage1->setStart(true);
        $stage1->setName('Aanvraag');
        $stage1->setIcon('fal fa-calendar-day');
        $stage1->setSlug('form');
        //		$stage1->setType('string');
        $stage1->setDescription('Wat is de verhuisdatum?');
        $stage1->setProcess($processType);
        $manager->persist($stage1);

        $stage2 = new Stage();
        $stage2->setPrevious($stage1);
        $stage2->setName('Indienen');
        $stage2->setIcon('fal fa-paper-plane');
        $stage2->setSlug('indienen');
        $stage2->setDescription('Wie zijn de getuigen van partner?');
        $stage2->setProcess($processType);
        $manager->persist($stage2);

        $id = Uuid::fromString('6aa060d4-ca79-45ac-9836-1522fd10eb42');
        $processType = new ProcessType();
        $processType->setIcon('fal fa-file-search');
        $processType->setSourceOrganization('0000');
        $processType->setName('Vermissing Rijbewijs');
        $processType->setDescription('Het maken van bezwaar tegen een genomen besluit');
        $processType->setRequestType('https://vtc.zaakonline.nl/requestType/6aa060d4-ca79-45ac-9836-1522fd10eb42');
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage1 = new Stage();
        $stage1->setStart(true);
        $stage1->setName('Melding');
        $stage1->setIcon('fal fa-calendar-day');
        $stage1->setSlug('form');
        //		$stage1->setType('string');
        $stage1->setDescription('Wat is de verhuisdatum?');
        $stage1->setProcess($processType);
        $manager->persist($stage1);

        $stage2 = new Stage();
        $stage2->setPrevious($stage1);
        $stage2->setName('Indienen');
        $stage2->setIcon('fal fa-paper-plane');
        $stage2->setSlug('indienen');
        $stage2->setDescription('Wie zijn de getuigen van partner?');
        $stage2->setProcess($processType);
        $manager->persist($stage2);

        /*
         *  Bezwaar
         */
        //Bewijs van in leven zijn/attestatie de vita.
        //Bewijs van ongehuwd geregistreerd staan.
        //Bewijs van Nederlanderschap.
        $id = Uuid::fromString('e7e30a18-4bc4-458b-8a66-fd2dc779db13');
        $processType = new ProcessType();
        $processType->setIcon('fal fa-file-user');
        $processType->setSourceOrganization('0000');
        $processType->setName('Uitreksel BRP');
        $processType->setDescription('Het maken van bezwaar tegen een genomen besluit');
        $processType->setRequestType('https://vtc.zaakonline.nl/requestType/e7e30a18-4bc4-458b-8a66-fd2dc779db13');
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage1 = new Stage();
        $stage1->setStart(true);
        $stage1->setName('Type');
        $stage1->setIcon('fal fa-calendar-day');
        $stage1->setSlug('form');
        //		$stage1->setType('string');
        $stage1->setDescription('Wat is de verhuisdatum?');
        $stage1->setProcess($processType);
        $manager->persist($stage1);

        $stage2 = new Stage();
        $stage2->setPrevious($stage1);
        $stage2->setName('Indienen');
        $stage2->setIcon('fal fa-paper-plane');
        $stage2->setSlug('indienen');
        $stage2->setDescription('Wie zijn de getuigen van partner?');
        $stage2->setProcess($processType);
        $manager->persist($stage2);

        /*
         *  Bezwaar
         */
        $id = Uuid::fromString('5fe5ed51-f9d1-4ece-b78d-e960e6ce3fd1');
        $processType = new ProcessType();
        $processType->setIcon('fal fa-surprise');
        $processType->setSourceOrganization('0000');
        $processType->setName('Bezwaar');
        $processType->setDescription('Het maken van bezwaar tegen een genomen besluit');
        $processType->setRequestType('https://vtc.zaakonline.nl/requestType/5fe5ed51-f9d1-4ece-b78d-e960e6ce3fd1');
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage1 = new Stage();
        $stage1->setStart(true);
        $stage1->setName('Bezwaar');
        $stage1->setIcon('fal fa-calendar-day');
        $stage1->setSlug('form');
        //		$stage1->setType('string');
        $stage1->setDescription('Wat is de verhuisdatum?');
        $stage1->setProcess($processType);
        $manager->persist($stage1);

        $stage2 = new Stage();
        $stage2->setPrevious($stage1);
        $stage2->setName('Indienen');
        $stage2->setIcon('fal fa-paper-plane');
        $stage2->setSlug('indienen');
        $stage2->setDescription('Wie zijn de getuigen van partner?');
        $stage2->setProcess($processType);
        $manager->persist($stage2);

        /*
         *  WOB
         */
        $id = Uuid::fromString('f4c2d525-5c73-4000-ad71-242a37892be7');
        $processType = new ProcessType();
        $processType->setIcon('fal fa-binoculars');
        $processType->setSourceOrganization('0000');
        $processType->setName('WOB Verzoek');
        $processType->setDescription('Een verzoek conform de wet openbaarheid bestuur');
        $processType->setRequestType('https://vtc.zaakonline.nl/requestType/f4c2d525-5c73-4000-ad71-242a37892be7');
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage1 = new Stage();
        $stage1->setStart(true);
        $stage1->setName('Verzoek');
        $stage1->setIcon('fal fa-calendar-day');
        $stage1->setSlug('form');
        //		$stage1->setType('string');
        $stage1->setDescription('Wat is de verhuisdatum?');
        $stage1->setProcess($processType);
        $manager->persist($stage1);

        $stage2 = new Stage();
        $stage2->setPrevious($stage1);
        $stage2->setName('Indienen');
        $stage2->setIcon('fal fa-paper-plane');
        $stage2->setSlug('indienen');
        $stage2->setDescription('Wie zijn de getuigen van partner?');
        $stage2->setProcess($processType);
        $manager->persist($stage2);

        /*
         *  Geboorte
         */
        $id = Uuid::fromString('d8d053cf-573a-4cbd-8b15-4681372cc2c8');
        $processType = new ProcessType();
        $processType->setIcon('fal fa-baby');
        $processType->setSourceOrganization('0000');
        $processType->setName('Geboorte aangifte');
        $processType->setDescription('Het aangeven van een nieuw geboren kind');
        $processType->setRequestType('https://vtc.zaakonline.nl/requestType/d8d053cf-573a-4cbd-8b15-4681372cc2c8');
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage1 = new Stage();
        $stage1->setStart(true);
        $stage1->setName('Datum');
        $stage1->setIcon('fal fa-calendar-day');
        $stage1->setSlug('datum');
        //		$stage1->setType('string');
        $stage1->setDescription('Wat is de geboorte datum?');
        $stage1->setProcess($processType);
        $manager->persist($stage1);

        $stage2 = new Stage();
        $stage2->setPrevious($stage1);
        $stage2->setName('Ouders');
        $stage2->setIcon('fal fa-user-friends');
        $stage2->setSlug('ouder');
        //		$stage2->setType('array');
        $stage2->setDescription('Wie zijn de ouders');
        $stage2->setProcess($processType);
        $manager->persist($stage2);

        $stage3 = new Stage();
        $stage3->setPrevious($stage2);
        $stage3->setName('Gemeente');
        $stage3->setIcon('fal fa-university');
        $stage3->setSlug('gemeente');
        //		$stage3->setType('string');
        $stage3->setDescription('In welke gemeente heeft de geboorte plaatsgevonden?');
        $stage3->setProcess($processType);
        $manager->persist($stage3);

        $stage4 = new Stage();
        $stage4->setPrevious($stage3);
        $stage4->setName('Naam');
        $stage4->setIcon('fal fa-user');
        $stage4->setSlug('naam');
        //		$stage4->setType('string');
        $stage4->setDescription('Wat wordt de naamgeving van het kinds');
        $stage4->setProcess($processType);
        $manager->persist($stage4);

        $stage5 = new Stage();
        $stage5->setPrevious($stage4);
        $stage5->setName('Indienen');
        $stage5->setIcon('fal fa-paper-plane');
        $stage5->setSlug('indienen');
        $stage5->setDescription('Wie zijn de getuigen van partner?');
        $stage5->setProcess($processType);
        $manager->persist($stage5);

        /*
         *  Overleiden
         */
        $id = Uuid::fromString('41ccbba0-241c-4801-a70d-f11894a1098a');
        $processType = new ProcessType();
        $processType->setIcon('fal fa-tombstone');
        $processType->setSourceOrganization('0000');
        $processType->setName('Overlijdens aangifte');
        $processType->setDescription('Het doorgeven van overlijden aan een gemeente');
        $processType->setRequestType('https://vtc.zaakonline.nl/requestType/41ccbba0-241c-4801-a70d-f11894a1098a');
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage1 = new Stage();
        $stage1->setStart(true);
        $stage1->setName('Datum');
        $stage1->setIcon('fal fa-calendar-day');
        $stage1->setSlug('datum');
        //		$stage1->setType('string');
        $stage1->setDescription('Wat is de verhuisdatum?');
        $stage1->setProcess($processType);
        $manager->persist($stage1);

        $stage2 = new Stage();
        $stage2->setPrevious($stage1);
        $stage2->setName('Wie');
        $stage2->setIcon('fal fa-user');
        $stage2->setSlug('overleden');
        //		$stage2->setType('string');
        $stage2->setDescription('Wat is er overleden');
        $stage2->setProcess($processType);
        $manager->persist($stage2);

        $stage3 = new Stage();
        $stage3->setPrevious($stage2);
        $stage3->setName('Waar');
        $stage3->setIcon('fal fa-university');
        $stage3->setSlug('gemeente');
        //		$stage3->setType('string');
        $stage3->setDescription('In welke gemeente heeft het overleiden plaatsgevonden?');
        $stage3->setProcess($processType);
        $manager->persist($stage3);

        $stage4 = new Stage();
        $stage4->setPrevious($stage3);
        $stage4->setName('Indienen');
        $stage4->setIcon('fal fa-paper-plane');
        $stage4->setSlug('indienen');
        $stage4->setDescription('Wie zijn de getuigen van partner?');
        $stage4->setProcess($processType);
        $manager->persist($stage4);

        /*
         *  Reisdocument
         */
        $id = Uuid::fromString('58d2e5ea-e592-48c1-86c4-93b43d8aac5c');
        $processType = new ProcessType();
        $processType->setSourceOrganization('0000');
        $processType->setName('Aanvraag Reisdocument');
        $processType->setDescription('Het aanvragen van een reisdocument');
        $processType->setRequestType('https://vtc.zaakonline.nl/requestType/58d2e5ea-e592-48c1-86c4-93b43d8aac5c');
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage1 = new Stage();
        $stage1->setStart(true);
        $stage1->setName('Type');
        $stage1->setIcon('fal fa-passport');
        $stage1->setSlug('document');
        //		$stage1->setType('string');
        $stage1->setDescription('Wat voor reisdocument wilt u aanvragen?');
        $stage1->setProcess($processType);
        $manager->persist($stage1);

        $stage2 = new Stage();
        $stage2->setPrevious($stage1);
        $stage2->setName('Foto');
        $stage2->setIcon('fal fa-portrait');
        $stage2->setSlug('foto');
        //		$stage2->setType('string');
        $stage2->setDescription('Upload een recente pasfote');
        $stage2->setProcess($processType);
        $manager->persist($stage2);

        $stage3 = new Stage();
        $stage3->setPrevious($stage2);
        $stage3->setName('Indienen');
        $stage3->setIcon('fal fa-paper-plane');
        $stage3->setSlug('indienen');
        $stage3->setDescription('Wie zijn de getuigen van partner?');
        $stage3->setProcess($processType);
        $manager->persist($stage3);

        $id = Uuid::fromString('690cbb51-50b8-4714-b45b-2dba696b1216');
        $processType = new ProcessType();
        $processType->setSourceOrganization('0000');
        $processType->setName('Vermissing Reisdocument');
        $processType->setDescription('Het aanvragen van een reisdocument');
        $processType->setRequestType('https://vtc.zaakonline.nl/requestType/690cbb51-50b8-4714-b45b-2dba696b1216');
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage1 = new Stage();
        $stage1->setStart(true);
        $stage1->setName('Type');
        $stage1->setIcon('fal fa-passport');
        $stage1->setSlug('document');
        //		$stage1->setType('string');
        $stage1->setDescription('Wat voor reisdocument wilt u aanvragen?');
        $stage1->setProcess($processType);
        $manager->persist($stage1);

        $stage2 = new Stage();
        $stage2->setPrevious($stage2);
        $stage2->setName('Indienen');
        $stage2->setIcon('fal fa-paper-plane');
        $stage2->setSlug('indienen');
        $stage2->setDescription('Wie zijn de getuigen van partner?');
        $stage2->setProcess($processType);
        $manager->persist($stage2);

        /*
         *  Melding openbare ruimte
         */
        $id = Uuid::fromString('07b9df95-cc8a-43c8-bc1e-5f1392973b39');
        $processType = new ProcessType();
        $processType->setIcon('fal fa-map-marker-edit');
        $processType->setSourceOrganization('0000');
        $processType->setName('Melding openbare ruimte');
        $processType->setDescription('Het doorgeven van melding openbare ruimte');
        $processType->setRequestType('https://vtc.zaakonline.nl/requestType/07b9df95-cc8a-43c8-bc1e-5f1392973b39');
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage1 = new Stage();
        $stage1->setStart(true);
        $stage1->setName('Wat');
        $stage1->setIcon('fal fa-map-marked');
        $stage1->setSlug('locatie');
        //		$stage1->setType('string');
        $stage1->setDescription('Wat is het nieuwe adres?');
        $stage1->setProcess($processType);
        $manager->persist($stage1);

        $stage2 = new Stage();
        $stage2->setPrevious($stage1);
        $stage2->setName('Melding');
        $stage2->setIcon('fal fa-comment');
        $stage2->setSlug('melding');
        //		$stage2->setType('string');
        $stage2->setDescription('Melding');
        $stage2->setProcess($processType);
        $manager->persist($stage2);

        $stage3 = new Stage();
        $stage3->setPrevious($stage2);
        $stage3->setName('Indiener');
        $stage3->setIcon('fal fa-user');
        $stage3->setSlug('contactgegevens');
        //		$stage3->setType('string');
        $stage3->setDescription('Melding');
        $stage3->setProcess($processType);
        $manager->persist($stage2);

        /*
         *  Verhuizen
         */
        $id = Uuid::fromString('2bfb3cea-b5b5-459c-b3e0-e1100089a11a');
        $verhuizen = new ProcessType();
        $verhuizen->setIcon('fal fa-truck-moving');
        $verhuizen->setSourceOrganization('0000');
        $verhuizen->setName('Verhuizen');
        $verhuizen->setDescription('Het doorgeven van een verhuizing aan een gemeente');
        $verhuizen->setRequestType("{$this->commonGroundService->getComponent('vtc')['location']}/request_types/2bfb3cea-b5b5-459c-b3e0-e1100089a11a");
        $manager->persist($verhuizen);
        $verhuizen->setId($id);
        $manager->persist($verhuizen);
        $manager->flush();
        $verhuizen = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage1 = new Stage();
        $stage1->setStart(true);
        $stage1->setName('Gegevens');
        $stage1->setIcon('fal fa-map-marked');
        $stage1->setSlug('gegevens');
        $stage1->setDescription('De gegevens van de verhuizing');
        $stage1->setProcess($verhuizen);
        $manager->persist($stage1);

        $section1 = new Section();
        $section1->setStage($stage1);
        $section1->setStart(true);
        $section1->setName('Datum');
        $section1->setDescription('Wat is de verhuisdatum?');
        $section1->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/69d16301-5e45-449d-b208-ba3efdca4f1d"]);
        $manager->persist($section1);

        $section2 = new Section();
        $section2->setStage($stage1);
        $section2->setName('Adres');
        $section2->setDescription('Waarheen verhuist u?');
        $section2->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/368fc9ce-6238-4e7c-ad4c-09c797e1f3f9"]);
        $section2->setPrevious($section1);
        $manager->persist($section2);

        $stage2 = new Stage();
        $stage2->setName('Verhuizenden');
        $stage2->setDescription('De gegevens van de verhuizenden');
        $stage2->setIcon('fal fa-users');
        $stage2->setSlug('verhuizenden');
        $stage2->setProcess($verhuizen);
        $stage2->setPrevious($stage1);
        $manager->persist($stage2);

        $section1 = new Section();
        $section1->setStage($stage2);
        $section1->setStart(true);
        $section1->setName('Verhuizenden');
        $section1->setDescription('Wie verhuizen er mee?');
        $section1->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/b6942884-574a-45b3-b2ca-36733d800ca4"]);
        $manager->persist($section1);

        //		$stage2= new Stage();
        //		$stage2->setPrevious($stage1);
        //		$stage2->setName('Adress');
        //		$stage2->setIcon('fal fa-map-marked');
        //		$stage2->setSlug('adress');
        //		$stage2->setType('string');
        //		$stage2->setDescription('Wat is het nieuwe adres?');
        //		$stage2->setProcess($processType);
        //		$manager->persist($stage2);
//
        //		$stage3= new Stage();
        //		$stage3->setPrevious($stage2);
        //		//$property->setId('');
        //		$stage3->setName('Wie');
        //		$stage3->setIcon('fal fa-users');
        //		$stage3->setSlug('verhuizenden');
        //		$stage3->setType('array');
        //		$stage3->setDescription('Wie gaan er verhuizen?');
        //		$stage3->setProcess($processType);
        //		$manager->persist($stage3);

        $stage4 = new Stage();
        $stage4->setPrevious($stage2);
        $stage4->setName('Indienen');
        $stage4->setIcon('fal fa-paper-plane');
        $stage4->setSlug('indienen');
        $stage4->setDescription('Dien uw aanvraag in');
        $stage4->setProcess($verhuizen);
        $manager->persist($stage4);

        $manager->flush();

        $id = Uuid::fromString('9d76fb58-0711-4437-acc4-9f4d9d403cdf');
        $processType = new ProcessType();
        $processType->setName('Verhuizen');
        $processType->setIcon('fal fa-truck-moving');
        $processType->setDescription('Het doorgeven van een verhuizing aan de gemeente \'s-Hertogenbosch');
        $processType->setSourceOrganization('001709124');
        $processType->setRequestType('https://vtc.zaakonline.nl/requestType/9d76fb58-0711-4437-acc4-9f4d9d403cdf');
        $processType->setExtends($verhuizen);
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage1 = new Stage();
        $stage1->setStart(true);
        //$verhuizenNL->setId('');
        $stage1->setName('Email');
        $stage1->setIcon('fal fa-envelope');
        $stage1->setSlug('email');
        $stage1->setDescription('Het e-mail addres dat wordt gebruikt om contact op te nemen (indien nodig) over deze verhuizing');
        //		$stage1->setType('string');
        $stage1->setProcess($processType);
        $manager->persist($stage1);

        $stage2 = new Stage();
        $stage2->setPrevious($stage1);
        //$verhuizenNL->setId('');
        $stage2->setName('Telefoon');
        $stage2->setIcon('fal fa-phone');
        $stage2->setSlug('telefoon');
        $stage2->setDescription('Het telefoon nummer dat wordt gebruikt om contact op te nemen (indien nodig) over deze verhuizing');
        //		$stage2->setType('string');
        $stage2->setProcess($processType);
        $manager->persist($stage2);

        $id = Uuid::fromString('fc79c4c9-b3b3-4258-bdbb-449262f3e5d7');
        $processType = new ProcessType();
        $processType->setName('Verhuizen');
        $processType->setIcon('fal fa-truck-moving');
        $processType->setDescription('Het doorgeven van een verhuizing aan de gemeente Eindhoven');
        $processType->setSourceOrganization('001902763');
        $processType->setRequestType('https://vtc.zaakonline.nl/requestType/fc79c4c9-b3b3-4258-bdbb-449262f3e5d7');
        $processType->setExtends($verhuizen);
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage1 = new Stage();
        $stage1->setStart(true);
        $stage1->setName('Eigenaar');
        $stage1->setIcon('fal fa-user');
        $stage1->setSlug('eigenaar');
        $stage1->setDescription('Bent u de eigenaar van de woning waar u heen verhuist?');
        //		$stage1->setType('boolean');
        $stage1->setProcess($processType);
        $manager->persist($stage1);

        $stage2 = new Stage();
        $stage2->setPrevious($stage1);
        //$verhuizenNL->setId('');
        $stage2->setName('Doorgeven gegevens');
        $stage2->setIcon('');
        $stage2->setSlug('notificatie');
        $stage2->setDescription('Wilt u dat we uw verhuizing ook doorgeven aan postNl?');
        //		$stage2->setType('boolean');
        $stage2->setProcess($processType);
        $manager->persist($stage2);

        /*
         *  Trouwen
         */
        $id = Uuid::fromString('cdd7e88b-1890-425d-a158-7f9ec92c9508');
        $processType = new ProcessType();
        $processType->setSourceOrganization('0000');
        $processType->setIcon('fas fa-user-tie');
        $processType->setName('Aanvraag babs voor een dag');
        $processType->setDescription('Melding voorgenomen huwelijk');
        $processType->setRequestType('https://vtc.zaakonline.nl/requestType/cdd7e88b-1890-425d-a158-7f9ec92c9508');
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage1 = new Stage();
        $stage1->setStart(true);
        $stage1->setName('Gegevens');
        $stage1->setIcon('fal fa-user');
        $stage1->setSlug('babs');
        //		$stage1->setType('string');
        $stage1->setDescription('Wat zijn de contact gegevens van uw beoogd BABS');
        $stage1->setProcess($processType);
        $manager->persist($stage1);

        $stage2 = new Stage();
        $stage2->setPrevious($stage1);
        $stage2->setName('Indienen');
        $stage2->setIcon('fal fa-paper-plane');
        $stage2->setSlug('indienen');
        $stage2->setDescription('Wie zijn de getuigen van partner?');
        $stage2->setProcess($processType);
        $manager->persist($stage2);

        $id = Uuid::fromString('c8704ea6-4962-4b7e-8d4e-69a257aa9577');
        $processType = new ProcessType();
        $processType->setIcon('fal fa-rings-wedding');
        $processType->setSourceOrganization('0000');
        $processType->setName('Aanvraag trouwlocatie');
        $processType->setDescription('Melding voorgenomen huwelijk');
        $processType->setRequestType('https://vtc.zaakonline.nl/requestType/c8704ea6-4962-4b7e-8d4e-69a257aa9577');
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage1 = new Stage();
        $stage1->setStart(true);
        $stage1->setName('Adress');
        $stage1->setIcon('fal fa-map-marked');
        $stage1->setSlug('locatie');
        //		$stage1->setType('string');
        $stage1->setDescription('Wat zijn de adress gegevens van uw beoogde locatie');
        $stage1->setProcess($processType);
        $manager->persist($stage1);

        $stage2 = new Stage();
        $stage2->setPrevious($stage1);
        $stage2->setName('Gegevens');
        $stage2->setIcon('fal fa-user');
        $stage2->setSlug('contact');
        //		$stage2->setType('string');
        $stage2->setDescription('Wat zijn de contact gegevens van uw beoogde locatie');
        $stage2->setProcess($processType);
        $manager->persist($stage2);

        $stage3 = new Stage();
        $stage3->setPrevious($stage2);
        $stage3->setName('Indienen');
        $stage3->setIcon('fal fa-paper-plane');
        $stage3->setSlug('indienen');
        $stage3->setDescription('Wie zijn de getuigen van partner?');
        $stage3->setProcess($processType);
        $manager->persist($stage3);

        $id = Uuid::fromString('146cb7c8-46b9-4911-8ad9-3238bab4313e');
        $processType = new ProcessType();
        $processType->setIcon('fal fa-ring');
        $processType->setSourceOrganization('0000');
        $processType->setName('Melding voorgenomen huwelijk');
        $processType->setDescription('Melding voorgenomen huwelijk');
        $processType->setRequestType('https://vtc.zaakonline.nl/requestType/146cb7c8-46b9-4911-8ad9-3238bab4313e');
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage1 = new Stage();
        $stage1->setStart(true);
        $stage1->setName('Datum');
        $stage1->setIcon('fas fa-calendar-day');
        $stage1->setSlug('datum');
        //		$stage1->setType('string');
        $stage1->setDescription('Selecteer een datum voor de omzetting naar huwelijk');
        $stage1->setProcess($processType);
        $manager->persist($stage1);

        $stage2 = new Stage();
        $stage2->setPrevious($stage1);
        $stage2->setName('Partners');
        $stage2->setIcon('fas fa-user-friends');
        $stage2->setSlug('partner');
        //		$stage2->setType('array');
        $stage2->setDescription('Wie zijn de getuigen van partner 2?');
        $stage2->setProcess($processType);
        $manager->persist($stage2);

        $stage3 = new Stage();
        $stage3->setPrevious($stage2);
        $stage3->setName('Getuigen');
        $stage3->setIcon('fas fa-users');
        $stage3->setSlug('getuige');
        //		$stage3->setType('array');
        $stage3->setDescription('Wie zijn de getuigen van partner?');
        $stage3->setProcess($processType);
        $manager->persist($stage3);

        $stage4 = new Stage();
        $stage4->setPrevious($stage3);
        $stage4->setName('Indienen');
        $stage4->setIcon('fal fa-paper-plane');
        $stage4->setSlug('indienen');
        $stage4->setDescription('Wie zijn de getuigen van partner?');
        $stage4->setProcess($processType);
        $manager->persist($stage4);

        $id = Uuid::fromString('432d3e81-5930-4c21-ab7f-c5541c948525');
        $processType = new ProcessType();
        $processType->setIcon('fal fa-rings-wedding');
        $processType->setSourceOrganization('0000');
        $processType->setName('Omzetting');
        $processType->setDescription('Het omzetten van een bestaand partnerschap in een huwelijk.');
        $processType->setRequestType('https://vtc.zaakonline.nl/requestType/432d3e81-5930-4c21-ab7f-c5541c948525');
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage1 = new Stage();
        $stage1->setStart(true);
        $stage1->setName('Datum');
        $stage1->setIcon('fas fa-calendar-day');
        $stage1->setSlug('datum');
        //		$stage1->setType('string');
        $stage1->setDescription('Selecteer een datum voor de omzetting naar huwelijk');
        $stage1->setProcess($processType);
        $manager->persist($stage1);

        $stage2 = new Stage();
        $stage2->setPrevious($stage1);
        $stage2->setName('Partners');
        $stage2->setIcon('fas fa-user-friends');
        $stage2->setSlug('partner');
        //		$stage2->setType('array');
        $stage2->setDescription('Wie zijn de getuigen van partner 2?');
        $stage2->setProcess($processType);
        $manager->persist($stage2);

        $stage3 = new Stage();
        $stage3->setPrevious($stage2);
        $stage3->setName('Indienen');
        $stage3->setIcon('fal fa-paper-plane');
        $stage3->setSlug('indienen');
        $stage3->setDescription('Wie zijn de getuigen van partner?');
        $stage3->setProcess($processType);
        $manager->persist($stage3);

        $id = Uuid::fromString('5b10c1d6-7121-4be2-b479-7523f1b625f1');
        $processType = new ProcessType();
        $processType->setIcon('fal fa-rings-wedding');
        $processType->setSourceOrganization('000');
        $processType->setName('Huwelijk / Partnerschap');
        $processType->setDescription('Huwelijk / Partnerschap');
        $processType->setRequestType('https://vtc.zaakonline.nl/requestType/5b10c1d6-7121-4be2-b479-7523f1b625f1');
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);
        $trouwenNL = $processType;
        // Inladen van de kinderen
        /*
         $trouwenNL->addChild($aanvraagBabs);
         $trouwenNL->addChild($aanvraagLocatie);
         $trouwenNL->addChild($meldingTrouwenNL);
         */

        $stage1 = new Stage();
        $stage1->setStart(true);
        $stage1->setName('Type');
        $stage1->setIcon('fas fa-ring');
        $stage1->setSlug('ceremonie');
        //		$stage1->setType('string');
        $stage1->setDescription('Selecteer een huwelijk of partnerschap?');
        $stage1->setProcess($processType);
        $manager->persist($stage1);

        $stage2 = new Stage();
        $stage2->setPrevious($stage1);
        $stage2->setName('Partners');
        $stage2->setIcon('fas fa-user-friends');
        $stage2->setSlug('partner');
        //		$stage2->setType('array');
        $stage2->setDescription('Wie zijn de getuigen van partner 2?');
        $stage2->setProcess($processType);
        $manager->persist($stage2);

        $stage3 = new Stage();
        $stage3->setPrevious($stage2);
        $stage3->setName('Plechtigheid  ');
        $stage3->setIcon('fas fa-glass-cheers');
        $stage3->setSlug('plechtigheid');
        //		$stage3->setType('string');
        $stage3->setDescription('Onder welke uri kunnen we de bestaande \'melding voorgenomen huwelijk\' terugvinden?');
        $stage3->setProcess($processType);
        $manager->persist($stage3);

        $stage4 = new Stage();
        $stage4->setPrevious($stage3);
        $stage4->setName('Datum');
        $stage4->setIcon('fas fa-calendar-day');
        $stage4->setSlug('datum');
        //		$stage4->setType('string');
        $stage4->setDescription('Selecteer een datum voor de omzetting naar huwelijk');
        $stage4->setProcess($processType);
        $manager->persist($stage4);

        $stage5 = new Stage();
        $stage5->setPrevious($stage4);
        $stage5->setName('Locatie');
        $stage5->setIcon('fas fa-building');
        $stage5->setSlug('locatie');
        //		$stage5->setType('string');
        $stage5->setDescription('We gebruiken de order om de bestelling (bestaande uit locatie, ambtenaar en eventuele extra\'s) op te slaan');
        $stage5->setProcess($processType);
        $manager->persist($stage5);

        $stage6 = new Stage();
        $stage6->setPrevious($stage5);
        $stage6->setName('Ambtenaar');
        $stage6->setIcon('fas fa-user-tie');
        $stage6->setSlug('ambtenaar');
        //		$stage6->setType('string');
        $stage6->setDescription('We gebruiken de order om de bestelling (bestaande uit locatie, ambtenaar en eventuele extra\'s) op te slaan');
        $stage6->setProcess($processType);
        $manager->persist($stage6);

        $stage7 = new Stage();
        $stage7->setPrevious($stage6);
        $stage7->setName('Getuigen');
        $stage7->setIcon('fas fa-users');
        $stage7->setSlug('getuige');
        //		$stage7->setType('array');
        $stage7->setDescription('Wie zijn de getuigen van partner?');
        $stage7->setProcess($processType);
        $manager->persist($stage7);

        $stage8 = new Stage();
        $stage8->setPrevious($stage7);
        $stage8->setName('Extras');
        $stage8->setIcon('fas fa-gift');
        $stage8->setSlug('extra');
        //		$stage8->setType('array');
        $stage8->setDescription('Wie zijn de getuigen van partner?');
        $stage8->setProcess($processType);
        $manager->persist($stage8);

        $overige = new Stage();
        $overige->setPrevious($stage8);
        $overige->setName('Overig');
        $overige->setIcon('fal fa-file-alt');
        $overige->setSlug('overig');
        //		$overige->setType('array');
        $overige->setDescription('Graag zouden wij u om wat extra informatie vragen');
        $overige->setProcess($processType);
        $manager->persist($overige);

        $stage9 = new Stage();
        $stage9->setPrevious($overige);
        $stage9->setName('Melding ');
        $stage9->setIcon('fas fa-envelope');
        $stage9->setSlug('melding');
        //		$stage9->setType('string');
        $stage9->setDescription('Onder welke uri kunnen we de bestaande \'melding voorgenomen huwelijk\' terugvinden?');
        $stage9->setProcess($processType);
        $manager->persist($stage9);

        $stage10 = new Stage();
        $stage10->setPrevious($stage9);
        $stage10->setName('Betalen ');
        $stage10->setIcon('fas fa-cash-register');
        $stage10->setSlug('betalen');
        //		$stage10->setType('string');
        $stage10->setDescription('Onder welke uri kunnen we de bestaande \'melding voorgenomen huwelijk\' terugvinden?');
        $stage10->setProcess($processType);
        $manager->persist($stage10);

        $stage11 = new Stage();
        $stage11->setPrevious($stage10);
        $stage11->setName('Reserveren ');
        $stage11->setIcon('fas fa-calendar-check');
        $stage11->setSlug('checklist');
        $stage11->setDescription('Onder welke uri kunnen we de bestaande \'melding voorgenomen huwelijk\' terugvinden?');
        $stage11->setProcess($processType);
        $manager->persist($stage11);

        $property = new Stage();
        //$property->setId('');
        $property->setName('Order');
        //		$property->setType('string');
        $property->setDescription('We gebruiken de order om de bestelling (bestaande uit locatie, ambtenaar en eventuele extra\'s) op te slaan');
        $property->setProcess($processType);
        $manager->persist($property);

        $id = Uuid::fromString('47577f44-0ede-4655-a629-027f051d2b07');
        $processType = new ProcessType();
        $processType->setExtends($trouwenNL);
        $processType->setSourceOrganization('002220647');
        $processType->setName('Trouwen of Partnerschap in Utrecht');
        $processType->setDescription('Trouwen of Partnerschap in Utrecht');
        $processType->setRequestType('https://vtc.zaakonline.nl/requestType/47577f44-0ede-4655-a629-027f051d2b07');
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);

        $manager->flush();
    }
}
