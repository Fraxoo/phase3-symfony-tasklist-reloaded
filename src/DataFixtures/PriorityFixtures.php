<?php

namespace App\DataFixtures;

use App\Entity\Priority;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PriorityFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $priority = new Priority();
        $priority->setLevel("normal");

        $manager->persist($priority);

        $manager->flush();
    }
}
