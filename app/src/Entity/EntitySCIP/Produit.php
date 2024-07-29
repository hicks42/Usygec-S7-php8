<?php

namespace App\Entity\EntitySCIP;

use App\Entity\EntitySCIP\Categorie;
use App\Entity\EntitySCIP\Performance;
use App\Entity\EntitySCIP\RepartSector;
use App\Entity\EntitySCIP\RepartGeo;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Timestampable;
use App\Repository\RepositorySCIP\ProduitRepository;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass:ProduitRepository::class)]
#[ORM\Table(name:"`mc_produit`")]
#[ORM\HasLifecycleCallbacks]
#[Vich\Uploadable]
class Produit
{
  use Timestampable;

  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column(type:"integer")]
  private $id;

  #[ORM\Column(type:"string", length:255)]
  private $name;

  #[ORM\Column(type:"string", length:255)]
  private $soc_gest;

  #[ORM\Column(type:"string", length:255)]
  private $capital;

  #[ORM\Column(type:"string", length:255)]
  private $thematique;

  #[ORM\Column(type:"float", length:255)]
  private $capitalisation;

  #[ORM\Column(type:"integer")]
  private $nb_assoc;

  /**
   * NOTE: This is not a mapped field of entity metadata, just a simple property.
   *
   * @Vich\UploadableField(mapping="image_produit", fileNameProperty="imageName")
   * @var File|null
   */
  #[Vich\UploadableField(mapping:"image_produit", fileNameProperty:"imageName")]
  #[Assert\Image(maxSize:"8M", maxSizeMessage:"Le fichier est trop gros")]
  private $imageFile;

  #[ORM\Column(type:"string", length:255, nullable:true)]
  private $imageName;

  #[ORM\Column(type:"string", length:255, nullable:true)]
  private $slug;

  #[ORM\ManyToOne(targetEntity:Categorie::class, inversedBy:"produits")]
  #[ORM\JoinColumn(nullable:true)]
  private $categorie;

  /**
   * @var Collection
   */
  #[ORM\OneToMany(targetEntity:Performance::class, mappedBy:"product", orphanRemoval:true, cascade:["persist"])]
  private $performances;

  /**
   * @var Collection
   */
  #[ORM\OneToMany(targetEntity:RepartSector::class, mappedBy:"produit", orphanRemoval:true, cascade:["persist"])]
  private $repartSectors;

  /**
   * @var Collection
   */
  #[ORM\OneToMany(targetEntity:RepartGeo::class, mappedBy:"produit", orphanRemoval:true, cascade:["persist"])]
  private $repartGeos;

  #[ORM\Column(type:"boolean", nullable:true)]
  private $isPromo = false;

  #[ORM\Column(type:"float")]
  private $sharePrice;

  #[ORM\Column(type:"integer")]
  private $shareNbr;

  #[ORM\Column(type:"integer")]
  private $shareSubMin;

  #[ORM\Column(type:"string", length:255)]
  private $fruitionDelay;

  #[ORM\Column(type:"float")]
  private $withdrawalValue;

  #[ORM\Column(type:"integer")]
  private $immvableNbr;

  #[ORM\Column(type:"integer")]
  private $surface;

  #[ORM\Column(type:"integer")]
  private $tenantNbr;

  #[ORM\Column(type:"integer")]
  private $top;

  #[ORM\Column(type:"integer")]
  private $tof;

  #[ORM\Column(type:"boolean")]
  private $lifeInsuranceAvaible;

  #[ORM\Column(type:"string", length:255)]
  private $reserveRan;

  #[ORM\Column(type:"integer")]
  private $worksAdvance;

  #[ORM\Column(type:"text")]
  private $investStrat;

  #[ORM\Column(type:"text")]
  private $infoTrim;

  #[ORM\Column(type:"text")]
  private $lifeAssetTrim;

  #[ORM\Column(type:"text")]
  private $subscriptionCom;

  #[ORM\Column(type:"text")]
  private $ManageCom;

  #[ORM\Column(type:"text")]
  private $arbMovCom;

  #[ORM\Column(type:"text")]
  private $pilotWorksCom;

  #[ORM\Column(type:"text")]
  private $witCessionCom;

  #[ORM\Column(type:"text")]
  private $shareMutaCom;

  public function __toString()
  {
    return $this->getName();
  }

  public function __construct()
  {
    $this->performances = new ArrayCollection();
    $this->repartSectors = new ArrayCollection();
    $this->repartGeos = new ArrayCollection();
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

  public function getSocGest(): ?string
  {
    return $this->soc_gest;
  }

  public function setSocGest(string $soc_gest): self
  {
    $this->soc_gest = $soc_gest;

    return $this;
  }

  public function getCapital(): ?string
  {
    return $this->capital;
  }

  public function setCapital(string $capital): self
  {
    $this->capital = $capital;

    return $this;
  }

  public function getThematique(): ?string
  {
    return $this->thematique;
  }

  public function setThematique(string $thematique): self
  {
    $this->thematique = $thematique;

    return $this;
  }

  public function getCapitalisation(): ?float
  {
    return $this->capitalisation;
  }

  public function setCapitalisation(float $capitalisation): self
  {
    $this->capitalisation = $capitalisation;

    return $this;
  }

  public function getNbAssoc(): ?int
  {
    return $this->nb_assoc;
  }

  public function setNbAssoc(int $nb_assoc): self
  {
    $this->nb_assoc = $nb_assoc;

    return $this;
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

  public function setImageFile(?File $imageFile = null): void
  {
    $this->imageFile = $imageFile;

    if (null !== $imageFile) {
      $this->setUpdatedAt(new \DateTimeImmutable);
    }
  }

  public function getImageFile(): ?File
  {
    return $this->imageFile;
  }

  public function getSlug(): ?string
  {
    return $this->slug;
  }

  public function setSlug(?string $slug): self
  {
    $this->slug = $slug;

    return $this;
  }

  public function getCategorie(): ?Categorie
  {
    return $this->categorie;
  }

  public function setCategorie(?Categorie $categorie): self
  {
    $this->categorie = $categorie;

    return $this;
  }

  public function getIsPromo(): ?bool
  {
    return $this->isPromo;
  }

  public function setIsPromo(?bool $isPromo): self
  {
    $this->isPromo = $isPromo;

    return $this;
  }

  /**
   * @return Collection|Performance[]
   */
  public function getPerformances(): Collection
  {
    return $this->performances;
  }

  public function addPerformance(Performance $performance): self
  {
    if (!$this->performances->contains($performance)) {
      $this->performances[] = $performance;
      $performance->setProduct($this);
    }

    return $this;
  }

  public function removePerformance(Performance $performance): self
  {
    if ($this->performances->removeElement($performance)) {
      // set the owning side to null (unless already changed)
      if ($performance->getProduct() === $this) {
        $performance->setProduct(null);
      }
    }

    return $this;
  }

  public function getSharePrice(): ?float
  {
    return $this->sharePrice;
  }

  public function setSharePrice(float $sharePrice): self
  {
    $this->sharePrice = $sharePrice;

    return $this;
  }

  public function getShareNbr(): ?int
  {
    return $this->shareNbr;
  }

  public function setShareNbr(int $shareNbr): self
  {
    $this->shareNbr = $shareNbr;

    return $this;
  }

  public function getShareSubMin(): ?int
  {
    return $this->shareSubMin;
  }

  public function setShareSubMin(int $shareSubMin): self
  {
    $this->shareSubMin = $shareSubMin;

    return $this;
  }

  public function getFruitionDelay(): ?string
  {
    return $this->fruitionDelay;
  }

  public function setFruitionDelay(string $fruitionDelay): self
  {
    $this->fruitionDelay = $fruitionDelay;

    return $this;
  }

  public function getWithdrawalValue(): ?float
  {
    return $this->withdrawalValue;
  }

  public function setWithdrawalValue(float $withdrawalValue): self
  {
    $this->withdrawalValue = $withdrawalValue;

    return $this;
  }

  public function getImmvableNbr(): ?int
  {
    return $this->immvableNbr;
  }

  public function setImmvableNbr(int $immvableNbr): self
  {
    $this->immvableNbr = $immvableNbr;

    return $this;
  }

  public function getSurface(): ?int
  {
    return $this->surface;
  }

  public function setSurface(int $surface): self
  {
    $this->surface = $surface;

    return $this;
  }

  public function getTenantNbr(): ?int
  {
    return $this->tenantNbr;
  }

  public function setTenantNbr(int $tenantNbr): self
  {
    $this->tenantNbr = $tenantNbr;

    return $this;
  }

  public function getTop(): ?int
  {
    return $this->top;
  }

  public function setTop(int $top): self
  {
    $this->top = $top;

    return $this;
  }

  public function getTof(): ?int
  {
    return $this->tof;
  }

  public function setTof(int $tof): self
  {
    $this->tof = $tof;

    return $this;
  }

  public function getLifeInsuranceAvaible(): ?bool
  {
    return $this->lifeInsuranceAvaible;
  }

  public function setLifeInsuranceAvaible(bool $lifeInsuranceAvaible): self
  {
    $this->lifeInsuranceAvaible = $lifeInsuranceAvaible;

    return $this;
  }

  public function getReserveRan(): ?string
  {
    return $this->reserveRan;
  }

  public function setReserveRan(string $reserveRan): self
  {
    $this->reserveRan = $reserveRan;

    return $this;
  }

  public function getWorksAdvance(): ?int
  {
    return $this->worksAdvance;
  }

  public function setWorksAdvance(int $worksAdvance): self
  {
    $this->worksAdvance = $worksAdvance;

    return $this;
  }

  public function getInvestStrat(): ?string
  {
    return $this->investStrat;
  }

  public function setInvestStrat(string $investStrat): self
  {
    $this->investStrat = $investStrat;

    return $this;
  }

  public function getInfoTrim(): ?string
  {
    return $this->infoTrim;
  }

  public function setInfoTrim(string $infoTrim): self
  {
    $this->infoTrim = $infoTrim;

    return $this;
  }

  public function getLifeAssetTrim(): ?string
  {
    return $this->lifeAssetTrim;
  }

  public function setLifeAssetTrim(string $lifeAssetTrim): self
  {
    $this->lifeAssetTrim = $lifeAssetTrim;

    return $this;
  }

  public function getSubscriptionCom(): ?string
  {
    return $this->subscriptionCom;
  }

  public function setSubscriptionCom(string $subscriptionCom): self
  {
    $this->subscriptionCom = $subscriptionCom;

    return $this;
  }

  public function getManageCom(): ?string
  {
    return $this->ManageCom;
  }

  public function setManageCom(string $ManageCom): self
  {
    $this->ManageCom = $ManageCom;

    return $this;
  }

  public function getArbMovCom(): ?string
  {
    return $this->arbMovCom;
  }

  public function setArbMovCom(string $arbMovCom): self
  {
    $this->arbMovCom = $arbMovCom;

    return $this;
  }

  public function getPilotWorksCom(): ?string
  {
    return $this->pilotWorksCom;
  }

  public function setPilotWorksCom(string $pilotWorksCom): self
  {
    $this->pilotWorksCom = $pilotWorksCom;

    return $this;
  }

  public function getWitCessionCom(): ?string
  {
    return $this->witCessionCom;
  }

  public function setWitCessionCom(string $witCessionCom): self
  {
    $this->witCessionCom = $witCessionCom;

    return $this;
  }

  public function getShareMutaCom(): ?string
  {
    return $this->shareMutaCom;
  }

  public function setShareMutaCom(string $shareMutaCom): self
  {
    $this->shareMutaCom = $shareMutaCom;

    return $this;
  }

  /**
   * @return Collection|RepartSector[]
   */
  public function getRepartSectors(): Collection
  {
    return $this->repartSectors;
  }

  public function addRepartSector(RepartSector $repartSector): self
  {
    if (!$this->repartSectors->contains($repartSector)) {
      $this->repartSectors[] = $repartSector;
      $repartSector->setProduit($this);
    }

    return $this;
  }

  public function removeRepartSector(RepartSector $repartSector): self
  {
    if ($this->repartSectors->removeElement($repartSector)) {
      // set the owning side to null (unless already changed)
      if ($repartSector->getProduit() === $this) {
        $repartSector->setProduit(null);
      }
    }

    return $this;
  }

  /**
   * @return Collection|RepartGeo[]
   */
  public function getRepartGeos(): Collection
  {
    return $this->repartGeos;
  }

  public function addRepartGeo(RepartGeo $repartGeo): self
  {
    if (!$this->repartGeos->contains($repartGeo)) {
      $this->repartGeos[] = $repartGeo;
      $repartGeo->setProduit($this);
    }

    return $this;
  }

  public function removeRepartGeo(RepartGeo $repartGeo): self
  {
    if ($this->repartGeos->removeElement($repartGeo)) {
      // set the owning side to null (unless already changed)
      if ($repartGeo->getProduit() === $this) {
        $repartGeo->setProduit(null);
      }
    }

    return $this;
  }
}
