<?php

namespace App\Controller;


use App\Form\ArticleType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Article;

class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(ArticleRepository $repo)
    {

        //dd($articles);

        $articles = $repo->findAll();

         return $this->render('article/index.html.twig', [
             'articles'=>$articles
        ]);
    }


    /**
     * @Route("/article/{id}", name="article_show")
     */
    public function show($id, ArticleRepository $repo){

        $article = $repo->find($id);

        return $this->render('article/article.html.twig',[
            'article' =>$article
        ]);
    }


}
