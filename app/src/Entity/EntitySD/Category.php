<?php

namespace App\Entity\EntitySD;

use App\Entity\Traits\Timestampable;
use App\Repository\RepositorySD\CategoryRepository;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass:CategoryRepository::class)]
#[ORM\Table(name:"sd_category")]
#[ORM\HasLifecycleCallbacks]
#[Vich\Uploadable]
class Category
{
    use Timestampable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:"integer")]
    private $id;

    #[ORM\Column(type:"string", length:255)]
    private $name;

    #[ORM\OneToMany(targetEntity:Produit::class, mappedBy:"category")]
    private $produit_id;

    #[ORM\Column(type:"string", length:255, nullable:true)]
    private $imageName;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="product_image", fileNameProperty="imageName")
     * @var File|null
     */
    #[Vich\UploadableField(mapping:"product_image", fileNameProperty:"imageName")]
    #[Assert\Image(maxSize:"8M", maxSizeMessage:"Le fichier est trop gros")]
    private $imageFile;

    #[ORM\Column(type:"string", length:255)]
    private $slug;

    #[ORM\Column(type:"integer")]
    private $display;

    public function __construct()
    {
        $this->produit_id = new ArrayCollection();
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
     * @return Collection|Produit[]
     */
    public function getProduitId(): Collection
    {
        return $this->produit_id;
    }

    public function addProduitId(Produit $produitId): self
    {
        if (!$this->produit_id->contains($produitId)) {
            $this->produit_id[] = $produitId;
            $produitId->setCategory($this);
        }

        return $this;
    }

    public function removeProduitId(Produit $produitId): self
    {
        if ($this->produit_id->removeElement($produitId)) {
            // set the owning side to null (unless already changed)
            if ($produitId->getCategory() === $this) {
                $produitId->setCategory(null);
            }
        }

        return $this;
    }


    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;

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

    public function getDisplay(): ?int
    {
        return $this->display;
    }

    public function setDisplay(int $display): self
    {
        $this->display = $display;

        return $this;
    }
}
