<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnimeArticleController extends AbstractController
{
    /**
     * @Route("/anime/article", name="anime_article")
     */
    public function index(): Response
    {
        return $this->render('anime_article/index.html.twig', [
            'controller_name' => 'AnimeArticleController',
        ]);
    }
}
