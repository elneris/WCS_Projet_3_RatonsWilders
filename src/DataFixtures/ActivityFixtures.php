<?php

namespace App\DataFixtures;

use App\Entity\Activity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ActivityFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            UserFixtures::class,
            DomainFixtures::class,
            SkillFixtures::class,
            StyleFixtures::class];
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $activity = new Activity();

        $activity->setUser($this->getReference('user_0'));
        $activity->setDomain($this->getReference('domain_0'));
        $activity->setSkill($this->getReference('skill_0'));
        $activity->setStyle($this->getReference('style_0'));
        $manager->persist($activity);

        $activity1 = new Activity();

        $activity1->setUser($this->getReference('user_1'));
        $activity1->setDomain($this->getReference('domain_0'));
        $activity1->setSkill($this->getReference('skill_0'));
        $activity1->setStyle($this->getReference('style_2'));
        $manager->persist($activity1);

        $activity2 = new Activity();

        $activity2->setUser($this->getReference('user_2'));
        $activity2->setDomain($this->getReference('domain_1'));
        $activity2->setStyle($this->getReference('style_3'));
        $manager->persist($activity2);

        $activity3 = new Activity();

        $activity3->setUser($this->getReference('user_3'));
        $activity3->setDomain($this->getReference('domain_2'));
        $activity3->setStyle($this->getReference('style_4'));
        $manager->persist($activity3);

        $activity4 = new Activity();

        $activity4->setUser($this->getReference('user_4'));
        $activity4->setDomain($this->getReference('domain_0'));
        $activity4->setStyle($this->getReference('style_1'));
        $activity4->setSkill($this->getReference('skill_0'));
        $manager->persist($activity4);

        $activity5 = new Activity();

        $activity5->setUser($this->getReference('user_5'));
        $activity5->setDomain($this->getReference('domain_0'));
        $activity5->setStyle($this->getReference('style_2'));
        $activity5->setSkill($this->getReference('skill_1'));
        $manager->persist($activity5);

        $manager->flush();
    }
}
