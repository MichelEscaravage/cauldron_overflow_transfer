<?php
namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $user1 = new User();
        $user1->setName('John Doe');
        $user1->setUsername('john_doe');
        $manager->persist($user1);

        $user2 = new User();
        $user2->setName('Jane Smith');
        $user2->setUsername('jane_smith');
        $manager->persist($user2);


        $manager->flush();


        $this->addReference('user1', $user1);
        $this->addReference('user2', $user2);
    }
}

