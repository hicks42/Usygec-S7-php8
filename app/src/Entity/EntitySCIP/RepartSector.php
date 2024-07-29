<?php

namespace App\Entity\EntitySCIP;

use App\Entity\EntitySCIP\Produit;
use App\Repository\RepositorySCIP\RepartSectorRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 */
#[ORM\Entity(repositoryClass:RepartSectorRepository::class)]
#[ORM\Table(name:"`mc_repart_sector`")]
class RepartSector
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:"integer")]
    private $id;

    #[ORM\Column(type:"string", length:185)]
    private $sectorName;

    #[ORM\Column(type:"float")]
    private $sectorValue;

    #[ORM\ManyToOne(targetEntity:Produit::class, inversedBy:"repartSectors")]
    #[ORM\JoinColumn(nullable:false)]
    private $produit;

    public function __toString()
    {
        return $this->getSectorName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSectorName(): ?string
    {
        return $this->sectorName;
    }

    public function setSectorName(string $sectorName): self
    {
        $this->sectorName = $sectorName;

        return $this;
    }

    public function getSectorValue(): ?float
    {
        return $this->sectorValue;
    }

    public function setSectorValue(float $sectorValue): self
    {
        $this->sectorValue = $sectorValue;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }
}
