<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    const USERS = [
        [
            'firstname' => 'Elnéris',
            'lastname' => 'Dang',
        ],
        [
            'firstname' => 'Cha',
            'lastname' => 'Marvu',
        ],
        [
            'firstname' => 'Florent',
            'lastname' => 'Duval',
        ],
        [
            'firstname' => 'Maxime',
            'lastname' => 'Vasseur',
        ],
        [
            'firstname' => 'Pascal',
            'lastname' => 'Encinas',
        ],
        [
            'firstname' => 'Xavier',
            'lastname' => 'Crochet',
        ]
    ];
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
        foreach (self::USERS as $key => $artist) {
            $user = new User();
            $firstname = $artist['firstname'];
            $lastname = $artist['lastname'];
            $email = $firstname . '@gmail.com';
            $user->setEmail($email);
            $user->setPassword($this->passwordEncoder->encodePassword($user, 'root'));
            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            $user->setArtistName($firstname . rand(1, 100));
            $user->setRoles(['ROLE_USER']);
            $user->setEnable(true);

            $manager->persist($user);
            $this->addReference('user_' . $key, $user);
        }

        $admin = new User();
        $email = 'raton_admin@test.fr';
        $admin->setEmail($email);
        $admin->setPassword($this->passwordEncoder->encodePassword($admin, 'root'));
        $admin->setFirstname('raton');
        $admin->setLastname('admin');
        $admin->setArtistName("raton admin");
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setEnable(true);

        $manager->persist($admin);
        $this->addReference('admin', $admin);

        $manager->flush();
    }
}
