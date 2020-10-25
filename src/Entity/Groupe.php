<?php

namespace App\Entity;

use App\Repository\GroupesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GroupesRepository::class)
 */
class Groupes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
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
     * @ORM\ManyToMany(targetEntity=Artiste::class, inversedBy="groupes")
     */
    private $artistes;

    public function __construct()
    {
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
}
