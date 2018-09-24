<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\Common\Persistence\ObjectManager;
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
     * @Route("/article/index", name="app_admin_article_index")
     */
    public function index()
    {
        return $this->render('/admin/article/index.html.twig');
    }

    /**
     * @Route("/article/new", name="app_admin_article_new")
     */
    public function new(Request $request, ObjectManager $manager){
        $article = new Article();
        $form = $this->createForm(ArticleType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $article = $form->getData();

            return $this->redirectToRoute('app_admin_article_index');
        }


        return $this->render('admin/article/new.html.twig', [
            'form' =>$form->createView(),
            'editMode' => $article->getId() !== null
        ]);
    }

    /**
     * @Route("/article/{id}/edit", name="app_admin_article_edit")
     */
    public function edit(Request $request, ObjectManager $manager){

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


        return $this->render('admin/article/edit.html.twig', [
            'form' =>$form->createView(),
            'editMode' => $article->getId() !== null
        ]);
    }
}
