<?php

// src/DataFixtures/JobFixtures.php

namespace App\DataFixtures;

use App\Entity\Job;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class JobFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $slugify = new Slugify();

        $job1 = new Job();
        $job1->setTitle('Software Engineer');
        $job1->setDescription('Develop software applications');
        $job1->setSlug($slugify->slugify($job1->getTitle()));
        $manager->persist($job1);

        $job2 = new Job();
        $job2->setTitle('Web Developer');
        $job2->setDescription('Create websites and web applications');
        $job2->setSlug($slugify->slugify($job2->getTitle()));

        $manager->persist($job2);

        $manager->flush();


        $this->addReference('job1', $job1);
        $this->addReference('job2', $job2);
    }
}