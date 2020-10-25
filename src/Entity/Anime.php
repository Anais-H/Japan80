<?php

namespace App\Entity;

use App\Repository\AnimeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $nb_episodes;

    /**
     * @ORM\Column(type="string", length=120, nullable=true)
     */
    private $nom_romaji;

    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    private $studio;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_debut;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_fin;

    /**
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    private $realisateur;

    /**
     * @ORM\ManyToMany(targetEntity=Artiste::class, inversedBy="animes")
     */
    private $artistes;

    /**
     * @ORM\ManyToMany(targetEntity=AnimeGenre::class, inversedBy="animes")
     */
    private $genres;

    /**
     * @ORM\Column(type="text")
     */
    private $courte_description;

    public function __construct()
    {
        $this->genres = new ArrayCollection();
        $this->artistes = new ArrayCollection();
    }

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

    public function getStudio(): ?string
    {
        return $this->studio;
    }

    public function setStudio(?string $studio): self
    {
        $this->studio = $studio;

        return $this;
    }


    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(?\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(?\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

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

    public function __toString()
    {
        return $this->nom;
    }

    /**
     * @return Collection|Artiste[]
     */
    public function getArtistes(): Collection
    {
        return $this->artistes;
    }

    public function addArtiste(Artiste $artiste): self
    {
        if (!$this->artistes->contains($artiste)) {
            $this->artistes[] = $artiste;
        }

        return $this;
    }

    public function removeArtiste(Artiste $artiste): self
    {
        if ($this->artistes->contains($artiste)) {
            $this->artistes->removeElement($artiste);
        }

        return $this;
    }

    /**
     * @return Collection|AnimeGenre[]
     */
    public function getGenres(): Collection
    {
        return $this->genres;
    }

    public function addGenre(AnimeGenre $genre): self
    {
        if (!$this->genres->contains($genre)) {
            $this->genres[] = $genre;
        }

        return $this;
    }

    public function removeGenre(AnimeGenre $genre): self
    {
        $this->genres->removeElement($genre);

        return $this;
    }

    public function getCourteDescription(): ?string
    {
        return $this->courte_description;
    }

    public function setCourteDescription(string $courte_description): self
    {
        $this->courte_description = $courte_description;

        return $this;
    }
}
