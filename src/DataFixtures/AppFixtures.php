<?php

namespace App\DataFixtures;

use App\Entity\Events;
use DateTime;
//use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\MakerBundle\Generator;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        //$faker = Factory::create();


        $this->name = "jamal";
        $this->description = "test";
        $this->datetime = date('Y-m-d h:i:sp');
        
        $this->place = "place";
        $this->image = "http://testing.com";

        for ($i = 0; $i < 1; $i++) {
            $customer = new Events();
            $customer->setName($this->name);
            $customer->setDescription($this->description);
            $customer->setDateTime($this->datetime);
            $customer->setPlace($this->place);
            $customer->setImageUrl($this->image);
            $manager->persist($customer);
        }


        $manager->flush();
    }
}
