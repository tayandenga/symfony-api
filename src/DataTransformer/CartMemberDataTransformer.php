<?php
namespace App\DataTransformer;

use App\Entity\Cart;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Serializer\AbstractItemNormalizer;

class CartMemberDataTransformer implements DataTransformerInterface
{
    public function transform($data, string $to, array $context = []): CartMember
    {
        return $data->transport($context[AbstractItemNormalizer::OBJECT_TO_POPULATE]);
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if($data instanceof Cart) return false;
        return Cart::class === $to && ($context['input']['class'] ?? null) !== null;
    }
}