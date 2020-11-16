<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="Un compte est déjà associé à cet email.")
 * @UniqueEntity(fields={"pseudo"}, message="Ce pseudo n'est pas disponible.")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email(message="Cet email n'est pas valide.")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * @Assert\NotBlank
     * @Assert\Length(max=100)
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=800, nullable=true)
     * @Assert\Length(max=800)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $playlistLink;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Artiste", inversedBy="users")
     */
    private $artistes_favoris;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Album", inversedBy="users")
     */
    private $albums_favoris;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ArtisteLike", mappedBy="user")
     */
    private $artisteLikes;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $profilPicture;

    /**
     * @ORM\OneToMany(targetEntity=AnimeLike::class, mappedBy="user", orphanRemoval=true)
     */
    private $animeLikes;

    public function __construct()
    {
        $this->albums_favoris = new ArrayCollection();
        $this->artisteLikes = new ArrayCollection();
        $this->animeLikes = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getPlaylistLink(): ?string
    {
        return $this->playlistLink;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function setPlaylistLink(string $playlistLink): self
    {
        $this->playlistLink = $playlistLink;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->pseudo;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Artiste[]
     */
    public function getArtistesFavoris(): Collection
    {
        return $this->artistes_favoris;
    }

    public function addArtisteFavori(Artiste $artisteFavori): self
    {
        if (!$this->artistes_favoris->contains($artisteFavori)) {
            $this->artistes_favoris[] = $artisteFavori;
        }

        return $this;
    }

    public function removeArtisteFavori(Artiste $artisteFavori): self
    {
        if ($this->artistes_favoris->contains($artisteFavori)) {
            $this->artistes_favoris->removeElement($artisteFavori);
        }

        return $this;
    }

    /**
     * @return Collection|Album[]
     */
    public function getAlbumsFavoris(): Collection
    {
        return $this->albums_favoris;
    }

    public function addAlbumFavori(Album $albumFavori): self
    {
        if (!$this->albums_favoris->contains($albumFavori)) {
            $this->albums_favoris[] = $albumFavori;
        }

        return $this;
    }

    public function removeAlbumFavori(Album $albumFavori): self
    {
        if ($this->albums_favoris->contains($albumFavori)) {
            $this->albums_favoris->removeElement($albumFavori);
        }

        return $this;
    }

    /**
     * @return Collection|ArtisteLike[]
     */
    public function getArtisteLikes(): Collection
    {
        return $this->artisteLikes;
    }

    public function addArtisteLike(ArtisteLike $artisteLike): self
    {
        if (!$this->artisteLikes->contains($artisteLike)) {
            $this->artisteLikes[] = $artisteLike;
            $artisteLike->setUser($this);
        }

        return $this;
    }

    public function removeArtisteLike(ArtisteLike $artisteLike): self
    {
        if ($this->artisteLikes->contains($artisteLike)) {
            $this->artisteLikes->removeElement($artisteLike);
            // set the owning side to null (unless already changed)
            if ($artisteLike->getUser() === $this) {
                $artisteLike->setUser(null);
            }
        }

        return $this;
    }

    public function getProfilPicture(): ?string
    {
        return $this->profilPicture;
    }

    public function setProfilPicture(?string $profilPicture): self
    {
        $this->profilPicture = $profilPicture;

        return $this;
    }

    public function __toString(): string
    {
        return $this->pseudo;
    }

    /**
     * @return Collection|AnimeLike[]
     */
    public function getAnimeLikes(): Collection
    {
        return $this->animeLikes;
    }

    public function addAnimeLike(AnimeLike $animeLike): self
    {
        if (!$this->animeLikes->contains($animeLike)) {
            $this->animeLikes[] = $animeLike;
            $animeLike->setUser($this);
        }

        return $this;
    }

    public function removeAnimeLike(AnimeLike $animeLike): self
    {
        if ($this->animeLikes->removeElement($animeLike)) {
            // set the owning side to null (unless already changed)
            if ($animeLike->getUser() === $this) {
                $animeLike->setUser(null);
            }
        }

        return $this;
    }
}
