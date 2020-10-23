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
        $section->setProperties(["{$this->commonGroundService->getComponent('vtc')['location']}/properties/db69ce35-4ae1-4aac-936f-bdb5d4d1ff18"]);
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Soort Ceremonie');
        $section->setDescription('Als jullie gaan trouwen zijn moet je kiezen tussen gratis, eenvoudig en ceremonieel trouwen. Dit
                    bepaalt hoeveel keuze je hebt bij het kiezen van je locatie, trouwdatum en trouwambtenaren.');
        $section->setProperties($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'db69ce35-4ae1-4aac-936f-bdb5d4d1ff18']));
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Partner');
        $section->setDescription('Met wie wilt u trouwen');
        $section->setProperties($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'db69ce35-4ae1-4aac-936f-bdb5d4d1ff18']));
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
        $section->setProperties($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'db69ce35-4ae1-4aac-936f-bdb5d4d1ff18']));
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Locatie');
        $section->setDescription('De keuze in trouwlocatie is afhankelijk van het type huwelijk (gratis, eenvoudig of ceremonieel). Als het type huwelijk de mogelijkheid biedt om een locatie te kiezen, is het nodig dat jullie aangeven  waar jullie het huwelijk willen laten voltrekken.');
        $section->setProperties($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'db69ce35-4ae1-4aac-936f-bdb5d4d1ff18']));

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
        $section->setProperties($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'db69ce35-4ae1-4aac-936f-bdb5d4d1ff18']));
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
        $section->setProperties($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'db69ce35-4ae1-4aac-936f-bdb5d4d1ff18']));
        $stage->addSection($section);

        $processType->addStage($stage);

        $stage = new Stage();
        $stage->setName('Overige gegevens');
        $stage->setIcon('fal fa-users');
        $stage->setSlug('Er zijn natuurlijk ook een aantal andere vragen waarvan we van u een antwoord moeten weten');
        $stage->setDescription('Wie treed op als belanghebbende?');

        $section = new Section();
        $section->setName('Contact gegevens');
        $section->setDescription('Trouwen of partnerschap');
        $section->setProperties($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'db69ce35-4ae1-4aac-936f-bdb5d4d1ff18']));
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Naamsgebruik');
        $section->setDescription('Trouwen of partnerschap');
        $section->setProperties($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '/db69ce35-4ae1-4aac-936f-bdb5d4d1ff18']));
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Taal');
        $section->setDescription('Trouwen of partnerschap');
        $section->setProperties($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'db69ce35-4ae1-4aac-936f-bdb5d4d1ff18']));
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Extras');
        $section->setDescription('Het is mogelijk om extra opties te kiezen om je ceremonie extra feestelijk te maken, zoals
                    bijvoorbeeld een trouwboekje als aandenken aan het huwelijk.');
        $section->setProperties($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'db69ce35-4ae1-4aac-936f-bdb5d4d1ff18']));
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Opmerkingen');
        $section->setDescription('Trouwen of partnerschap');
        $section->setProperties($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'db69ce35-4ae1-4aac-936f-bdb5d4d1ff18']));
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Melding voorgenomen huwelijk');
        $section->setDescription('Voordat je gaat trouwen of een geregistreerd partnerschap aangaat is het wettelijk verplicht een melding voorgenomen huwelijk te gaan doen. Dit moet minimaal 14 dagen voordat de ceremonie voltrokken wordt.');
        $section->setProperties($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'db69ce35-4ae1-4aac-936f-bdb5d4d1ff18']));
        $stage->addSection($section);

        $section = new Section();
        $section->setName('Betaling');
        $section->setDescription('Tenzij je voor een gratis huwelijk hebt gekozen moet je betalen voor je huwelijk. De kosten zijn ');
        $section->setProperties($this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'db69ce35-4ae1-4aac-936f-bdb5d4d1ff18']));
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
