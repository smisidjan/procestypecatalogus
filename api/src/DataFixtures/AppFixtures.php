<?php

namespace App\DataFixtures;

use App\Entity\Stage;
use App\Entity\ProcessType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class AppFixtures extends Fixture
{
	public function load(ObjectManager $manager)
	{
		/*
		 *  Bezwaar
		 */
		$processType->setRequestType('https://vtc.zaakonline.nl/requestType/282f203c-4ecf-4578-9597-343ceccf8f43');
		$processType= new ProcessType();
		$processType->setIcon('fal fa-file-certificate');
		$processType->setSourceOrganization('0000');
		$processType->setName('VOG');
		$processType->setDescription('Aanvraag verklaring omtrend gedrag');
		$processType->persist($bezwaar);
		$processType->setId($id);
		$manager->persist($processType);
		$manager->flush();
		$processType = $manager->getRepository('App:ProcessType')->findOneBy(array('id'=> $id));
		
		$stage1 = new Stage();
		$stage1->setStart(true);
		$stage1->setTitle('Aanvraag');
		$stage1->setIcon('fal fa-calendar-day');
		$stage1->setSlug('form');
		$stage1->setType('string');
		$stage1->setFormat('date');
		$stage1->setDescription('Wat is de verhuisdatum?');
		$stage1->setRequestType($processType);
		$manager->persist(stage);
		
		$stage2= new Stage();
		$stage2->addPrevious($stage1);
		$stage2->setTitle('Indienen');
		$stage2->setIcon('fal fa-paper-plane');
		$stage2->setSlug('indienen');
		$stage2->setDescription('Wie zijn de getuigen van partner?');
		$stage2->setRequestType($processType);
		$manager->persist($stage2);
		
		/*
		 *  Bezwaar
		 */
		$processType->setRequestType('https://vtc.zaakonline.nl/requestType/2a86f09a-5cfc-443e-a54e-4f4b2f2693da');
		$processType= new ProcessType();
		$processType->setIcon('fal fa-id-card');
		$processType->setSourceOrganization('0000');
		$processType->setName('Rijbewijs');
		$processType->setDescription('Het maken van bezwaar tegen een genomen besluit');
		$manager->persist($processType);
		$processType->setId($id);
		$processType->persist($processType);
		$manager->flush();
		$processType= $manager->getRepository('App:ProcessType')->findOneBy(array('id'=> $id));
		
		$stage1 = new Stage();
		$stage1->setStart(true);
		$stage1->setTitle('Aanvraag');
		$stage1->setIcon('fal fa-calendar-day');
		$stage1->setSlug('form');
		$stage1->setType('string');
		$stage1->setFormat('date');
		$stage1->setDescription('Wat is de verhuisdatum?');
		$stage1->setRequestType($processType);
		$manager->persist($stage1);
		
		$stage2= new Stage();
		$stage2->addPrevious($stage1);
		$stage2->setTitle('Indienen');
		$stage2->setIcon('fal fa-paper-plane');
		$stage2->setSlug('indienen');
		$stage2->setDescription('Wie zijn de getuigen van partner?');
		$stage2->setRequestType($processType);
		$manager->persist($stage2);
		
		
		$processType->setRequestType('https://vtc.zaakonline.nl/requestType/6aa060d4-ca79-45ac-9836-1522fd10eb42');
		$processType= new ProcessType();
		$processType->setIcon('fal fa-file-search');
		$processType->setSourceOrganization('0000');
		$processType->setName('Vermissing Rijbewijs');
		$processType->setDescription('Het maken van bezwaar tegen een genomen besluit');
		$manager->persist($processType);
		$processType->setId($id);
		$manager->persist($processType);
		$manager->flush();
		$processType= $manager->getRepository('App:ProcessType')->findOneBy(array('id'=> $id));
		
		$stage1 = new Stage();
		$stage1->setStart(true);
		$stage1->setTitle('Melding');
		$stage1->setIcon('fal fa-calendar-day');
		$stage1->setSlug('form');
		$stage1->setType('string');
		$stage1->setFormat('date');
		$stage1->setDescription('Wat is de verhuisdatum?');
		$stage1->setRequestType($processType);
		$manager->persist($stage1);
		
		$stage2= new Stage();
		$stage2->addPrevious($stage1);
		$stage2->setTitle('Indienen');
		$stage2->setIcon('fal fa-paper-plane');
		$stage2->setSlug('indienen');
		$stage2->setDescription('Wie zijn de getuigen van partner?');
		$stage2->setRequestType($processType);
		$manager->persist($stage2);
		
		/*
		 *  Bezwaar
		 */
		//Bewijs van in leven zijn/attestatie de vita.
		//Bewijs van ongehuwd geregistreerd staan.
		//Bewijs van Nederlanderschap.
		$processType->setRequestType('https://vtc.zaakonline.nl/requestType/e7e30a18-4bc4-458b-8a66-fd2dc779db13');
		$processType= new ProcessType();
		$processType->setIcon('fal fa-file-user');
		$processType->setSourceOrganization('0000');
		$processType->setName('Uitreksel BRP');
		$processType->setDescription('Het maken van bezwaar tegen een genomen besluit');
		$manager->persist($processType);
		$processType->setId($id);
		$manager->persist($processType);
		$manager->flush();
		$processType= $manager->getRepository('App:ProcessType')->findOneBy(array('id'=> $id));
		
		$stage1 = new Stage();
		$stage1->setStart(true);
		$stage1->setTitle('Type');
		$stage1->setIcon('fal fa-calendar-day');
		$stage1->setSlug('form');
		$stage1->setType('string');
		$stage1->setFormat('string');
		$stage1->setDescription('Wat is de verhuisdatum?');
		$stage1->setRequestType($processType);
		$manager->persist($stage1);
		
		$stage2= new Stage();
		$stage2->addPrevious($stage1);
		$stage2->setTitle('Indienen');
		$stage2->setIcon('fal fa-paper-plane');
		$stage2->setSlug('indienen');
		$stage2->setDescription('Wie zijn de getuigen van partner?');
		$stage2->setRequestType($processType);
		$manager->persist($stage2);
		
		/*
		 *  Bezwaar
		 */
		$processType->setRequestType('https://vtc.zaakonline.nl/requestType/5fe5ed51-f9d1-4ece-b78d-e960e6ce3fd1');
		$processType= new ProcessType();
		$processType->setIcon('fal fa-surprise');
		$processType->setSourceOrganization('0000');
		$processType->setName('Bezwaar');
		$processType->setDescription('Het maken van bezwaar tegen een genomen besluit');
		$manager->persist($processType);
		$processType->setId($id);
		$manager->persist($processType);
		$manager->flush();
		$processType= $manager->getRepository('App:ProcessType')->findOneBy(array('id'=> $id));
		
		$stage1 = new Stage();
		$stage1->setStart(true);
		$stage1->setTitle('Bezwaar');
		$stage1->setIcon('fal fa-calendar-day');
		$stage1->setSlug('form');
		$stage1->setType('string');
		$stage1->setFormat('string');
		$stage1->setDescription('Wat is de verhuisdatum?');
		$stage1->setRequestType($processType);
		$manager->persist($stage1);
		
		$stage2= new Stage();
		$stage2->addPrevious($stage1);
		$stage2->setTitle('Indienen');
		$stage2->setIcon('fal fa-paper-plane');
		$stage2->setSlug('indienen');
		$stage2->setDescription('Wie zijn de getuigen van partner?');
		$stage2->setRequestType($processType);
		$manager->persist($stage2);
		
		/*
		 *  WOB
		 */
		$processType->setRequestType('https://vtc.zaakonline.nl/requestType/f4c2d525-5c73-4000-ad71-242a37892be7');
		$processType= new ProcessType();
		$processType->setIcon('fal fa-binoculars');
		$processType->setSourceOrganization('0000');
		$processType->setName('WOB Verzoek');
		$processType->setDescription('Een verzoek conform de wet openbaarheid bestuur');
		$manager->persist($processType);
		$processType->setId($id);
		$manager->persist($processType);
		$manager->flush();
		$processType= $manager->getRepository('App:ProcessType')->findOneBy(array('id'=> $id));
		
		$stage1 = new Stage();
		$stage1->setStart(true);
		$stage1->setTitle('Verzoek');
		$stage1->setIcon('fal fa-calendar-day');
		$stage1->setSlug('form');
		$stage1->setType('string');
		$stage1->setFormat('string');
		$stage1->setDescription('Wat is de verhuisdatum?');
		$stage1->setRequestType($processType);
		$manager->persist($stage1);
		
		$stage2= new Stage();
		$stage2->addPrevious($stage1);
		$stage2->setTitle('Indienen');
		$stage2->setIcon('fal fa-paper-plane');
		$stage2->setSlug('indienen');
		$stage2->setDescription('Wie zijn de getuigen van partner?');
		$stage2->setRequestType($processType);
		$manager->persist($stage2);
		
		/*
		 *  Geboorte
		 */
		$processType->setRequestType('https://vtc.zaakonline.nl/requestType/d8d053cf-573a-4cbd-8b15-4681372cc2c8');
		$processType= new ProcessType();
		$processType->setIcon('fal fa-baby');
		$processType->setSourceOrganization('0000');
		$processType->setName('Geboorte aangifte');
		$processType->setDescription('Het aangeven van een nieuw geboren kind');
		$manager->persist($processType);
		$processType->setId($id);
		$manager->persist($processType);
		$manager->flush();
		$processType= $manager->getRepository('App:ProcessType')->findOneBy(array('id'=> $id));
		
		$stage1= new Stage();
		$stage1->setStart(true);
		$stage1->setTitle('Datum');
		$stage1->setIcon('fal fa-calendar-day');
		$stage1->setSlug('datum');
		$stage1->setType('string');
		$stage1->setFormat('date');
		$stage1->setDescription('Wat is de geboorte datum?');
		$stage1->setRequestType($processType);
		$manager->persist($stage1);
		
		$stage2= new Stage();
		$stage2->addPrevious($stage1);
		$stage2->setTitle('Ouders');
		$stage2->setIcon('fal fa-user-friends');
		$stage2->setSlug('ouder');
		$stage2->setType('array');
		$stage2->setFormat('bsn');
		$stage2->setMinItems(2);
		$stage2->setMaxItems(2);
		$stage2->setRequired(true);
		$stage2->setDescription('Wie zijn de ouders');
		$stage2->setRequestType($processType);
		$manager->persist($stage2);
		
		$stage3= new Stage();
		$stage3->addPrevious($stage2);
		$stage3->setTitle('Gemeente');
		$stage3->setIcon('fal fa-university');
		$stage3->setSlug('gemeente');
		$stage3->setType('string');
		$stage3->setFormat('uri');
		$stage3->setRequired(true);
		$stage3->setDescription('In welke gemeente heeft de geboorte plaatsgevonden?');
		$stage3->setRequestType($processType);
		$manager->persist($stage3);
		
		$stage4= new Stage();
		$stage4->addPrevious($stage3);
		$stage4->setTitle('Naam');
		$stage4->setIcon('fal fa-user');
		$stage4->setSlug('naam');
		$stage4->setType('string');
		$stage4->setFormat('uri');
		$stage4->setRequired(true);
		$stage4->setDescription('Wat wordt de naamgeving van het kinds');
		$stage4->setRequestType($processType);
		$manager->persist($stage4);
		
		$stage5= new Stage();
		$stage5->addPrevious($stage4);
		$stage5->setTitle('Indienen');
		$stage5->setIcon('fal fa-paper-plane');
		$stage5->setSlug('indienen');
		$stage5->setDescription('Wie zijn de getuigen van partner?');
		$stage5->setRequestType($processType);
		$manager->persist($stage5);
		
		/*
		 *  Overleiden
		 */
		$processType->setRequestType('https://vtc.zaakonline.nl/requestType/41ccbba0-241c-4801-a70d-f11894a1098a');
		$processType= new ProcessType();
		$processType->setIcon('fal fa-tombstone');
		$processType->setSourceOrganization('0000');
		$processType->setName('Overlijdens aangifte');
		$processType->setDescription('Het doorgeven van overlijden aan een gemeente');
		$manager->persist($processType);
		$processType->setId($id);
		$manager->persist($processType);
		$manager->flush();
		$processType= $manager->getRepository('App:ProcessType')->findOneBy(array('id'=> $id));
		
		$stage1 = new Stage();
		$stage1->setStart(true);
		$stage1->setTitle('Datum');
		$stage1->setIcon('fal fa-calendar-day');
		$stage1->setSlug('datum');
		$stage1->setType('string');
		$stage1->setFormat('date');
		$stage1->setDescription('Wat is de verhuisdatum?');
		$stage1->setRequestType($processType);
		$manager->persist($stage1);
		
		$stage2= new Stage();
		$stage2->addPrevious($stage1);
		$stage2->setTitle('Wie');
		$stage2->setIcon('fal fa-user');
		$stage2->setSlug('overleden');
		$stage2->setType('string');
		$stage2->setFormat('bsn');
		$stage2->setRequired(true);
		$stage2->setDescription('Wat is er overleden');
		$stage2->setRequestType($processType);
		$manager->persist($stage2);
		
		$stage3= new Stage();
		$stage3->addPrevious($stage2);
		$stage3->setTitle('Waar');
		$stage3->setIcon('fal fa-university');
		$stage3->setSlug('gemeente');
		$stage3->setType('string');
		$stage3->setFormat('uri');
		$stage3->setRequired(true);
		$stage3->setDescription('In welke gemeente heeft het overleiden plaatsgevonden?');
		$stage3->setRequestType($processType);
		$manager->persist($stage3);
		
		$stage4= new Stage();
		$stage4->addPrevious($stage3);
		$stage4->setTitle('Indienen');
		$stage4->setIcon('fal fa-paper-plane');
		$stage4->setSlug('indienen');
		$stage4->setDescription('Wie zijn de getuigen van partner?');
		$stage4->setRequestType($processType);
		$manager->persist($stage4);
		
		/*
		 *  Reisdocument
		 */
		$processType->setRequestType('https://vtc.zaakonline.nl/requestType/58d2e5ea-e592-48c1-86c4-93b43d8aac5c');
		$processType= new ProcessType();
		$processType->setSourceOrganization('0000');
		$processType->setName('Aanvraag Reisdocument');
		$processType->setDescription('Het aanvragen van een reisdocument');
		$manager->persist($processType);
		$processType->setId($id);
		$manager->persist($processType);
		$manager->flush();
		$processType = $manager->getRepository('App:ProcessType')->findOneBy(array('id'=> $id));
		
		$stage1= new Stage();
		$stage1->setStart(true);
		$stage1->setTitle('Type');
		$stage1->setIcon('fal fa-passport');
		$stage1->setSlug('document');
		$stage1->setType('string');
		$stage1->setFormat('bsn');
		$stage1->setRequired(true);
		$stage1->setDescription('Wat voor reisdocument wilt u aanvragen?');
		$stage1->setRequestType($processType);
		$manager->persist($stage1);
		
		$stage2= new Stage();
		$stage2->addPrevious($stage1);
		$stage2->setTitle('Foto');
		$stage2->setIcon('fal fa-portrait');
		$stage2->setSlug('foto');
		$stage2->setType('string');
		$stage2->setFormat('base64');
		$stage2->setRequired(true);
		$stage2->setDescription('Upload een recente pasfote');
		$stage2->setRequestType($processType);
		$manager->persist($stage2);
		
		$stage3= new Stage();
		$stage3->addPrevious($stage2);
		$stage3->setTitle('Indienen');
		$stage3->setIcon('fal fa-paper-plane');
		$stage3->setSlug('indienen');
		$stage3->setDescription('Wie zijn de getuigen van partner?');
		$stage3->setRequestType($processType);
		$manager->persist($stage3);
		
		$processType->setRequestType('https://vtc.zaakonline.nl/requestType/690cbb51-50b8-4714-b45b-2dba696b1216');
		$processType= new ProcessType();
		$processType->setSourceOrganization('0000');
		$processType->setName('Vermissing Reisdocument');
		$reis$processTypedocument->setDescription('Het aanvragen van een reisdocument');
		$manager->persist($processType);
		$reisdocument->setId($id);
		$manager->persist($processType);
		$manager->flush();
		$processType= $manager->getRepository('App:ProcessType')->findOneBy(array('id'=> $id));
		
		$stage1= new Stage();
		$stage1->setStart(true);
		$stage1->setTitle('Type');
		$stage1->setIcon('fal fa-passport');
		$stage1->setSlug('document');
		$stage1->setType('string');
		$stage1->setFormat('bsn');
		$stage1->setRequired(true);
		$stage1->setDescription('Wat voor reisdocument wilt u aanvragen?');
		$stage1->setRequestType($processType);
		$manager->persist($stage1);
		
		$stage2= new Stage();
		$stage2->addPrevious($stage2);
		$stage2->setTitle('Indienen');
		$stage2->setIcon('fal fa-paper-plane');
		$stage2->setSlug('indienen');
		$stage2->setDescription('Wie zijn de getuigen van partner?');
		$stage2->setRequestType($processType);
		$manager->persist($stage2);
		
		/*
		 *  Melding openbare ruimte
		 */
		$processType->setRequestType('https://vtc.zaakonline.nl/requestType/07b9df95-cc8a-43c8-bc1e-5f1392973b39');
		$processType= new ProcessType();
		$processType->setIcon('fal fa-map-marker-edit');
		$processType->setSourceOrganization('0000');
		$processType->setName('Melding openbare ruimte');
		$processType->setDescription('Het doorgeven van melding openbare ruimte');
		$manager->persist($processType);
		$processType->setId($id);
		$manager->persist($processType);
		$manager->flush();
		$processType= $manager->getRepository('App:ProcessType')->findOneBy(array('id'=> $id));
		
		$stage1= new Stage();
		$stage1->setStart(true);
		$stage1->setTitle('Wat');
		$stage1->setIcon('fal fa-map-marked');
		$stage1->setSlug('locatie');
		$stage1->setType('string');
		$stage1->setFormat('bag');
		$stage1->setRequired(true);
		$stage1->setDescription('Wat is het nieuwe adres?');
		$stage1->setRequestType($processType);
		$manager->persist($stage1);
		
		$stage2= new Stage();
		$stage2->addPrevious($stage1);
		$stage2->setTitle('Melding');
		$stage2->setIcon('fal fa-comment');
		$stage2->setSlug('melding');
		$stage2->setType('string');
		$stage2->setFormat('text');
		$stage2->setRequired(true);
		$stage2->setDescription('Melding');
		$stage2->setRequestType($processType);
		$manager->persist($stage2);
		
		$stage3= new Stage();
		$stage3->addPrevious($stage2);
		$stage3->setTitle('Indiener');
		$stage3->setIcon('fal fa-user');
		$stage3->setSlug('contactgegevens');
		$stage3->setType('string');
		$stage3->setFormat('text');
		$stage3->setDescription('Melding');
		$stage3->setRequestType($processType);
		$manager->persist($stage2);
		
		
		/*
		 *  Verhuizen
		 */
		$processType->setRequestType('https://vtc.zaakonline.nl/requestType/2bfb3cea-b5b5-459c-b3e0-e1100089a11a');
		$processType= new ProcessType();
		$processType->setIcon('fal fa-truck-moving');
		$processTypeL->setSourceOrganization('0000');
		$processType->setName('Verhuizen');
		$processType->setDescription('Het doorgeven van een verhuizing aan een gemeente');
		$manager->persist($processType);
		$processType->setId($id);
		$manager->persist($processType);
		$manager->flush();
		$processType= $manager->getRepository('App:ProcessType')->findOneBy(array('id'=> $id));
		
		$stage1 = new Stage();
		$stage1->setStart(true);
		$stage1->setTitle('Datum');
		$stage1->setIcon('fal fa-calendar-day');
		$stage1->setSlug('datum');
		$stage1->setType('string');
		$stage1->setFormat('date');
		$stage1->setDescription('Wat is de verhuisdatum?');
		$stage1->setRequestType($processType);
		$manager->persist($stage1);
		
		$stage2= new Stage();
		$stage2->addPrevious($stage1);
		$stage2->setTitle('Adress');
		$stage2->setIcon('fal fa-map-marked');
		$stage2->setSlug('adress');
		$stage2->setType('string');
		$stage2->setFormat('bag');
		$stage2->setRequired(true);
		$stage2->setDescription('Wat is het nieuwe adres?');
		$stage2->setRequestType($processType);
		$manager->persist($stage2);
		
		$stage3= new Stage();
		$stage3->addPrevious($stage2);
		//$property->setId('');
		$stage3->setTitle('Wie');
		$stage3->setIcon('fal fa-users');
		$stage3->setSlug('verhuizenden');
		$stage3->setType('array');
		$stage3->setFormat('bsn');
		$stage3->setRequired(true);
		$stage3->setDescription('Wie gaan er verhuizen?');
		$stage3->setRequestType($processType);
		$manager->persist($stage3);
		
		$stage4= new Stage();
		$stage4->addPrevious($stage3);
		$stage4->setTitle('Indienen');
		$stage4->setIcon('fal fa-paper-plane');
		$stage4->setSlug('indienen');
		$stage4->setDescription('Wie zijn de getuigen van partner?');
		$stage4->setRequestType($processType);
		$manager->persist($stage4);
		
		$processType->setRequestType('https://vtc.zaakonline.nl/requestType/9d76fb58-0711-4437-acc4-9f4d9d403cdf');
		$processType= new ProcessType();
		$processType->setName('Verhuizen');
		$processType->setIcon('fal fa-truck-moving');
		$processType->setDescription('Het doorgeven van een verhuizing aan de gemeente \'s-Hertogenbosch');
		$processType->setSourceOrganization('001709124');
		$processType->setExtends($verhuizenNL);
		$manager->persist($processType);
		$processType->setId($id);
		$manager->persist($processType);
		$manager->flush();
		$processType= $manager->getRepository('App:ProcessType')->findOneBy(array('id'=> $id));
		
		$stage1= new Stage();
		$stage1->setStart(true);
		//$verhuizenNL->setId('');
		$stage1->setTitle('Email');
		$stage1->setIcon('fal fa-envelope');
		$stage1->setSlug('email');
		$stage1->setDescription('Het e-mail addres dat wordt gebruikt om contact op te nemen (indien nodig) over deze verhuizing');
		$stage1->setType('string');
		$stage1->setFormat('email');
		$stage1->setRequired(true);
		$stage1->setRequestType($processType);
		$manager->persist($stage1);
		
		$stage2= new Stage();
		$stage2->addPrevious($stage1);
		//$verhuizenNL->setId('');
		$stage2->setTitle('Telefoon');
		$stage2->setIcon('fal fa-phone');
		$stage2->setSlug('telefoon');
		$stage2->setDescription('Het telefoon nummer dat wordt gebruikt om contact op te nemen (indien nodig) over deze verhuizing');
		$stage2->setType('string');
		$stage2->setFormat('string');
		$stage2->setRequired(true);
		$stage2->setRequestType($processType);
		$manager->persist($stage2);
		
		$processType->setRequestType('https://vtc.zaakonline.nl/requestType/fc79c4c9-b3b3-4258-bdbb-449262f3e5d7');
		$processType= new ProcessType();
		$processType->setName('Verhuizen');
		$processType->setIcon('fal fa-truck-moving');
		$processType->setDescription('Het doorgeven van een verhuizing aan de gemeente Eindhoven');
		$processType->setSourceOrganization('001902763');
		$processType->setExtends($verhuizenNL);
		$manager->persist($processType);
		$processType->setId($id);
		$manager->persist($processType);
		$manager->flush();
		$processType= $manager->getRepository('App:ProcessType')->findOneBy(array('id'=> $id));
		
		$stage1= new Stage();
		$stage1->setStart(true);
		$stage1->setTitle('Eigenaar');
		$stage1->setIcon('fal fa-user');
		$stage1->setSlug('eigenaar');
		$stage1->setDescription('Bent u de eigenaar van de woning waar u heen verhuist?');
		$stage1->setType('boolean');
		$stage1->setFormat('boolean');
		$stage1->setRequired(true);
		$stage1->setRequestType($processType);
		$manager->persist($stage1);
		
		$stage2= new Stage();
		$stage2->addPrevious($stage1);
		//$verhuizenNL->setId('');
		$stage2->setTitle('Doorgeven gegevens');
		$stage2->setIcon('');
		$stage2->setSlug('notificatie');
		$stage2->setDescription('Wilt u dat we uw verhuizing ook doorgeven aan postNl?');
		$stage2->setType('boolean');
		$stage2->setFormat('boolean');
		$stage2->setRequestType($processType);
		$manager->persist($stage2);
		
		/*
		 *  Trouwen
		 */
		
		$processType->setRequestType('https://vtc.zaakonline.nl/requestType/cdd7e88b-1890-425d-a158-7f9ec92c9508');
		$processType= new ProcessType();
		$processType->setSourceOrganization('0000');
		$processType->setIcon('fas fa-user-tie');
		$processType->setName('Aanvraag babs voor een dag');
		$processType->setDescription('Melding voorgenomen huwelijk');
		$manager->persist($processType);
		$processType->setId($id);
		$manager->persist($processType);
		$manager->flush();
		$processType= $manager->getRepository('App:ProcessType')->findOneBy(array('id'=> $id));
		
		$stage1= new Stage();
		$stage1->setStart(true);
		$stage1->setTitle('Gegevens');
		$stage1->setIcon('fal fa-user');
		$stage1->setSlug('babs');
		$stage1->setType('string');
		$stage1->setFormat('string');
		$stage1->setDescription('Wat zijn de contact gegevens van uw beoogd BABS');
		$stage1->setRequestType($processType);
		$manager->persist($stage1);
		
		$stage2= new Stage();
		$stage2->addPrevious($stage1);
		$stage2->setTitle('Indienen');
		$stage2->setIcon('fal fa-paper-plane');
		$stage2->setSlug('indienen');
		$stage2->setDescription('Wie zijn de getuigen van partner?');
		$stage2->setRequestType($processType);
		$manager->persist($stage2);
		
		$processType->setRequestType('https://vtc.zaakonline.nl/requestType/c8704ea6-4962-4b7e-8d4e-69a257aa9577');
		$processType= new ProcessType();
		$processType->setIcon('fal fa-rings-wedding');
		$processType->setSourceOrganization('0000');
		$processType->setName('Aanvraag trouwlocatie');
		$processType->setDescription('Melding voorgenomen huwelijk');
		$manager->persist($processType);
		$processType->setId($id);
		$manager->persist($processType);
		$manager->flush();
		$processType = $manager->getRepository('App:ProcessType')->findOneBy(array('id'=> $id));
		
		$stage1= new Stage();
		$stage1->setStart(true);
		$stage1->setTitle('Adress');
		$stage1->setIcon('fal fa-map-marked');
		$stage1->setSlug('locatie');
		$stage1->setType('string');
		$stage1->setFormat('bag');
		$stage1->setDescription('Wat zijn de adress gegevens van uw beoogde locatie');
		$stage1->setRequestType($aanvraagLocatie);
		$manager->persist($stage1);
		
		$stage2= new Stage();
		$stage2->addPrevious($stage1);
		$stage2->setTitle('Gegevens');
		$stage2->setIcon('fal fa-user');
		$stage2->setSlug('contact');
		$stage2->setType('string');
		$stage2->setFormat('instemming');
		$stage2->setDescription('Wat zijn de contact gegevens van uw beoogde locatie');
		$stage2->setRequestType($processType);
		$manager->persist($stage2);
		
		$stage3= new Stage();
		$stage3->addPrevious($stage2);
		$stage3->setTitle('Indienen');
		$stage3->setIcon('fal fa-paper-plane');
		$stage3->setSlug('indienen');
		$stage3->setDescription('Wie zijn de getuigen van partner?');
		$stage3->setRequestType($processType);
		$manager->persist($stage3);
		
		$processType->setRequestType('https://vtc.zaakonline.nl/requestType/146cb7c8-46b9-4911-8ad9-3238bab4313e');
		$processType= new ProcessType();
		$processType->setIcon('fal fa-ring');
		$processType->setSourceOrganization('0000');
		$processType->setName('Melding voorgenomen huwelijk');
		$processType->setDescription('Melding voorgenomen huwelijk');
		$manager->persist($processType);
		$processType->setId($id);
		$manager->persist($processType);
		$manager->flush();
		$processType = $manager->getRepository('App:ProcessType')->findOneBy(array('id'=> $id));
		
		$stage1= new Stage();
		$stage1->setStart(true);
		$stage1->setTitle('Datum');
		$stage1->setIcon('fas fa-calendar-day');
		$stage1->setSlug('datum');
		$stage1->setType('string');
		$stage1->setFormat('date');
		$stage1->setDescription('Selecteer een datum voor de omzetting naar huwelijk');
		$stage1->setRequestType($processType);
		$manager->persist($stage1);
		
		$stage2= new Stage();
		$stage2->addPrevious($stage1);
		$stage2->setTitle('Partners');
		$stage2->setIcon('fas fa-user-friends');
		$stage2->setSlug('partner');
		$stage2->setType('array');
		$stage2->setFormat('bsn');
		$stage2->setMinItems(2);
		$stage2->setMaxItems(2);
		$stage2->setRequired(true);
		$stage2->setDescription('Wie zijn de getuigen van partner 2?');
		$stage2->setRequestType($processType);
		$manager->persist($stage2);
		
		$stage3= new Stage();
		$stage3->addPrevious($stage2);
		$stage3->setTitle('Getuigen');
		$stage3->setIcon('fas fa-users');
		$stage3->setSlug('getuige');
		$stage3->setType('array');
		$stage3->setFormat('bsn');
		$stage3->setMinItems(2);
		$stage3->setMaxItems(4);
		$stage3->setRequired(true);
		$stage3->setDescription('Wie zijn de getuigen van partner?');
		$stage3->setRequestType($processType);
		$manager->persist($stage3);
		
		$stage4= new Stage();
		$stage4->addPrevious($stage3);
		$stage4->setTitle('Indienen');
		$stage4->setIcon('fal fa-paper-plane');
		$stage4->setSlug('indienen');
		$stage4->setDescription('Wie zijn de getuigen van partner?');
		$stage4->setRequestType($processType);
		$manager->persist($stage4);
		
		$processType->setRequestType('https://vtc.zaakonline.nl/requestType/432d3e81-5930-4c21-ab7f-c5541c948525');
		$processType= new ProcessType();
		$processType->setIcon('fal fa-rings-wedding');
		$processType->setSourceOrganization('0000');
		$processType->setName('Omzetting');
		$processType->setDescription('Het omzetten van een bestaand partnerschap in een huwelijk.');
		$manager->persist($processType);
		$processType->setId($id);
		$manager->persist($processType);
		$manager->flush();
		$processType= $manager->getRepository('App:ProcessType')->findOneBy(array('id'=> $id));
		
		$stage1= new Stage();
		$stage1->setStart(true);
		$stage1->setTitle('Datum');
		$stage1->setIcon('fas fa-calendar-day');
		$stage1->setSlug('datum');
		$stage1->setType('string');
		$stage1->setFormat('date');
		$stage1->setDescription('Selecteer een datum voor de omzetting naar huwelijk');
		$stage1->setRequestType($processType);
		$manager->persist($stage1);
		
		$stage2= new Stage();
		$stage2->addPrevious($stage1);
		$stage2->setTitle('Partners');
		$stage2->setIcon('fas fa-user-friends');
		$stage2->setSlug('partner');
		$stage2->setType('array');
		$stage2->setFormat('bsn');
		$stage2->setMinItems(2);
		$stage2->setMaxItems(2);
		$stage2->setRequired(true);
		$stage2->setDescription('Wie zijn de getuigen van partner 2?');
		$stage2->setRequestType($processType);
		$manager->persist($stage2);
		
		$stage3= new Stage();
		$stage3->addPrevious($stage2);
		$stage3->setTitle('Indienen');
		$stage3->setIcon('fal fa-paper-plane');
		$stage3->setSlug('indienen');
		$stage3->setDescription('Wie zijn de getuigen van partner?');
		$stage3->setRequestType($processType);
		$manager->persist($stage3);
		
		$processType->setRequestType('https://vtc.zaakonline.nl/requestType/5b10c1d6-7121-4be2-b479-7523f1b625f1');
		$processType= new ProcessType();
		$processType->setIcon('fal fa-rings-wedding');
		$processType->setSourceOrganization('000');
		$processType->setName('Huwelijk / Partnerschap');
		$processType->setDescription('Huwelijk / Partnerschap');
		$manager->persist($processType);
		$processType->setId($id);
		$manager->persist($processType);
		$manager->flush();
		$processType= $manager->getRepository('App:ProcessType')->findOneBy(array('id'=> $id));
		$trouwenNL = $processType;
		// Inladen van de kinderen
		/*
		 $trouwenNL->addChild($aanvraagBabs);
		 $trouwenNL->addChild($aanvraagLocatie);
		 $trouwenNL->addChild($meldingTrouwenNL);
		 */
		
		$stage1= new Stage();
		$stage1->setStart(true);
		$stage1->setTitle('Type');
		$stage1->setIcon('fas fa-ring');
		$stage1->setSlug('ceremonie');
		$stage1->setType('string');
		$stage1->setFormat('string');
		$stage1->setMaxLength('12');
		$stage1->setMinLength('7');
		$stage1->setEnum(['trouwen','partnerschap','omzetten']);
		$stage1->setRequired(true);
		$stage1->setDescription('Selecteer een huwelijk of partnerschap?');
		$stage1->setRequestType($processType);
		$manager->persist($stage1);
		
		$stage2= new Stage();
		$stage2->addPrevious($stage1);
		$stage2->setTitle('Partners');
		$stage2->setIcon('fas fa-user-friends');
		$stage2->setSlug('partner');
		$stage2->setType('array');
		$stage2->setFormat('url');
		$stage2->setIri('irc/assent');
		$stage2->setMinItems(2);
		$stage2->setMaxItems(2);
		$stage2->setRequired(true);
		$stage2->setDescription('Wie zijn de getuigen van partner 2?');
		$stage2->setRequestType($processType);
		$manager->persist($stage2);
		
		$stage3= new Stage();
		$stage3->addPrevious($stage2);
		$stage3->setTitle('Plechtigheid  ');
		$stage3->setIcon('fas fa-glass-cheers');
		$stage3->setSlug('plechtigheid');
		$stage3->setType('string');
		$stage3->setFormat('url');
		$stage3->setIri('pdc/product');
		$stage3->setDescription('Onder welke uri kunnen we de bestaande \'melding voorgenomen huwelijk\' terugvinden?');
		$stage3->setRequestType($processType);
		$manager->persist($stage3);
		
		$stage4= new Stage();
		$stage4->addPrevious($stage3);
		$stage4->setTitle('Datum');
		$stage4->setIcon('fas fa-calendar-day');
		$stage4->setSlug('datum');
		$stage4->setType('string');
		$stage4->setFormat('date');
		$stage4->setDescription('Selecteer een datum voor de omzetting naar huwelijk');
		$stage4->setRequestType($processType);
		$manager->persist($stage4);
		
		$stage5= new Stage();
		$stage5->addPrevious($stage4);
		$stage5->setTitle('Locatie');
		$stage5->setIcon('fas fa-building');
		$stage5->setSlug('locatie');
		$stage5->setType('string');
		$stage5->setFormat('uri');
		$stage5->setIri('pdc/product');
		$stage5->setMaxLength('255');
		$stage5->setRequired(true);
		$stage5->setDescription('We gebruiken de order om de bestelling (bestaande uit locatie, ambtenaar en eventuele extra\'s) op te slaan');
		$stage5->setRequestType($processType);
		$manager->persist($stage5);
		
		$stage6= new Stage();
		$stage6->addPrevious($stage5);
		$stage6->setTitle('Ambtenaar');
		$stage6->setIcon('fas fa-user-tie');
		$stage6->setSlug('ambtenaar');
		$stage6->setType('string');
		$stage6->setFormat('url');
		$stage6->setIri('pdc/product');
		$stage6->setMaxLength('255');
		$stage6->setRequired(true);
		$stage6->setDescription('We gebruiken de order om de bestelling (bestaande uit locatie, ambtenaar en eventuele extra\'s) op te slaan');
		$stage6->setRequestType($processType);
		$manager->persist($stage6);
		
		$stage7= new Stage();
		$stage7->addPrevious($stage6);
		$stage7->setTitle('Getuigen');
		$stage7->setIcon('fas fa-users');
		$stage7->setSlug('getuige');
		$stage7->setType('array');
		$stage7->setFormat('url');
		$stage7->setIri('irc/assent');
		$stage7->setMinItems(2);
		$stage7->setMaxItems(4);
		$stage7->setRequired(true);
		$stage7->setDescription('Wie zijn de getuigen van partner?');
		$stage7->setRequestType($processType);
		$manager->persist($stage7);
		
		$stage8= new Stage();
		$stage8->addPrevious($stage7);
		$stage8->setTitle('Extras');
		$stage8->setIcon('fas fa-gift');
		$stage8->setSlug('extra');
		$stage8->setType('array');
		$stage8->setFormat('url');
		$stage8->setIri('pdc/product');
		$stage8->setMinItems(1);
		$stage8->setRequired(true);
		$stage8->setDescription('Wie zijn de getuigen van partner?');
		$stage8->setRequestType($processType);
		$manager->persist($stage8);
		
		$overige = new Stage();
		$overige->addPrevious($stage8);
		$overige->setTitle('Overig');
		$overige->setIcon('fal fa-file-alt');
		$overige->setSlug('overig');
		$overige->setType('array');
		$overige->setMinItems(4);
		$overige->setFormat('string');
		$overige->setDescription('Graag zouden wij u om wat extra informatie vragen');
		$overige->setRequestType($processType);
		$manager->persist($overige);
		
		$stage9= new Stage();
		$stage9->addPrevious($overige);
		$stage9->setTitle('Melding ');
		$stage9->setIcon('fas fa-envelope');
		$stage9->setSlug('melding');
		$stage9->setType('string');
		$stage9->setFormat('url');
		$stage9->setIri('vrc/request');
		$stage9->setDescription('Onder welke uri kunnen we de bestaande \'melding voorgenomen huwelijk\' terugvinden?');
		$stage9->setRequestType($processType);
		$manager->persist($stage9);
		
		$stage10= new Stage();
		$stage10->addPrevious($stage9);
		$stage10->setTitle('Betalen ');
		$stage10->setIcon('fas fa-cash-register');
		$stage10->setSlug('betalen');
		$stage10->setType('string');
		$stage10->setFormat('url');
		$stage10->setIri('orc/order');
		$stage10->setDescription('Onder welke uri kunnen we de bestaande \'melding voorgenomen huwelijk\' terugvinden?');
		$stage10->setRequestType($processType);
		$manager->persist($stage10);
		
		$stage11= new Stage();
		$stage11->addPrevious($stage10);
		$stage11->setTitle('Reserveren ');
		$stage11->setIcon('fas fa-calendar-check');
		$stage11->setSlug('checklist');
		$stage11->setDescription('Onder welke uri kunnen we de bestaande \'melding voorgenomen huwelijk\' terugvinden?');
		$stage11->setRequestType($processType);
		$manager->persist($stage11);
		
		$property= new Stage();
		//$property->setId('');
		$property->setTitle('Order');
		$property->setType('string');
		$property->setFormat('url');
		$property->setIri('orc/order');
		$property->setMaxLength('255');
		$property->setRequired(true);
		$property->setDescription('We gebruiken de order om de bestelling (bestaande uit locatie, ambtenaar en eventuele extra\'s) op te slaan');
		$property->setRequestType($processType);
		$manager->persist($property);
		
		$processType->setRequestType('https://vtc.zaakonline.nl/requestType/47577f44-0ede-4655-a629-027f051d2b07');
		$processType= new ProcessType();
		$processType->setExtends($trouwenNL);
		$processType->setSourceOrganization('002220647');
		$processType->setName('Trouwen of Partnerschap in Utrecht');
		$processType->setDescription('Trouwen of Partnerschap in Utrecht');
		$manager->persist($processType);
		$processType->setId($id);
		$manager->persist($processType);
		
		$manager->flush();
	}
}
