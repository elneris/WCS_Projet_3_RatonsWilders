<?php

namespace App\DataFixtures;

use App\Entity\Link;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class LinkFixtures extends Fixture implements DependentFixtureInterface
{
    const URL = [
    'https://www.facebook.com/elne',
    'https://www.github.com/charlene',
    'https://www.facebook.com/maxime',
    ];


    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach (self::URL as $key => $urlLink) {
            $link = new Link();
            $link->setUrl($urlLink);
            $link->setType('url');
            $link->setUser($this->getReference('user_0'));
            $manager->persist($link);
        }

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [UserFixtures::class];
    }
}
