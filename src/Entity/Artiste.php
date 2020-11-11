<?php

namespace App\Entity;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArtisteRepository")
 * @UniqueEntity("nom")
 * @Vich\Uploadable
 */
class Artiste
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * @Gedmo\Slug(fields={"artisteNom"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom_jp;

    /**
     * @ORM\Column(type="date")
     */
    private $date_de_naissance;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $genre;

    /**
     * @ORM\Column(type="integer")
     */
    private $date_debut;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $date_fin;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Album", mappedBy="artiste")
     * @ORM\JoinColumn(nullable=true)
     */
    private $albums;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $courte_description;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $lieu_naissance;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="artistes_favoris")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ArtisteLike", mappedBy="artiste")
     */
    private $likes;

    /**
     * @ORM\ManyToMany(targetEntity=Groupe::class, mappedBy="artistes")
     */
    private $groupes;

    /**
     * @ORM\ManyToMany(targetEntity=Anime::class, mappedBy="artistes")
     */
    private $animes;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $nom_alternatif;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="artiste_image", fileNameProperty="image")
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


    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->likes = new ArrayCollection();
        $this->groupes = new ArrayCollection();
        $this->animes = new ArrayCollection();
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

    public function setNomJp(string $nom_jp): self
    {
        $this->nom_jp = $nom_jp;

        return $this;
    }

    public function getDateDeNaissance(): ?\DateTimeInterface
    {
        return $this->date_de_naissance;
    }

    public function setDateDeNaissance(\DateTimeInterface $date_de_naissance): self
    {
        $this->date_de_naissance = $date_de_naissance;

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

    public function getAlbums()
    {
        return $this->albums;
    }

    public function addAlbum(Album $album): self
    {
        if (!$this->albums->contains($album)) {
            $this->albums[] = $album;
        }
        return $this;
    }

    public function __toString(): ?string
    {
        return $this->nom;
    }

    public function getCourteDescription(): ?string
    {
        return $this->courte_description;
    }

    public function setCourteDescription(?string $courte_description): self
    {
        $this->courte_description = $courte_description;

        return $this;
    }

    public function getLieuNaissance(): ?string
    {
        return $this->lieu_naissance;
    }

    public function setLieuNaissance(?string $lieu_naissance): self
    {
        $this->lieu_naissance = $lieu_naissance;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addArtisteFavori($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeArtisteFavori($this);
        }

        return $this;
    }

    /**
     * @return Collection|ArtisteLike[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(ArtisteLike $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setArtiste($this);
        }

        return $this;
    }

    public function removeLike(ArtisteLike $like): self
    {
        if ($this->likes->contains($like)) {
            $this->likes->removeElement($like);
            // set the owning side to null (unless already changed)
            if ($like->getArtiste() === $this) {
                $like->setArtiste(null);
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

    /**
     * @return Collection|Groupe[]
     */
    public function getGroupes(): Collection
    {
        return $this->groupes;
    }

    public function addGroupe(Groupe $groupe): self
    {
        if (!$this->groupes->contains($groupe)) {
            $this->groupes[] = $groupe;
            $groupe->addArtiste($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupes->contains($groupe)) {
            $this->groupes->removeElement($groupe);
            $groupe->removeArtiste($this);
        }

        return $this;
    }

    /**
     * @return Collection|Anime[]
     */
    public function getAnimes(): Collection
    {
        return $this->animes;
    }

    public function addAnime(Anime $anime): self
    {
        if (!$this->animes->contains($anime)) {
            $this->animes[] = $anime;
            $anime->addArtiste($this);
        }

        return $this;
    }

    public function removeAnime(Anime $anime): self
    {
        if ($this->animes->contains($anime)) {
            $this->animes->removeElement($anime);
            $anime->removeArtiste($this);
        }

        return $this;
    }

    public function getNomAlternatif(): ?string
    {
        return $this->nom_alternatif;
    }

    public function setNomAlternatif(?string $nom_alternatif): self
    {
        $this->nom_alternatif = $nom_alternatif;

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
}
