<?php

namespace App\Entity;

use App\Repository\AnimeArticleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=AnimeArticleRepository::class)
 * @Vich\Uploadable
 */
class AnimeArticle
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Anime::class, inversedBy="article", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $anime;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $playlist;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $statut;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image1;

    /**
     * @Vich\UploadableField(mapping="anime_article_image1", fileNameProperty="image1")
     *
     * @var File
     */
    private $image1File;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnime(): ?Anime
    {
        return $this->anime;
    }

    public function setAnime(Anime $anime): self
    {
        $this->anime = $anime;

        return $this;
    }

    public function getPlaylist(): ?string
    {
        return $this->playlist;
    }

    public function setPlaylist(?string $playlist): self
    {
        $this->playlist = $playlist;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        $this->updatedAt = new \DateTime('now');

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getImage1(): ?string
    {
        return $this->image1;
    }

    public function setImage1(?string $image1): self
    {
        $this->image1 = $image1;

        return $this;
    }

    public function setImage1File(File $image1File = null)
    {
        $this->image1File = $image1File;

        if ($image1File) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImage1File()
    {
        return $this->image1File;
    }
}
