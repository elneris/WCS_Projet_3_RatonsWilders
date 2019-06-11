<?php

namespace App\DataFixtures;

use App\Entity\Domain;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class DomainFixtures extends Fixture
{
    const DATA = [
        'Musique',
        'Magie',
        'Danse',
    ];

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach (self::DATA as $key => $domainName) {
            $domain = new Domain();
            $domain->setName($domainName);
            $manager->persist($domain);
            $this->addReference('domain_' . $key, $domain);
        }

        $manager->flush();
    }
}
