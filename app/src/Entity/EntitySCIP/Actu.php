<?php

namespace App\Entity\EntitySCIP;

use App\Repository\RepositorySCIP\ActuRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass:ActuRepository::class)]
#[ORM\Table(name:"`mc_actu`")]
class Actu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:"integer")]
    private $id;

    #[ORM\Column(type:"string", length:255)]
    private $title;

    #[ORM\Column(type:"text", nullable:true)]
    private $content;

    #[ORM\Column(type:"boolean")]
    private $isOnline;

    #[ORM\Column(type:"string", length:185)]
    private $slug;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getIsOnline(): ?bool
    {
        return $this->isOnline;
    }

    public function setIsOnline(bool $isOnline): self
    {
        $this->isOnline = $isOnline;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
