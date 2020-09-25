<?php

namespace App\Controller;

use App\Entity\Artiste;
use App\Entity\Article;
use App\Entity\Album;
use App\Entity\ArtisteLike;
use App\Entity\User;
use App\Repository\ArtisteLikeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class JapanController extends AbstractController
{
    /**
     * Redirect the symfony home page to the website home page.
     * @Route("/", name="homepage")
     *
     * @return void
     */
    public function redirectToAccueil()
    {
        return $this->redirectToRoute('accueil');
    }
    /**
     * @Route("/accueil", name="accueil")
     */
    public function accueil()
    {
        $artisteRepository = $this->getDoctrine()->getRepository(Artiste::class);

        $artiste1 = $artisteRepository->findOneByNom('Mariya Takeuchi');

        $artiste2 = $artisteRepository->findOneByNom('Shizuka Kudo');

        $artiste3 = $artisteRepository->findOneByNom('Hiromi Go');

        $artiste4 = $artisteRepository->findOneByNom('Yoko Oginome');

        $artiste5 = $artisteRepository->findOneByNom('Yasuha');

        $favori1 = ['legende' => "Yasuha - Flyday Chinatown", 'lien' => "https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/488401680&color=%23ff5500&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true&visual=true"];

        $favori2 = ['legende' => "I RE'IN FOR RE'IN - Mystery Girl", 'lien' => "https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/241916642&color=%23ff5500&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true&visual=true"];

        //$anime = ;

        return $this->render('accueil.html.twig', [
            'artiste1' => $artiste1, 'artiste2' => $artiste2, 'favori1' => $favori1, 'favori2' => $favori2,
            'artiste3' => $artiste3, 'artiste4' => $artiste4, 'artiste5' => $artiste5
        ]);
    }

    /**
     * @Route("/city-pop-description", name="japan80Histoire")
     */
    public function histoire()
    {
        return $this->render('japan80Histoire.html.twig');
    }


    /**
     * @Route("/artistes", name="index_artistes")
     */
    public function indexArtistes()
    {
        $artisteRepository = $this->getDoctrine()->getRepository(Artiste::class);

        $lesArtistes = $artisteRepository->findBy(array(), array('nom' => 'ASC'));

        return $this->render('artistes/artistes.html.twig', ['artistes' => $lesArtistes]);
    }

    /**
     * @Route("/quiSuisJe", name="qui_suis_je")
     */
    public function quiSuisje()
    {

        $albumRepository = $this->getDoctrine()->getRepository(Album::class);
        $artisteRepository = $this->getDoctrine()->getRepository(Artiste::class);

        $lesAlbums = $albumRepository->findBy(array('favori' => 'true'), array('titre' => 'ASC'));
        $lesArtistes = $artisteRepository->findBy(array('favori' => 'true'), array('nom' => 'ASC'));


        return $this->render('aPropos/quiSuisJe.html.twig', ['albumsFavoris' => $lesAlbums, 'artistesFavoris' => $lesArtistes]);
    }


    /**
     * @Route("/artistes/{nom}", name="artiste_show")
     */
    public function showArtiste(Artiste $artiste)
    {
        // $artiste will equal the dynamic part of the URL
        // e.g. at /artiste/yoko-oginome, then $artiste='yogo-oginome'

        $articleRepository = $this->getDoctrine()->getRepository(Article::class);
        $albumRepository = $this->getDoctrine()->getRepository(Album::class);

        $article = $articleRepository->findOneByArtisteId($artiste->getId());

        if ($article == null) {
            throw $this->createNotFoundException('L\'article est introuvable...');
        }

        $albums = $albumRepository->findAlbumsByArtisteId($artiste->getid());
        $singles = $albumRepository->findSinglesByArtisteId($artiste->getId());
        $dateDeNaissance = $artiste->getDateDeNaissance()->format('d/m/Y');

        return $this->render('artistes/artiste.html.twig', ['artiste' => $artiste, 'article' => $article, 'dateDeNaissance' => $dateDeNaissance, 'albums' => $albums, 'singles' => $singles]);
    }
}
