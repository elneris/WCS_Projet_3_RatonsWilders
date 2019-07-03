<?php

namespace App\DataFixtures;

use App\Entity\City;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CityFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $csv = fopen("public/assets/city.csv", 'r');
        while (($column = fgetcsv($csv, 700, ',', '"')) !== false) {

            $city = new City();
            $city->setName($column[1]);
            $city->setPopulation($column[3]);
            $manager->persist($city);
            $manager->flush();

        }
    }
}
