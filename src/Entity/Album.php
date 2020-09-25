<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AlbumRepository")
 * @UniqueEntity("titre")
 */
class Album
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Artiste", inversedBy="albums")
     * @ORM\JoinColumn(nullable=false)
     */
    private $artiste;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $couverture;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private $titre;

    /**
     * @ORM\Column(type="smallint")
     */
    private $date_sortie;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $favori;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="albums_favoris")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArtiste(): ?artiste
    {
        return $this->artiste;
    }

    public function setArtiste(?Artiste $artiste): self
    {
        $this->artiste = $artiste;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCouverture(): ?string
    {
        return $this->couverture;
    }

    public function setCouverture(?string $couverture): self
    {
        $this->couverture = $couverture;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDateSortie(): ?int
    {
        return $this->date_sortie;
    }

    public function setDateSortie(int $date_sortie): self
    {
        $this->date_sortie = $date_sortie;

        return $this;
    }

    public function __toString(): ?string
    {
        return $this->titre;
    }

    public function getFavori(): ?bool
    {
        return $this->favori;
    }

    public function setFavori(?bool $favori): self
    {
        $this->favori = $favori;

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
            $user->addAlbumFavori($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeAlbumFavori($this);
        }

        return $this;
    }
}
