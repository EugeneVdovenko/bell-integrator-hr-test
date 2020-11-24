<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10000; $i++) {

            $book = new Book();
            $book->setName(sprintf("Книга %s", $i));
            for ($j = 0; $j < random_int(1, 3); $j++) {
                $author = new Author();
                $author->setName(sprintf("Автор %s-%s Авторович", $i, $j));
                $manager->persist($author);
                $book->addAuthor($author);
            }
            $manager->persist($book);
        }

        $manager->flush();
    }
}
