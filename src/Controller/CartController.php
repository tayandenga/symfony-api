<?php
namespace App\Controller;

use App\DataTransformer\CartMember;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class CartController extends AbstractController
{
    public function __invoke(ManagerRegistry $doctrine, Request $request, CartMember $data)
    {
        $member = null;
        foreach($data->parent()->members() as $m) {
            if($m->getProduct()->getId() == $data->product->getId()) {
                $member = $m;
                break;
            }
        }
        switch($request->getMethod()) {
            case 'POST':
                if($member === null && $data->parent()->members()->count() >= 3) return $this->json([], 417);
                $data->parent()->assignMember($data->transform());
                $doctrine->getManager()->flush();
            return $this->json($data->parent(), 201);
            case 'PUT':
                if($member === null) return $this->json([], 404);
                $member->setQuantity($data->quantity);
                $doctrine->getManager()->flush();
            return $this->json($data->parent(), 200);
            case 'PATCH':
                if($member === null) return $this->json([], 404);
                $data->parent()->unassignMember($member);
                $doctrine->getManager()->flush();
            return $this->json($data->parent(), 200);
            default: break;
        }
        return $this->json([], 405);
    }
}