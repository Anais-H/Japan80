<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfilDescriptionType;
use App\Form\ProfilPictureType;
use App\Form\ProfilPlaylistType;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class UserController extends AbstractController
{
    /**
     * Retourne la page de profil d'un utilisateur spécifique. Cette page n'est pas la page de profil de l'utilisateur actuellement connecté.
     * @Route("/utilisateur/{pseudo}", name="page_utilisateur")
     */
    public function index(User $user)
    {
        $artistesLikes = $user->getArtisteLikes(); // Retourne des objets de artisteLikes

        $artistesFavoris = []; // on crée le tableau des artistes likes et on le remplit
        foreach ($artistesLikes as $artisteLike) {
            $artistesFavoris[] = $artisteLike->getArtiste();
        }

        $albumsFavoris = [];

        return $this->render('user/index.html.twig', ['user' => $user, 'artistesFavoris' => $artistesFavoris, 'albumsFavoris' => $albumsFavoris]);
    }

    /**
     * Retourne la page de profil de l'utilisateur actuellement connecté et pouvant alors modifier ses informations.
     * @Route("/monProfil", name="profil_utilisateur")
     *
     * @param Request $request
     * @return Response
     */
    public function profilUtilisateur(Request $request, LoggerInterface $logger, SluggerInterface $slugger): Response
    {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non connecté.');
        }

        $artisteLikes = $user->getArtisteLikes();
        $artistesFavoris = [];
        $albumsFavoris = [];

        foreach ($artisteLikes as $artisteLike) {
            $artistesFavoris[] = $artisteLike->getArtiste();
        }

        //formulaire edition de la photo de profil

        $pictureForm = $this->createForm(ProfilPictureType::class, $user);
        $pictureForm->handleRequest($request);

        if ($pictureForm->isSubmitted() && $pictureForm->isValid()) {
            $file = $pictureForm->get('profilPictureFile')->getData();

            if ($file) {
                $fileExtension = $file->guessExtension();
                if (!$fileExtension) {
                    $fileExtension = 'bin';
                }

                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);

                $fileName = 'user_pp_' . $safeFilename . '.' . $fileExtension;

                try {
                    $file->move($this->getParameter('users_pp_dir'), $fileName);
                } catch (FileException $e) {
                    return $this->json([
                        'code' => 400,
                        'message' => 'Le fichier n\'a pas pu être téléchargé.',
                    ], 400);
                }

                $user->setProfilPicture($fileName);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                return $this->json([
                    'code' => 200,
                    'message' => 'Description mise à jour',
                    'newPicture' => $fileName,
                ], 200);
            }
        }

        // formulaire edition de la description

        $descriptionForm = $this->createForm(ProfilDescriptionType::class, $user);
        $descriptionForm->handleRequest($request);

        if ($descriptionForm->isSubmitted()) {
            if ($descriptionForm->isValid()) {

                $newDescription = $descriptionForm->get('description')->getData();
                $user->setDescription($newDescription);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                return $this->json([
                    'code' => 200,
                    'message' => 'Description mise à jour',
                    'newDescription' => $newDescription,
                    'pseudo' => $user->getPseudo()
                ], 200);
            } else {

                $html = $this->render('user/_description_form.html.twig', [
                    'descriptionForm' => $descriptionForm->createView()
                ]);

                return new Response($html, 400);
            }
        }

        // formulaire edition de la playlist

        $playlistForm = $this->createForm(ProfilPlaylistType::class, $user);
        $playlistForm->handleRequest($request);

        if ($playlistForm->isSubmitted()) {
            if ($playlistForm->isValid()) {

                $data = $playlistForm->get('playlistLink')->getData();
                $playlistLink = '';

                if ($data) {
                    $playlistLinkTable =  explode('/', $data);
                    $playlistLinkSuffixe = $playlistLinkTable[sizeof($playlistLinkTable) - 1]; // on prend juste la fin de l'url
                    // on utilise str_replace pour le cas de la playlist
                    $playlistLink = "https://www.youtube.com/embed/" . str_replace("playlist", "videoseries", $playlistLinkSuffixe);
                }

                $user->setPlaylistLink($playlistLink);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                return $this->json([
                    'code' => 200,
                    'message' => 'Playlist mise à jour',
                    'newPlaylist' => $playlistLink,
                    'pseudo' => $user->getPseudo()
                ], 200);
            } else {

                $html = $this->render('user/_playlist_form.html.twig', [
                    'playlistForm' => $playlistForm->createView()
                ]);

                return new Response($html, 400);
            }
        }

        return $this->render('user/profil.html.twig', [
            'artistesFavoris' => $artistesFavoris,
            'albumsFavoris' => $albumsFavoris,
            'pictureForm' => $pictureForm->createView(),
            'descriptionForm' => $descriptionForm->createView(),
            'playlistForm' => $playlistForm->createView(),
        ]);
    }

    /**
     * @Route("/monProfil/editDescription", name="edit_profil_description")
     *
     * @param string $description
     * @return Response
     */
    public function editDescription(Request $request): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->json([
                'code' => 403,
                'message' => 'Non autorisé'
            ], 403);
        }

        $em = $this->getDoctrine()->getManager();

        $content = json_decode($request->getContent());
        $description = $content->description;
        $user->setDescription($description);

        $em->persist($user);
        $em->flush();

        return $this->json([
            'code' => 200,
            'message' => 'Description mise à jour',
            'newDescription' => $description,
            'pseudo' => $user->getPseudo()
        ], 200);
    }
}
