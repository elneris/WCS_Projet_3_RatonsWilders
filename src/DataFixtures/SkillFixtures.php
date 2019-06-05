<?php

namespace App\DataFixtures;

use App\Entity\Skill;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SkillFixtures extends Fixture
{
    const DATA = [
        'guitare',
        'basse',
        'violon',
    ];

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach (self::DATA as $key => $skillName) {
            $skill = new Skill();
            $skill->setName($skillName);
            $manager->persist($skill);
            $this->addReference('skill_' . $key, $skill);
        }

        $manager->flush();
    }
}
