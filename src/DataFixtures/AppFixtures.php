<?php
namespace App\DataFixtures;

use App\Entity\Product;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach([
            "Fallout" => 1.99,
            "Don’t Starve" => 2.99,
            "Baldur's Gate" => 3.99,
            "Icewind Dale" => 4.99,
            "Bloodborne" => 5.99
        ] as $key => $value) {
            $product = new Product;
            $product->title = $key;
            $product->price = $value;
            $manager->persist($product);
        }
        $manager->flush();
    }
}
