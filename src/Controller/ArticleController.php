<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        $articles = $repository->findAll();

        //dd($articles);

         return $this->render('article/index.html.twig', [
            'controller_name' => 'Toto',
             'articles'=>$articles
        ]);
    }

    /**
     * @Route("/article/1", name="article_show")
     */
    public function show(){
        return $this->render('article/article.html.twig');

    }

}
