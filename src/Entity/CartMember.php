<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity, ORM\Table(name: 'cart_members'), ApiResource(itemOperations: [], collectionOperations: [])]
class CartMember
{
    #[ORM\Id, ORM\Column(type: 'integer'), ORM\GeneratedValue(strategy: 'AUTO')]
    private ?int $id;

    #[ORM\ManyToOne(targetEntity: Cart::class, inversedBy: 'members')]
    private ?Cart $cart;

    #[ORM\ManyToOne(targetEntity: Product::class, cascade: [
        'persist',
        'detach'
    ]), ORM\JoinColumn(name: 'product_id', referencedColumnName: 'id')]
    private Product $product;

    #[ORM\Column(type: 'integer', options: [
        'default' => 0
    ]), Assert\NotBlank]
    private int $quantity;

    public function getId(): int
    {
        return $this->id;
    }

    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    public function setCart(?Cart $cart): self
    {
        $this->cart = $cart;
        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;
        return $this;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getTotal(): float
    {
        return $this->product->getPrice() * $this->quantity;
    }
}