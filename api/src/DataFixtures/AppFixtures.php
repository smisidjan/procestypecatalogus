<?php

namespace App\DataFixtures;

use App\Entity\ProcessType;
use App\Entity\Stage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $verhuizenNl = new ProcessType();
        $verhuizenNl->setName('Verhuizen');
        $verhuizenNl->setSubtitle('Geef uw verhuizing door');
        $verhuizenNl->setDescription('Via dit procces geeft u een verhuizing door aan de gemeente waar u gaat wonen');
        $verhuizenNl->setLogo('');
        $verhuizenNl->setSourceOrganization('000');
        $verhuizenNl->setRequest('http://vtc.zaakonline.nl/request_types/83f968c3-4798-4e31-91d6-2b09c9695d30');

        $stage1 = new Stage();
        $stage1->setName('Addres');
        $stage1->setDescription('Geef uw verhuizing door');
        $stage1->setLogo('');
        $stage1->setType('user');
        $stage1->setProcess($verhuizenNl);
        $stage1->setProperty('http://vtc.zaakonline.nl/properties/a4b81d82-1c79-4948-bafb-69a25ed06d43');
        // Adde to the procces
        $verhuizenNl->addStage($stage1);

        $stage2 = new Stage();
        $stage2->setName('Datum');
        $stage2->setDescription('Vanaf welke datum wilt u op het nieuwe adres wonen?');
        $stage2->setLogo('');
        $stage2->setType('user');
        $stage2->setProcess($verhuizenNl);
        $stage2->setProperty('http://vtc.zaakonline.nl/properties/bd30321c-3a88-4e7b-9484-08621ea71f7a');
        // Setup chronology
        $stage2->setPrevious($stage1);
        // Adde to the procces
        $verhuizenNl->addStage($stage2);

        $stage3 = new Stage();
        $stage3->setName('Wie');
        $stage3->setDescription('Wie gaan er allemaal (mee) verhuizen?');
        $stage3->setLogo('');
        $stage3->setType('user');
        $stage3->setProcess($verhuizenNl);
        $stage3->setProperty('http://vtc.zaakonline.nl/properties/bd8e3c41-6821-412c-ab08-7009912b8b82');
        // Setup chronology
        $stage3->setPrevious($stage1);
        // Adde to the procces
        $verhuizenNl->addStage($stage3);

        $manager->persist($verhuizenNl);

        $verhuizenEindhoven = new ProcessType();
        $verhuizenEindhoven->setExtends($verhuizenNl);
        $verhuizenEindhoven->setName('Verhuizen');
        $verhuizenEindhoven->setSubtitle('Geef uw verhuizing door');
        $verhuizenEindhoven->setDescription('Via dit procces geeft u een verhuizing door aan de gemeente Eindhoven');
        $verhuizenEindhoven->setLogo('');
        $verhuizenEindhoven->setSourceOrganization('001902763');
        $verhuizenEindhoven->setRequest('http://vtc.zaakonline.nl/request_types/1eb92f5a-5298-43b1-962b-474ba956b0d9');

        $stage4 = new Stage();
        $stage4->setName('Eigenaar');
        $stage4->setDescription('Word u de eigenaar van uw nieuwe adress?');
        $stage4->setLogo('');
        $stage4->setType('user');
        $stage4->setProcess($verhuizenEindhoven);
        $stage4->setProperty('http://vtc.zaakonline.nl/properties/44c048ce-bc55-4566-ba67-66de43c0782f');
        // Setup chronology
        //$stage4->setPrevious($stage3);
        // Adde to the procces
        $verhuizenEindhoven->addStage($stage4);

        $stage5 = new Stage();
        $stage5->setName('Doorgeven gegevens');
        $stage5->setDescription('Mogen wij uw verhuizing doorgeven aan postnl?');
        $stage5->setLogo('');
        $stage5->setType('user');
        $stage5->setProcess($verhuizenEindhoven);
        $stage5->setProperty('http://vtc.zaakonline.nl/request_types/83f968c3-4798-4e31-91d6-2b09c9695d30');
        // Setup chronology
        $stage5->setPrevious($stage4);
        // Adde to the procces
        $verhuizenEindhoven->addStage($stage5);

        $manager->persist($verhuizenEindhoven);

        $verhuizenDb = new ProcessType();
        $verhuizenDb->setExtends($verhuizenNl);
        $verhuizenDb->setName('Verhuizen');
        $verhuizenDb->setSubtitle('Geef uw verhuizing door');
        $verhuizenDb->setDescription('Via dit procces geeft u een verhuizing door aan de gemeente \'s-Hertogenbosh');
        $verhuizenDb->setLogo('');
        $verhuizenDb->setSourceOrganization('001709124');
        $verhuizenDb->setRequest('http://vtc.zaakonline.nl/request_types/9d76fb58-0711-4437-acc4-9f4d9d403cdf');
        $manager->persist($verhuizenDb);

        $trouwenNl = new ProcessType();
        $trouwenNl->setName('Trouwen / Partnerschap');
        $trouwenNl->setSubtitle('Geef uw huwelijk of partnerschap door');
        $trouwenNl->setDescription('Via dit procces meld u uw voorgenomen huwelijk of partnerschap bij de gemeente waar u deze wilt voltrekken');
        $trouwenNl->setLogo('');
        $trouwenNl->setSourceOrganization('000');
        $trouwenNl->setRequest('http://vtc.zaakonline.nl/request_types/78cf071f-437a-470c-b8a5-38097a670fe0');
        $manager->persist($trouwenNl);

        $manager->flush();
    }
}
