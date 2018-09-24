<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = \Faker\Factory::create('fr_FR');
        $content = '<p>';
        $content .= join($faker->paragraphs(5),'</p><p>');
        $content .= '</p>';

        for ($i = 1; $i <=mt_rand(4,6);$i++){
            $article = new Article();
            $article->setTitle($faker->sentence())
                    ->setContent($content)
                    ->setImage($faker->imageUrl())
                    ->setResume($faker->sentence())
                    ->setCompetition($faker->sentence())
                    ->setCreatedAt($faker->dateTimeBetween('-6 months'));
            $manager->persist($article);

            for($j = 1; $j<= mt_rand(4,8);$j++){
                $comment = new Comment();
                $content = '<p>' . join($faker->paragraphs(2), '</p><p>') . '</p>';

                $now = new \DateTime();
                $interval = $now->diff($article->getCreatedAt());
                $days = $interval->days;
                $minimum = '-' . $days . ' days';

                $comment->setAuthor($faker->name)
                        ->setContent($content)
                        ->setCreatedAt($faker->dateTimeBetween($minimum))
                        ->setArticle($article);
                $manager->persist($comment);


            }
        }

        $manager->flush();
    }
}
