<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index()
    {
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    /**
     * Home page
     *
     * @Route("/", name="home")
     * @return void
     */
    public function home()
    {
        return $this->render('blog/home.html.twig', [
            'title' => 'Bienvenue ici les amis !',
            'age' => 35
        ]);
    }

    /**
     * Undocumented function
     * 
     * @Route("/blog/articles/12", name="blog_show")
     *
     * @return void
     */
    public function show(){
        return $this->render('blog/show.html.twig');
    }
}
