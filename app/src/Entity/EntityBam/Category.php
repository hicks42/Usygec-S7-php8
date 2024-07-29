<?php

namespace App\Entity\EntityBam;

use App\Repository\RepositoryBam\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass:CategoryRepository::class)]
#[ORM\Table(name:"categories")]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:"integer")]
    private $id;

    #[ORM\Column(type:"string", length:255)]
    private $name;

    #[ORM\OneToMany(targetEntity:Company::class, mappedBy:"category")]
    private $comapnies;

    public function __construct()
    {
        $this->comapnies = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Company>
     */
    public function getComapnies(): Collection
    {
        return $this->comapnies;
    }

    public function addComapny(Company $comapny): self
    {
        if (!$this->comapnies->contains($comapny)) {
            $this->comapnies[] = $comapny;
            $comapny->setCategory($this);
        }

        return $this;
    }

    public function removeComapny(Company $comapny): self
    {
        if ($this->comapnies->removeElement($comapny)) {
            // set the owning side to null (unless already changed)
            if ($comapny->getCategory() === $this) {
                $comapny->setCategory(null);
            }
        }

        return $this;
    }
}
