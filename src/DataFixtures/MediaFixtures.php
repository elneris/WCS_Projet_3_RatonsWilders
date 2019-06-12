<?php

namespace App\DataFixtures;

use App\Entity\Media;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class MediaFixtures extends Fixture implements DependentFixtureInterface
{

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

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {

        $media = new Media();
        $media->setName('youtube');
        $media->setUrl('https://www.youtube.com/playlist?list=PLjwdMgw5TTLX7wmorGgfrqI9TcA8nMb29');
        $media->setType('Vidéo');
        $media->setUser($this->getReference('user_0'));
        $manager->persist($media);

        $media1 = new Media();
        $media1->setName('Mon image');
        $media1->setUrl('https://cdn.pixabay.com/photo/2013/07/04/11/04/google-images-143148_960_720.png');
        $media1->setType('Image');
        $media1->setUser($this->getReference('user_0'));
        $manager->persist($media1);


        $manager->flush();
    }
}
