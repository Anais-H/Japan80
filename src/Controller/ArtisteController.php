<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Artiste;
use App\Entity\ArtisteLike;
use App\Repository\ArtisteLikeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;

class ArtisteController extends AbstractController
{
    /**
     * @Route("/artiste/create", name="create_artiste")
     */
    public function createArtiste(): Response
    {
        $dateDeNaissance = "17-01-1961";
        $dateDebut = 1981;
        $dateFin = 1988;

        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to the action: createArtiste(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();

        $artiste = new Artiste();
        $artiste->setNom('Yasuha');
        $artiste->setNomJp('泰葉');
        $artiste->setDateDeNaissance(new \DateTime($dateDeNaissance));
        $artiste->setGenre("f");
        $artiste->setDateDebut($dateDebut);
        if (isset($dateFin) && !empty($dateFin)) {
            $artiste->setDateFin($dateFin);
        }


        // tell Doctrine you want to (eventually) save the Artiste (no queries yet)
        $entityManager->persist($artiste);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Enregistrement du nouvel artiste avec l\'id ' . $artiste->getId());
    }


    /**
     * @Route("/artiste/edit/{id}")
     */
    public function update($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $artiste = $entityManager->getRepository(Artiste::class)->find($id);

        if (!$artiste) {
            throw $this->createNotFoundException(
                'No product found for id ' . $id
            );
        }

        //$artiste->set('');
        $entityManager->flush();

        return $this->redirectToRoute('artiste_show', [
            'id' => $artiste->getId()
        ]);
    }

    /**
     * @Route("/artiste/{id}", name="artiste_show")
     */
    public function show(Artiste $artiste)
    {
        // use the Product!
        // ...
    }

    /**
     * Permet de liker ou unliker un artiste.
     * 
     * @Route("/artistes/{nom}/like", name="artiste_like")
     *
     * @param Artiste $artiste
     * @param ArtisteLikeRepository $likeRepo
     * @return Response
     */
    public function like(Artiste $artiste, ArtisteLikeRepository $likeRepo): Response
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        if (!$user) {
            return $this->json([
                'code' => 403,
                'message' => 'Non autorisé'
            ], 403);
        }

        // si l'artiste est like par le user, on retire le like
        if ($artiste->isLikedByUser($user)) {
            $like = $likeRepo->findOneBy([
                'artiste' => $artiste,
                'user' => $user
            ]);

            $em->remove($like);
            $em->flush();

            return $this->json([
                'code' => 200,
                'message' => 'like supprimé',
                'likes' => $likeRepo->count(['artiste' => $artiste])
            ], 200);
        }

        // l'artiste n'est pas like, on doit creer le like
        $like = new ArtisteLike();
        $like->setArtiste($artiste)
            ->setUser($user);

        $em->persist($like);
        $em->flush();

        return $this->json([
            'code' => 200,
            'message' => 'Like ajouté',
            'likes' => $likeRepo->count(['artiste' => $artiste])
        ], 200);
    }
}
