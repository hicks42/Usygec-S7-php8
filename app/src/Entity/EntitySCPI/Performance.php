<?php

namespace App\Entity\EntitySCPI;

use App\Repository\RepositorySCPI\PerformanceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass:PerformanceRepository::class)]
#[ORM\Table(name:"`mc_performance`")]
class Performance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:"integer")]
    private $id;

    #[ORM\Column(type:"integer")]
    private $year;

    #[ORM\Column(type:"float")]
    private $rate;

    #[ORM\ManyToOne(targetEntity:produit::class, inversedBy:"performances")]
    #[ORM\JoinColumn(nullable:false)]
    private $product;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getRate(): ?float
    {
        return $this->rate;
    }

    public function setRate(float $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getProduct(): ?produit
    {
        return $this->product;
    }

    public function setProduct(?produit $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function __toString(): string
    {
        return ''; // Retourne une chaîne vide pour éviter le titre auto-généré
    }
}
