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
        $user = new User();
        $firstname = 'Elnéris';
        $lastname = 'Dang';
        $email = $firstname . '@gmail.com';
        $user->setEmail($email);
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'root'));
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setArtistName('elneris33');
        $user->setRoles(['ROLE_USER']);
        $user->setEnable(true);

        $manager->persist($user);
        $this->addReference('user_' . 0, $user);

        $user1 = new User();
        $firstname = 'Cha';
        $lastname = 'Marvu';
        $email = $firstname . '@gmail.com';
        $user1->setEmail($email);
        $user1->setPassword($this->passwordEncoder->encodePassword($user, 'root'));
        $user1->setFirstname($firstname);
        $user1->setLastname($lastname);
        $user1->setArtistName('chacha');
        $user1->setRoles(['ROLE_USER']);
        $user->setEnable(true);

        $manager->persist($user1);
        $this->addReference('user_' . 1, $user1);

        $user2 = new User();
        $firstname = 'Florent';
        $lastname = 'Duval';
        $email = $firstname . '@gmail.com';
        $user2->setEmail($email);
        $user2->setPassword($this->passwordEncoder->encodePassword($user, 'root'));
        $user2->setFirstname($firstname);
        $user2->setLastname($lastname);
        $user2->setArtistName('Florent33');
        $user2->setRoles(['ROLE_USER']);
        $user->setEnable(true);

        $manager->persist($user2);
        $this->addReference('user_' . 2, $user2);

        $user3 = new User();
        $firstname = 'Maxime';
        $lastname = 'Vasseur';
        $email = $firstname . '@gmail.com';
        $user3->setEmail($email);
        $user3->setPassword($this->passwordEncoder->encodePassword($user, 'root'));
        $user3->setFirstname($firstname);
        $user3->setLastname($lastname);
        $user3->setArtistName('Zertexx');
        $user3->setRoles(['ROLE_USER']);
        $user->setEnable(true);

        $manager->persist($user3);
        $this->addReference('user_' . 3, $user3);

        $user4 = new User();
        $firstname = 'Pascal';
        $lastname = 'Encinas';
        $email = $firstname . '@gmail.com';
        $user4->setEmail($email);
        $user4->setPassword($this->passwordEncoder->encodePassword($user, 'root'));
        $user4->setFirstname($firstname);
        $user4->setLastname($lastname);
        $user4->setArtistName('Pascalou');
        $user4->setRoles(['ROLE_USER']);
        $user->setEnable(true);

        $manager->persist($user4);
        $this->addReference('user_' . 4, $user4);

        $user5 = new User();
        $firstname = 'Xavier';
        $lastname = 'Crochet';
        $email = $firstname . '@gmail.com';
        $user5->setEmail($email);
        $user5->setPassword($this->passwordEncoder->encodePassword($user, 'root'));
        $user5->setFirstname($firstname);
        $user5->setLastname($lastname);
        $user5->setArtistName('Xav');
        $user5->setRoles(['ROLE_USER']);
        $user->setEnable(true);

        $manager->persist($user5);
        $this->addReference('user_' . 5, $user5);

        $admin = new User();
        $email = 'raton_admin@test.fr';
        $admin->setEmail($email);
        $admin->setPassword($this->passwordEncoder->encodePassword($admin, 'root'));
        $admin->setFirstname('raton');
        $admin->setLastname('admin');
        $admin->setArtistName("raton admin");
        $admin->setRoles(['ROLE_ADMIN']);
        $user->setEnable(true);

        $manager->persist($admin);
        $this->addReference('admin', $admin);

        $manager->flush();
    }
}
