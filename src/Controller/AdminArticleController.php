<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class AdminArticleController
 * @Route("/admin")
 */
class AdminArticleController extends AbstractController
{
    /**
     * @Route("/", name="admin_access")
     */
    public function admin(){
        return $this->render('/admin/article/index.html.twig');
    }

    /**
     * @Route("/article/index", name="app_admin_article_index")
     */
    public function index()
    {
        return $this->render('/admin/article/index.html.twig');
    }

    /**
     * @Route("/new", name="app_admin_article_new")
     */
    public function new(Request $request, ObjectManager $manager){
        $article = new Article();
        $form = $this->createForm(ArticleType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $article = $form->getData();
            $article->setCreatedAt(new \DateTime());
            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('article_show',['id' => $article->getId()]);
        }


        return $this->render('admin/article/new.html.twig', [
            'form' =>$form->createView()
        ]);
    }

    /**
     * @Route("/article/{id}/edit", name="app_admin_article_edit")
     */
    public function edit(Article $article, Request $request, ObjectManager $manager){

        $form = $this->createForm(ArticleType::class, $article);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('article_show',['id' => $article->getId()]);
        }


        return $this->render('admin/article/edit.html.twig', [
            'form' =>$form->createView(),
        ]);
    }
    /**
     * @Route("/article/remove/{id}", name="app_admin_remove_article")
     */
    public function removeArticle(Article $article, ObjectManager $entityManager){
        $entityManager->remove($article);
        $entityManager->flush();
        return $this->redirectToRoute('list_articles');
    }
    /**
     * @Route("/article/removeComment/{id}", name="app_admin_remove_comment")
     */
    public function removeComment(Comment $comment, ObjectManager $entityManager){
        $entityManager->remove($comment);
        $entityManager->flush();
        return $this->redirectToRoute('list_articles');
    }
    /**
     * @Route("/liste", name="app_admin_list_articles")
     */
    public function liste(ArticleRepository $repo)
    {

        //dd($articles);

        $articles = $repo->findAll();

        return $this->render('admin/article/list.html.twig', [
            'articles'=>$articles
        ]);
    }
}
