<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Factory\AuthorsFactory;
use App\Factory\EditorsFactory;
use App\Factory\UsersFactory;
use App\Factory\BooksFactory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        AuthorsFactory::createMany(50);
        EditorsFactory::createMany(20);
        UsersFactory::createMany(5);
        BooksFactory::createMany(100);
    }
}
