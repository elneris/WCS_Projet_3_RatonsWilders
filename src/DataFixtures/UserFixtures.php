<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i <5; $i++) {
            $user = new User();
            $email = 'test' . $i . '@test.fr';
            $user->setEmail($email);
            $user->setPassword($this->passwordEncoder->encodePassword($user, 'root'));
            $user->setFirstname('test');
            $user->setLastname($i);
            $user->setArtistName("test $i");
            $user->setUsername("test $i");
            $user->setRoles(['ROLE_USER']);


            $manager->persist($user);
            $this->addReference('user_' . $i, $user);
        }
        $admin = new User();
        $email = 'test_admin@test.fr';
        $admin->setEmail($email);
        $admin->setPassword($this->passwordEncoder->encodePassword($admin, 'root'));
        $admin->setFirstname('test');
        $admin->setLastname($i);
        $admin->setArtistName("testAdmin");
        $admin->setUsername("testAdmin");
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);
        $this->addReference('admin', $admin);

        $manager->flush();
    }
}
