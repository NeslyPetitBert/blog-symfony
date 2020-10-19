<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
       
        $faker = \Faker\Factory::create('fr_FR');
        
        //Catégories
        for($cg = 1; $cg <= 4; $cg++){
            $category = new Category();
            $category->setTitle($faker->sentence())
                    ->setDescription($faker->paragraph());

            $manager->persist($category);

            for($a = 1; $a <= mt_rand(4, 6); $a++){
                $article = new Article();

                $content = '<p>' . join($faker->paragraphs(5), '</p><p>') . '</p>';

                $article->setTitle($faker->sentence())
                        ->setContent($content)
                        ->setPicture($faker->imageUrl()) // ->setPicture($faker->imageUrl(350, 150))
                        ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                        ->setUpdatedAt(new \DateTime())
                        ->setCategory($category);
                $manager->persist($article);

                for($cm = 1; $cm <= mt_rand(4, 10); $cm++){
                    $comment = new Comment();
                    
                    $content = '<p>' . join($faker->paragraphs(5), '</p><p>') . '</p>';

                    $now = new \DateTime();

                    $interval = $now->diff($article->getCreatedAt());
                    $days = $interval->days;
                    $minimum = '-' . $days . ' days'; // -100 days

                    $comment->setAuthor($faker->name)
                            ->setContent($content)
                            ->setCreatedAt($faker->dateTimeBetween($minimum))
                            ->setArticle($article);
                    
                    $manager->persist($comment);
                }
            }
        }

        $manager->flush();
    }
}
