<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        for ($i = 1; $i <=10;$i++){
            $article = new Article();
            $article->setTitle("Titre de l'article $i")
                    ->setContent("<p>Contenu de l'article $i</p>")
                    ->setImage("http://placehold.it/800x600")
                    ->setResume("Résumé de l'article")
                    ->setCompetition("Compétition")
                    ->setCreatedAt(new \DateTime());
            $manager->persist($article);
        }

        $manager->flush();
    }
}
