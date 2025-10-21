<?php

namespace App\Entity\EntityIdFraCon;

use App\Repository\RepositoryIdFraCon\ClausesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClausesRepository::class)]
class Clauses
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ORM\Column(length: 255)]
  private ?string $name = null;

  #[ORM\Column(type: Types::TEXT)]
  private ?string $description = null;

  #[ORM\Column(length: 255, nullable: true)]
  private ?string $modal = null;

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getName(): ?string
  {
    return $this->name;
  }

  public function setName(string $name): static
  {
    $this->name = $name;

    return $this;
  }

  public function getDescription(): ?string
  {
    return $this->description;
  }

  public function setDescription(string $description): static
  {
    $this->description = $description;

    return $this;
  }

  public function getModal(): ?string
  {
    return $this->modal;
  }

  public function setModal(?string $modal): static
  {
    $this->modal = $modal;

    return $this;
  }
}
