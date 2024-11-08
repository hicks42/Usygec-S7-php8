<?php

namespace App\Entity\EntitySD;

use App\Repository\RepositorySD\RepositorySD\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass:OrderRepository::class)]
#[ORM\Table(name:"`sd_order`")]
class Order
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column(type:"integer")]
  private $id;

  #[ORM\ManyToOne(targetEntity:User::class, inversedBy:"orders")]
  #[ORM\JoinColumn(nullable:false)]
  private $user;

  #[ORM\Column(type:"datetime_immutable")]
  private $createdAt;

  #[ORM\Column(type:"string", length:255)]
  private $carrierName;

  #[ORM\Column(type:"float")]
  private $carrierPrice;

  #[ORM\Column(type:"text")]
  private $delivery;

  #[ORM\OneToMany(targetEntity:OrderDetails::class, mappedBy:"theOrder")]
  private $orderDetails;

  #[ORM\Column(type:"string", length:255)]
  private $reference;

  #[ORM\Column(type:"string", length:255, nullable:true)]
  private $stripeSessionId;

  #[ORM\Column(type:"integer")]
  private $status;

  public function __construct()
  {
    $this->orderDetails = new ArrayCollection();
  }

  public function getTotal()
  {
    // dd($this->getOrderDetails()->getValues());
    $total = null;
    foreach ($this->getOrderDetails()->getValues() as $produit) {
      $total = $total + ($produit->getPrice() * $produit->getQuantity());
      // dd($produit);
    }
    return $total;
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getUser(): ?User
  {
    return $this->user;
  }

  public function setUser(?User $user): self
  {
    $this->user = $user;

    return $this;
  }

  public function getCreatedAt(): ?\DateTimeImmutable
  {
    return $this->createdAt;
  }

  public function setCreatedAt(\DateTimeImmutable $createdAt): self
  {
    $this->createdAt = $createdAt;

    return $this;
  }

  public function getCarrierName(): ?string
  {
    return $this->carrierName;
  }

  public function setCarrierName(string $carrierName): self
  {
    $this->carrierName = $carrierName;

    return $this;
  }

  public function getCarrierPrice(): ?float
  {
    return $this->carrierPrice;
  }

  public function setCarrierPrice(float $carrierPrice): self
  {
    $this->carrierPrice = $carrierPrice;

    return $this;
  }

  public function getDelivery(): ?string
  {
    return $this->delivery;
  }

  public function setDelivery(string $delivery): self
  {
    $this->delivery = $delivery;

    return $this;
  }

  /**
   * @return Collection|OrderDetails[]
   */
  public function getOrderDetails(): Collection
  {
    return $this->orderDetails;
  }

  public function addOrderDetail(OrderDetails $orderDetail): self
  {
    if (!$this->orderDetails->contains($orderDetail)) {
      $this->orderDetails[] = $orderDetail;
      $orderDetail->setTheOrder($this);
    }

    return $this;
  }

  public function removeOrderDetail(OrderDetails $orderDetail): self
  {
    if ($this->orderDetails->removeElement($orderDetail)) {
      // set the owning side to null (unless already changed)
      if ($orderDetail->getTheOrder() === $this) {
        $orderDetail->setTheOrder(null);
      }
    }

    return $this;
  }

  public function getReference(): ?string
  {
    return $this->reference;
  }

  public function setReference(string $reference): self
  {
    $this->reference = $reference;

    return $this;
  }

  public function getStripeSessionId(): ?string
  {
    return $this->stripeSessionId;
  }

  public function setStripeSessionId(?string $stripeSessionId): self
  {
    $this->stripeSessionId = $stripeSessionId;

    return $this;
  }

  public function getStatus(): ?int
  {
    return $this->status;
  }

  public function setStatus(int $status): self
  {
    $this->status = $status;

    return $this;
  }
}
