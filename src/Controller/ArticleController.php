<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/blog")
 */
class ArticleController extends AbstractController
{
    /**
     * Repository des articles pour la selection des données.
     */
    private $articleRepo;

    /**
     * Le manager pour la gestion des articles (insertion, modification et suppression)
     */
    private $manager;

    /**
     * Appel du manager et du repository des articles
     *
     * @param EntityManagerInterface $manager
     * @param ArticleRepository $articleRepo
     */
    public function __construct(EntityManagerInterface $manager, ArticleRepository $articleRepo)
    {
        $this->manager = $manager;
        $this->articleRepo = $articleRepo;
    }
    
    /**
     * @Route("/articles", name="article_index", methods={"GET"})
     */
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $this->articleRepo->findAll();

        return $this->render('blog/article/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/article/new", name="article_new", methods={"GET","POST"})
     * @Route("/article/{id}/edit", name="article_edit", methods={"GET","POST"})
     */
    public function save(Article $article = null, Request $request): Response
    {
        if(!$article){
            $article = new Article();
        }

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if(!$article->getId()){
                $article->setCreatedAt(new \DateTime());
            }
            $article->setUpdatedAt(new \DateTime());

            $this->manager->persist($article);
            $this->manager->flush();

            return $this->redirectToRoute('article_show', [
                'id' => $article->getId(),
            ]);
        }

        return $this->render('blog/article/save.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
            'editMode' => $article->getId() !== null,
        ]);
    }

    /**
     * @Route("/article/{id}/show", name="article_show", methods={"GET","POST"})
     */
    public function show(Article $article, Request $request, EntityManagerInterface $manager): Response
    {
        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $comment->setCreatedAt(new \DateTime())
                    ->setArticle($article);
            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('article_show', [
                'id' => $article->getId()
            ]);
        }
        return $this->render('blog/article/show.html.twig', [
            'article' => $article,
            'commentForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/article/{id}/delete", name="article_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $this->manager->remove($article);
            $this->manager->flush();
        }

        return $this->redirectToRoute('article_index');
    }
}
