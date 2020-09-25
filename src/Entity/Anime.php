<?php

namespace App\Entity;

use App\Repository\AnimeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnimeRepository::class)
 */
class Anime
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=120)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $nom_jp;

    /**
     * @ORM\Column(type="smallint")
     */
    private $date_debut;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $date_fin;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $nb_episodes;

    /**
     * @ORM\Column(type="string", length=120, nullable=true)
     */
    private $nom_romaji;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $realisateur;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $scenariste;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $genre;

    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    private $studio;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getNomJp(): ?string
    {
        return $this->nom_jp;
    }

    public function setNomJp(?string $nom_jp): self
    {
        $this->nom_jp = $nom_jp;

        return $this;
    }

    public function getDateDebut(): ?int
    {
        return $this->date_debut;
    }

    public function setDateDebut(int $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?int
    {
        return $this->date_fin;
    }

    public function setDateFin(?int $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getNbEpisodes(): ?int
    {
        return $this->nb_episodes;
    }

    public function setNbEpisodes(?int $nb_episodes): self
    {
        $this->nb_episodes = $nb_episodes;

        return $this;
    }

    public function getNomRomaji(): ?string
    {
        return $this->nom_romaji;
    }

    public function setNomRomaji(?string $nom_romaji): self
    {
        $this->nom_romaji = $nom_romaji;

        return $this;
    }

    public function getRealisateur(): ?string
    {
        return $this->realisateur;
    }

    public function setRealisateur(?string $realisateur): self
    {
        $this->realisateur = $realisateur;

        return $this;
    }

    public function getScenariste(): ?string
    {
        return $this->scenariste;
    }

    public function setScenariste(?string $scenariste): self
    {
        $this->scenariste = $scenariste;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getStudio(): ?string
    {
        return $this->studio;
    }

    public function setStudio(?string $studio): self
    {
        $this->studio = $studio;

        return $this;
    }
}
