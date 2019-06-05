<?php

namespace App\DataFixtures;

use App\Entity\Style;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class StyleFixtures extends Fixture
{
    const DATA = [
        'Blues',
        'Funk',
        'Folk',
        'Illusionniste',
        'Tango',
    ];

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach (self::DATA as $key => $styleType) {
            $style = new Style();
            $style->setType($styleType);
            $manager->persist($style);
            $this->addReference('style_' . $key, $style);
        }

        $manager->flush();
    }
}
