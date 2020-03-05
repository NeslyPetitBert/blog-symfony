<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($a = 1; $a <= 10; $a++){
            $article = new Article();
            $article->setTitle("Titre de l'article n°$a")
                    ->setContent("<p>Contenu de l'article</p>")
                    ->setPicture("http://placehold.it/350x150")
                    ->setCreatedAt(new \DateTime())
                    ->setUpdatedAt(new \DateTime());
            $manager->persist($article);
        }

        $manager->flush();
    }
}
