<?php

namespace App\Entity\EntityBam;

use App\Entity\User;
use App\Repository\RepositoryBam\CompanyRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass:CompanyRepository::class)]
#[ORM\Table(name:"companies")]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:"integer")]
    private $id;

    #[ORM\Column(type:"string", length:255)]
    private $name;

    #[ORM\Column(type:"string", length:255, nullable:true)]
    private $address1;

    #[ORM\Column(type:"string", length:255, nullable:true)]
    private $address2;

    #[ORM\Column(type:"integer", nullable:true)]
    private $cp;

    #[ORM\Column(type:"string", length:255, nullable:true)]
    private $city;

    #[ORM\Column(type:"string", length:255, nullable:true)]
    private $phone;

    #[ORM\Column(type:"string", length:255, nullable:true)]
    private $email;

    #[ORM\OneToMany(targetEntity:Activity::class, mappedBy:"company", orphanRemoval:true, cascade:["persist"])]
    /** @var Collection|Activity[] */
    private $activities;

    #[ORM\ManyToOne(targetEntity:User::class, inversedBy:"companies")]
    #[ORM\JoinColumn(nullable:false)]
    private $handler;

    #[ORM\ManyToOne(targetEntity:Category::class, inversedBy:"comapnies")]
    #[ORM\JoinColumn(nullable:false)]
    private $category;

    #[ORM\Column(type:"string", length:255, nullable:true)]
    private $ContactFirstName;

    #[ORM\Column(type:"string", length:255, nullable:true)]
    private $contactLastName;

    #[ORM\Column(type:"string", length:255, nullable:true)]
    private $civ;

    #[ORM\Column(type:"string", length:255, nullable:true)]
    private $mobile;

    public function __construct()
    {
        $this->activities = new ArrayCollection();
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

    public function getAddress1(): ?string
    {
        return $this->address1;
    }

    public function setAddress1(?string $address1): self
    {
        $this->address1 = $address1;

        return $this;
    }

    public function getAddress2(): ?string
    {
        return $this->address2;
    }

    public function setAddress2(?string $address2): self
    {
        $this->address2 = $address2;

        return $this;
    }

    public function getCp(): ?int
    {
        return $this->cp;
    }

    public function setCp(?int $cp): self
    {
        $this->cp = $cp;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection|Activity[]
     */
    public function getActivities(): Collection
    {
        return $this->activities;
    }

    public function addActivity(Activity $activity): self
    {
        if (!$this->activities->contains($activity)) {
            $this->activities[] = $activity;
            $activity->setCompany($this);
        }

        return $this;
    }

    public function removeActivity(Activity $activity): self
    {
        if ($this->activities->removeElement($activity)) {
            if ($activity->getCompany() === $this) {
                $activity->setCompany(null);
            }
        }

        return $this;
    }

    public function resetActivities(): self
    {
        foreach ($this->activities as $activity) {
            $this->removeActivity($activity);
        }

        return $this;
    }

    public function getHandler(): ?user
    {
        return $this->handler;
    }

    public function setHandler(?user $handler): self
    {
        $this->handler = $handler;

        return $this;
    }

    /**
     * Get the string representation of the Category object.
     *
     * @return string
     */
    public function getCategoryAsString(): string
    {
        if ($this->category) {
            return $this->category->getName();
        }

        return '';
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getContactFirstName(): ?string
    {
        return $this->ContactFirstName;
    }

    public function setContactFirstName(?string $ContactFirstName): self
    {
        $this->ContactFirstName = $ContactFirstName;

        return $this;
    }

    public function getContactLastName(): ?string
    {
        return $this->contactLastName;
    }

    public function setContactLastName(?string $contactLastName): self
    {
        $this->contactLastName = $contactLastName;

        return $this;
    }

    public function getCiv(): ?string
    {
        return $this->civ;
    }

    public function setCiv(?string $civ): self
    {
        $this->civ = $civ;

        return $this;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(?string $mobile): self
    {
        $this->mobile = $mobile;

        return $this;
    }
}
