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
     * @Route("/article/new", name="article_create")
     * @Route("/article/{id}/edit", name="article_edit")
     */
    public function form(Article $article = null, Request $request, ObjectManager $manager){

        if (!$article){
            $article = new Article();
        }

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            if (!$article->getId()){
                $article->setCreatedAt(new \DateTime());
            }

            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('article_show',['id' => $article->getId()]);
        }


        return $this->render('article/create.html.twig', [
            'form' =>$form->createView(),
            'editMode' => $article->getId() !== null
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
