<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Anime;
use App\Entity\AnimeLike;
use App\Repository\AnimeLikeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;

class AnimeController extends AbstractController
{

    /**
     * @Route("/anime/edit/{id}")
     */
    public function update($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $anime = $entityManager->getRepository(anime::class)->find($id);

        if (!$anime) {
            throw $this->createNotFoundException(
                'No product found for id ' . $id
            );
        }

        //$anime->set('');
        $entityManager->flush();

        return $this->redirectToRoute('anime_show', [
            'id' => $anime->getId()
        ]);
    }

    /**
     * Permet de liker ou unliker un anime.
     * 
     * @Route("/animes/{nom}/like", name="anime_like")
     *
     * @param Anime $anime
     * @param AnimeLikeRepository $likeRepo
     * @return Response
     */
    public function like(anime $anime, AnimeLikeRepository $likeRepo): Response
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        if (!$user) {
            return $this->json([
                'code' => 403,
                'message' => 'Non autorisé'
            ], 403);
        }

        // si l'anime est like par le user, on retire le like
        if ($anime->isLikedByUser($user)) {
            $like = $likeRepo->findOneBy([
                'anime' => $anime,
                'user' => $user
            ]);

            $em->remove($like);
            $em->flush();

            return $this->json([
                'code' => 200,
                'message' => 'like supprimé',
                'likes' => $likeRepo->count(['anime' => $anime])
            ], 200);
        }

        // l'anime n'est pas like, on doit creer le like
        $like = new animeLike();
        $like->setanime($anime)
            ->setUser($user);

        $em->persist($like);
        $em->flush();

        return $this->json([
            'code' => 200,
            'message' => 'Like ajouté',
            'likes' => $likeRepo->count(['anime' => $anime])
        ], 200);
    }
}
