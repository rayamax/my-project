<?php

namespace App\Controller;


use App\Entity\Comment;
use App\Entity\User;
use App\Form\ArticleType;
use App\Form\CommentType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Article;
use Symfony\Component\Security\Core\Security;

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
     * @Route("/liste", name="list_articles")
     */
    public function liste(ArticleRepository $repo)
    {

        //dd($articles);

        $articles = $repo->findAll();

        return $this->render('article/liste.html.twig', [
            'articles'=>$articles
        ]);
    }

    /**
     * @Route("/article/{id}", name="article_show")
     */
    public function show(Article $article, Request $request, ObjectManager $manager){
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        $user = $this->getUser();
        if ($form->isSubmitted() && $form->isValid()){
            $comment->setCreatedAt(new \DateTime())
                    ->setArticle($article)
                    ->setAuthor($user->getPseudo())
                    ->setUser($user);

            $manager->persist($comment);
            $manager->flush();
            return $this->redirectToRoute('article_show',[
                'id' => $article->getId()
            ]);
        }

        return $this->render('article/article.html.twig',[
            'article' =>$article,
            'commentForm' => $form->createView()
        ]);
    }
}
