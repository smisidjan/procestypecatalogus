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

class UtrechtFixtures extends Fixture
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
            $this->params->get('app_domain') != 'huwelijksplanner.online' && strpos($this->params->get('app_domain'), 'huwelijksplanner.online') == false
        ) {
            return false;
        }

        /*
         *  Huwelijk
         */

        $id = Uuid::fromString('5b10c1d6-7121-4be2-b479-7523f1b625f1');
        $processType = new ProcessType();
        $processType->setIcon('fal fa-rings-wedding');
        $processType->setSourceOrganization('000');
        $processType->setName('Huwelijk / Partnerschap');
        $processType->setDescription('Huwelijk / Partnerschap');
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'request_types', 'id' => '5b10c1d6-7121-4be2-b479-7523f1b625f1']));
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage = new Stage();
        $stage->setName('Hoe wilt u trouwen?');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('huwelijk-ceremonie');
        $stage->setDescription('Als je gaat trouwen moet je veel regelen. Om je wat overzicht te geven hebben we hieronder een lijstje gemaakt van alles wat je met de Gemeente moet regelen. We leggen het ook uit in een  filmpje.');

        $section = new Section();
        $section->setName('Soort huwelijk');
        $section->setDescription('Jullie moeten een keuze maken of jullie een huwelijk of een geregistreerd partnerschap willen
                    afsluiten. Als je nog niet weet welke keuze je moet maken kan je op de site van de <a
                        href="https://www.rijksoverheid.nl/onderwerpen/trouwen-samenlevingscontract-en-geregistreerd-partnerschap/vraag-en-antwoord/wat-is-het-verschil-tussen-een-huwelijk-geregistreerd-partnerschap-en-samenlevingscontract">Rijksoverheid</a>
                    lezen waar je rekening mee moet houden.');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '87505278-75bb-44a7-8593-cc1a9a7cc767'])]);
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Soort Ceremonie');
        $section->setDescription('Als jullie gaan trouwen zijn moet je kiezen tussen gratis, eenvoudig en ceremonieel trouwen. Dit
                    bepaalt hoeveel keuze je hebt bij het kiezen van je locatie, trouwdatum en trouwambtenaren.');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '1a87072e-efcd-4cc3-b364-d4c0775617fd'])]);
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Partner');
        $section->setDescription('Met wie wilt u trouwen');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '8357401c-0551-4f75-891f-a0c7f4b72d41'])]);
        $stage->addSection($section);

        $processType->addStage($stage);

        $stage = new Stage();
        $stage->setName('Ambtenaar en Locatie');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('ambtenaar-locatie');
        $stage->setDescription('De keuze in trouwlocatie is afhankelijk van het type huwelijk (gratis, eenvoudig of ceremonieel). Als het type huwelijk de mogelijkheid biedt om een locatie te kiezen, is het nodig dat jullie aangeven  waar jullie het huwelijk willen laten voltrekken.');

        $section = new Section();
        $section->setName('Ambtenaar');
        $section->setDescription('De trouwambtenaar is degene die het huwelijk met jullie gaat voltrekken. De keuze in trouwambtenaar
                    is afhankelijk van het type huwelijk (gratis, eenvoudig of ceremonieel). Als het type huwelijk de
                    mogelijkheid biedt om een trouwambtenaar te kiezen, is het nodig dat jullie aangeven welke
                    trouwambtenaar jullie willen voor jullie ceremonie. Je kan hier ook lezen wat je moet doen om een
                    vriend of vriendin ambtenaar voor een dag te laten zijn.');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'bf0def7c-0fcf-4418-b960-fa3a8e66e6c1'])]);
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Locatie');
        $section->setDescription('De keuze in trouwlocatie is afhankelijk van het type huwelijk (gratis, eenvoudig of ceremonieel). Als het type huwelijk de mogelijkheid biedt om een locatie te kiezen, is het nodig dat jullie aangeven  waar jullie het huwelijk willen laten voltrekken.');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '5908ddf4-a221-405f-a981-02b76aeeae58'])]);

        $stage->addSection($section);

        $stage = new Stage();
        $stage->setName('Wanneer wilt u trouwen?');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('Jullie moeten kiezen wanneer je bij de Gemeente de plechtigheid wil laten voltrekken. De beschikbare
                    data zijn afhankelijk van het type ceremonie (gratis, eenvoudig of ceremonieel) en optioneel de ambtenaar of locatie');
        $stage->setDescription('Wie treed op als belanghebbende?');

        $section = new Section();
        $section->setName('Datum');
        $section->setDescription('Jullie moeten kiezen wanneer je bij de Gemeente de plechtigheid wil laten voltrekken. De beschikbare
                    data zijn afhankelijk van het type ceremonie (gratis, eenvoudig of ceremonieel) en optioneel de ambtenaar of locatie.');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'c253faeb-9a17-4db5-b1dc-f9f7b87847df'])]);
        $stage->addSection($section);

        $processType->addStage($stage);

        $stage = new Stage();
        $stage->setName('Getuigen');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('getuigen');
        $stage->setDescription('Bij het trouwen of geregistreerde partnerschap is het wettelijk verplicht dat er minimaal twee getuigen aanwezig zijn, één voor elke partner. Er zijn maximaal 4 getuigen toegestaan bij Gemeente Utrecht.');

        $section = new Section();
        $section->setName('Getuigen');
        $section->setDescription('Trouwen of partnerschap');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '02d72f6c-cacb-4f41-a54f-f735c6dab1f6'])]);
        $stage->addSection($section);

        $processType->addStage($stage);

        $stage = new Stage();
        $stage->setName('Overige gegevens');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('Er zijn natuurlijk ook een aantal andere vragen waarvan we van u een antwoord moeten weten');
        $stage->setDescription('Wie treed op als belanghebbende?');

        $section = new Section();
        $section->setName('Naamsgebruik');
        $section->setDescription('Welke naam wenst u te gebruiken');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'ebbeed6e-2023-4b71-a6c7-31fcaa4fe3a6'])]);
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Taal');
        $section->setDescription('taal van de plechtigheid');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'fcdbd0db-4cf2-48e1-aef4-16291ebb4b35'])]);
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Extras');
        $section->setDescription('Het is mogelijk om extra opties te kiezen om je ceremonie extra feestelijk te maken, zoals
                    bijvoorbeeld een trouwboekje als aandenken aan het huwelijk.');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'd29869c0-39ce-4691-a059-249e5ae0da9f'])]);
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Opmerkingen');
        $section->setDescription('Trouwen of partnerschap');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '025f4395-b90f-434f-91a4-a19bcf9de83d'])]);
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Melding voorgenomen huwelijk');
        $section->setDescription('Voordat je gaat trouwen of een geregistreerd partnerschap aangaat is het wettelijk verplicht een melding voorgenomen huwelijk te gaan doen. Dit moet minimaal 14 dagen voordat de ceremonie voltrokken wordt.');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '05db9c53-cf96-47d9-926f-0dac80cd3d61'])]);
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Betaling');
        $section->setDescription('Tenzij je voor een gratis huwelijk hebt gekozen moet je betalen voor je huwelijk.');
        $section->setProperties([$this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '0c601e21-43df-4910-afb3-54e93b60aaa5'])]);
        $stage->addSection($section);

        $processType->addStage($stage);

        // Save it all to the db
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $manager->flush();
    }
}
