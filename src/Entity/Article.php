<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 * @Vich\Uploadable
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=400, nullable=true)
     */
    private $banner_playlist;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $description;

    /**
     * @var \DateTime $dateDerniereModification
     *
     * @ORM\Column(name="date_derniere_modification", type="datetime", nullable=true)
     * @Gedmo\Mapping\Annotation\Timestampable(on="update", field={"description"})
     */
    private $dateDerniereModification;

    /**
     * @ORM\Column(type="string", length=20, nullable=false)
     */
    private $statut;

    /**
     * @ORM\OneToOne(targetEntity=Artiste::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $artiste;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $card;

    /**
     * @Vich\UploadableField(mapping="article_card", fileNameProperty="card")
     *
     * @var File
     */
    private $cardFile;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="article_image", fileNameProperty="image")
     *
     * @var File
     */
    private $imageFile;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBannerPlaylist(): ?string
    {
        return $this->banner_playlist;
    }

    public function setBannerPlaylist(?string $banner_playlist): self
    {
        $this->banner_playlist = $banner_playlist;

        $this->dateDerniereModification = new \DateTime('now');

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        $this->dateDerniereModification = new \DateTime('now');

        return $this;
    }

    public function getDateDerniereModification()
    {
        return $this->dateDerniereModification;
    }

    public function setDateDerniereModification(?\DateTimeInterface $updatedAt): self
    {
        $this->dateDerniereModification = $updatedAt;
        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getArtiste(): ?Artiste
    {
        return $this->artiste;
    }

    public function setArtiste(Artiste $artiste): self
    {
        $this->artiste = $artiste;

        return $this;
    }

    public function setCardFile(File $cardFile = null)
    {
        $this->cardFile = $cardFile;

        if ($cardFile) {
            $this->dateDerniereModification = new \DateTime('now');
        }
    }

    public function getCardFile()
    {
        return $this->cardFile;
    }

    public function setCard(?string $card): self
    {
        $this->card = $card;

        return $this;
    }

    public function getCard()
    {
        return $this->card;
    }

    public function setImageFile(File $imageFile = null)
    {
        $this->imageFile = $imageFile;

        if ($imageFile) {
            $this->dateDerniereModification = new \DateTime('now');
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
}
