<?php

namespace App\Entity\EntitySCIP;

use App\Entity\EntitySCIP\Produit;
use App\Repository\RepositorySCIP\RepartGeoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 */
#[ORM\Entity(repositoryClass:RepartGeoRepository::class)]
#[ORM\Table(name:"`mc_repart_geo`")]
class RepartGeo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:"integer")]
    private $id;

    #[ORM\Column(type:"string", length:185)]
    private $geoName;

    #[ORM\Column(type:"float")]
    private $geoValue;

    #[ORM\ManyToOne(targetEntity:Produit::class, inversedBy:"repartGeos")]
    #[ORM\JoinColumn(nullable:false)]
    private $produit;

    public function __toString()
    {
        return $this->getGeoName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGeoName(): ?string
    {
        return $this->geoName;
    }

    public function setGeoName(string $geoName): self
    {
        $this->geoName = $geoName;

        return $this;
    }

    public function getGeoValue(): ?float
    {
        return $this->geoValue;
    }

    public function setGeoValue(float $geoValue): self
    {
        $this->geoValue = $geoValue;

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
