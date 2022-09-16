<?php
namespace App\DataTransformer;

use App\Entity\Cart;
use App\Entity\CartMember as RealCartMember;
use App\Entity\Product;

class CartMember
{
    private Cart $cart;

    public ?Product $product = null;

    public int $quantity = 0;

    public function parent(): ?Cart {
        return $this->cart;
    }

    public function transport(Cart $cart): self {
        $this->cart = $cart;
        return $this;
    }

    public function transform(): RealCartMember {
        $member = new RealCartMember;
        return $member->setCart($this->cart)->setProduct($this->product)->setQuantity($this->quantity);
    }
}