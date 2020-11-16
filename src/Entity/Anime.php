<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AnimeRepository")
 * @Vich\Uploadable
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

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="anime_image", fileNameProperty="image")
     *
     * @var File
     */
    private $imageFile;

    /**
     * @var \DateTime $updatedAt
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToOne(targetEntity=AnimeArticle::class, mappedBy="anime", cascade={"persist", "remove"})
     */
    private $article;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AnimeLike", mappedBy="anime")
     */
    private $likes;


    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->likes = new ArrayCollection();
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

    public function setImageFile(File $imageFile = null)
    {
        $this->imageFile = $imageFile;

        if ($imageFile) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getArticle(): ?AnimeArticle
    {
        return $this->article;
    }

    public function setArticle(AnimeArticle $article): self
    {
        $this->article = $article;

        // set the owning side of the relation if necessary
        if ($article->getAnime() !== $this) {
            $article->setAnime($this);
        }

        return $this;
    }


    /**
     * @return Collection|AnimeLike[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(AnimeLike $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setAnime($this);
        }

        return $this;
    }

    public function removeLike(AnimeLike $like): self
    {
        if ($this->likes->contains($like)) {
            $this->likes->removeElement($like);
            // set the owning side to null (unless already changed)
            if ($like->getAnime() === $this) {
                $like->setAnime(null);
            }
        }

        return $this;
    }

    /**
     * Permet de savoir si cet article est like par un utilisateur.
     * 
     */
    public function isLikedByUser(User $user): bool
    {
        foreach ($this->likes as $like) {
            if ($like->getUser() === $user) {
                return true;
            }
        }

        return false;
    }
}
