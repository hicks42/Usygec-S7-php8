<?php

namespace App\Entity\EntityBam;

use App\Entity\Traits\Timestampable;
use App\Repository\RepositoryBam\ActivityRepository;
use Assert\DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ActivityRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: "activities")]

class Activity
{
  use Timestampable;

  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column(type: "integer")]
  private $id;


  #[ORM\Column(type: "string", length: 255, nullable: true)]
  #[Assert\NotBlank(message: "Le nom doit être renseigné.")]
  private $name;

  #[ORM\Column(type: "text", nullable: true)]
  #[Assert\NotBlank(message: "La descritpion doit être renseignée.")]
  private $description;

  #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: "activities")]
  #[ORM\JoinColumn(nullable: false)]
  private $company;

  #[ORM\Column(type: "datetime", nullable: true)]
  #[Assert\Type("\DateTimeInterface")]
  private $dueDate;

  #[ORM\Column(type: "datetime", nullable: true)]
  #[Assert\Type("\DateTimeInterface")]
  private $reminder;

  #[ORM\Column(type: "boolean", options: ["default" => 0])]
  private $isActive;

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getName(): ?string
  {
    return $this->name;
  }

  public function setName(?string $name): self
  {
    $this->name = $name;

    return $this;
  }

  public function getDescription(): ?string
  {
    return $this->description;
  }

  public function setDescription(?string $description): self
  {
    $this->description = $description;

    return $this;
  }

  public function isActive(): bool
  {
    return $this->isActive;
  }

  public function setIsActive(bool $isActive): self
  {
    $this->isActive = $isActive;

    return $this;
  }

  public function getCompany(): ?Company
  {
    return $this->company;
  }

  public function setCompany(?Company $company): self
  {
    $this->company = $company;

    return $this;
  }

  public function getDueDate(): ?DateTimeInterface
  {
    return $this->dueDate;
  }

  public function setDueDate(?\DateTimeInterface $dueDate): self
  {
    $this->dueDate = $dueDate;

    return $this;
  }

  public function getReminder(): ?\DateTimeInterface
  {
    return $this->reminder;
  }

  public function setReminder(?\DateTimeInterface $reminder): self
  {
    $this->reminder = $reminder;

    return $this;
  }
}
