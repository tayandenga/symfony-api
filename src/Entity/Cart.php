<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity, ORM\Table(name: 'carts')]
class Cart
{
    #[ORM\Id, ORM\Column(type: 'integer'), ORM\GeneratedValue(strategy: 'AUTO')]
    private ?int $id;

    #[ORM\OneToMany(targetEntity: CartMember::class, mappedBy: 'cart', cascade: [
        'persist',
        'remove'
    ], orphanRemoval: true)]
    private PersistentCollection $members;

    public function __constructor()
    {
        $this->members = new PersistentCollection;
    }

    public function members(): PersistentCollection
    {
        return $this->members;
    }

    public function assignMember(CartMember $data): self
    {
        foreach($this->members as $member) {
            if ($member->getProduct()->getId() == $data->getProduct()->getId()) {
                $member->setQuantity($data->getQuantity() + $member->getQuantity());
                return $this;
            }
        }
        $this->members[] = $data->setCart($this);
        return $this;
    }

    public function unassignMember(CartMember $data): self
    {
        if($this->members->removeElement($data) && $data->getCart()->getId() === $this->getId()) $data->setCart(null);
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getProducts(): array
    {
        $products = [];
        foreach($this->members as $member) $products[] = [
            'product' => $member->getProduct(),
            'quantity' => $member->getQuantity()
        ];
        return $products;
    }

    public function getTotal(): float
    {
        $total = 0.;
        foreach($this->members as $member) $total += $member->getTotal();
        return $total;
    }
}