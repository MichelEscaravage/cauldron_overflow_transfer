<?php

// src/DataFixtures/CommentFixtures.php

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $user1 = $this->getReference('user1');
        $user2 = $this->getReference('user2');

        $job1 = $this->getReference('job1');
        $job2 = $this->getReference('job2');


        $comment1 = new Comment();
        $comment1->setTitle('Great job!');
        $comment1->setDescription('Keep up the good work.');
        $comment1->setUser($user1);
        $comment1->setJob($job1);
        $manager->persist($comment1);

        $comment2 = new Comment();
        $comment2->setTitle('Nice work');
        $comment2->setDescription('Impressive!');
        $comment2->setUser($user2);
        $comment2->setJob($job2);
        $manager->persist($comment2);


        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            JobFixtures::class,
        ];
    }
}