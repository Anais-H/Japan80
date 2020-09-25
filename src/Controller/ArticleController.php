<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Artiste;
use App\Entity\Article;

class ArticleController extends AbstractController
{

     /**
     * @Route("/article/create", name="create_article")
     */
    public function createArticle(): Response
    {
        $artisteRepository = $this->getDoctrine()->getRepository(Artiste::class);

        $artiste = $artisteRepository->findOneByNom("Yasuha");

        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to the action: createArticle(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();

        $article = new Article();
        $article->setBannerPlayList('https://www.youtube.com/embed/videoseries?list=PLFqnJsmyHfyeF3JUhoxh0Mz6u_aqrhRBe');
        $article->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
        $article->setArtisteId($artiste);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($article);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new article with id '.$article->getId());
    }


    /**
     * @Route("/article/edit/{id}")
     */
    public function update($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $article = $entityManager->getRepository(Article::class)->find($id);

        if (!$article) {
            throw $this->createNotFoundException(
                'No article found for id '.$id
            );
        }

        //$article->setBannerPlaylist('');
        //$article->setBannerImage('shizuka kudo.jpg')
        $entityManager->flush();

        return $this->redirectToRoute('article', [
            'id' => $article->getId()
        ]);
    }

    /**
    * @Route("/article/{id}", name="article_show")
    */
    public function show(Article $article)
    {
        // use the Product!
        // ...
    }


    /**
     * @Route("/article", name="article")
     */
    public function index()
    {
        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }
}
