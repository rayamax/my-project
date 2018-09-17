<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(ArticleRepository $repository)
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
    public function show(ArticleRepository $repository){
        return $this->render('article/article.html.twig');

    }

}
