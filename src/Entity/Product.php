<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity, ORM\Table(name: 'products')]
#[ApiResource(itemOperations: [
    'get',
    'delete',
    'put' => [
        'method' => 'put',
        'openapi_context' => [
            'summary' => 'Updates the Product resource.',
            'description' => 'Updates the Product resource.'
        ]
    ]
], attributes: ['pagination_items_per_page' => 3])]
class Product
{
    #[ORM\Id, ORM\Column(type: 'integer'), ORM\GeneratedValue(strategy: 'AUTO')]
    private ?int $id;

    #[ORM\Column(length: 255, unique: true), Assert\NotBlank]
    public string $title;

    #[ORM\Column(type: 'float', options: [
        'default' => 0
    ]), Assert\NotBlank]
    public float $price;

    public function __toString(): string
    {
        return $this->title;
    }

    public function getId(): int
    {
        return $this->id;
    }
}