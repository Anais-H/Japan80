<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Artiste;
use App\Entity\Album;

class AlbumController extends AbstractController
{

    /**
     * @Route("/album/create", name="create_album")
     */
    public function createArticle(): Response
    {
        $artisteRepository = $this->getDoctrine()->getRepository(Artiste::class);

        $artiste = $artisteRepository->findOneByNom("Yasuha");

        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to the action: createArticle(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();

        $album = new Album();
        $album->setTitre('Natsu no Koi Jealousy');
        $album->setType('single');
        //$album->setType('album');
        $album->setDateSortie(1984);
        $album->setArtiste($artiste);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($album);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new album with id '.$album->getId());
    }

    /**
     * @Route("/album", name="album")
     */
    public function index()
    {
        return $this->render('album/index.html.twig', [
            'controller_name' => 'AlbumController',
        ]);
    }
}
