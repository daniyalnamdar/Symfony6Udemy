<?php

namespace App\DataFixtures;

use App\Entity\MicroPost;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $microPost = new MicroPost();
        $microPost->setTitle('Welcome to Turkey!');
        $microPost->setText('Welcome to Turkey!');
        $microPost->setCreated(new \DateTime());
        $manager->persist($microPost);

        $microPost1 = new MicroPost();
        $microPost1->setTitle('Welcome to Iran!');
        $microPost1->setText('Welcome to Iran!');
        $microPost1->setCreated(new \DateTime());
        $manager->persist($microPost1);

        $microPost2 = new MicroPost();
        $microPost2->setTitle('Welcome to Germany!');
        $microPost2->setText('Welcome to Germany!');
        $microPost2->setCreated(new \DateTime());
        $manager->persist($microPost2);

        $manager->flush();
    }
}
