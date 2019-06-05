<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i <5; $i++) {
            $user = new User();
            $email = 'test' . $i . '@test.fr';
            $user->setEmail($email);
            $user->setPassword('root');
            $user->setFirstname('test');
            $user->setLastname($i);
            $user->setArtistName("test $i");
            $manager->persist($user);
            $this->addReference('user_' . $i, $user);
        }

        $manager->flush();
    }
}
