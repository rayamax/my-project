<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Repository\ArticleRepository;

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
            'controller_name' => 'Toto',
             'articles'=>$articles
        ]);
    }

    /**
     * @Route("/article/new", name="article_create")
     */
    public function createArticle(){
        return $this->render('article/create.html.twig');
    }

    /**
     * @Route("/article/{id}", name="article_show")
     */
    public function show($id){
        $repo = $this->getDoctrine()->getRepository(Article::class);

        $article = $repo->find($id);

        return $this->render('article/article.html.twig',[
            'article' =>$article
        ]);
    }


}
