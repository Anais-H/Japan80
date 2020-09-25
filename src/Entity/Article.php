<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;



/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
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
     * @ORM\OneToOne(targetEntity="App\Entity\Artiste", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $artiste_id;

    /**
     * @var \DateTime $dateDerniereModification
     *
     * @ORM\Column(name="date_derniere_modification", type="datetime", nullable=true)
     * @Gedmo\Mapping\Annotation\Timestampable(on="update", field={"description"})
     */
    private $dateDerniereModification;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $statut;


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

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getArtisteId(): ?Artiste
    {
        return $this->artiste_id;
    }

    public function setArtisteId(Artiste $artiste_id): self
    {
        $this->artiste_id = $artiste_id;

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


}
