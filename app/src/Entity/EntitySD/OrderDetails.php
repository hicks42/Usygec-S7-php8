<?php

namespace App\Entity\EntitySD;

use App\Repository\RepositorySD\OrderDetailsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass:OrderDetailsRepository::class)]
#[ORM\Table(name:"sd_order_details")]
class OrderDetails
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:"integer")]
    private $id;

    #[ORM\ManyToOne(targetEntity:order::class, inversedBy:"orderDetails")]
    #[ORM\JoinColumn(nullable:false)]
    private $theOrder;

    #[ORM\Column(type:"string", length:255)]
    private $product;

    #[ORM\Column(type:"integer")]
    private $quantity;

    #[ORM\Column(type:"float")]
    private $price;

    #[ORM\Column(type:"float")]
    private $total;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTheOrder(): ?order
    {
        return $this->theOrder;
    }

    public function setTheOrder(?order $theOrder): self
    {
        $this->theOrder = $theOrder;

        return $this;
    }

    public function getProduct(): ?string
    {
        return $this->product;
    }

    public function setProduct(string $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function __toString()
    {
        return $this->getProduct() . ' x' . $this->getQuantity();
    }
}
