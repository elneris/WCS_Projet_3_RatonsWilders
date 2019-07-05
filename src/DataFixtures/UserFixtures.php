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
            'role' => 'ROLE_USER',

        ],
        [
            'firstname' => 'Cha',
            'lastname' => 'Marvu',
            'role' => 'ROLE_USER',
        ],
        [
            'firstname' => 'Florent',
            'lastname' => 'Duval',
            'role' => 'ROLE_USER',
        ],
        [
            'firstname' => 'Maxime',
            'lastname' => 'Vasseur',
            'role' => 'ROLE_USER',
        ],
        [
            'firstname' => 'Pascal',
            'lastname' => 'Encinas',
            'role' => 'ROLE_USER',
        ],
        [
            'firstname' => 'Xavier',
            'lastname' => 'Crochet',
            'role' => 'ROLE_USER',
        ],
        [
            'firstname' => 'raton',
            'lastname' => 'admin',
            'role' => 'ROLE_ADMIN',
        ],
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
            $user->setRoles([$artist['role']]);
            $user->setEnable(true);

            if ($artist['role'] == 'ROLE_ADMIN') {
                $this->addReference('admin', $user);
            } else {
                $this->addReference('user_' . $key, $user);
            }
            $manager->persist($user);
        }


        $manager->flush();
    }
}
