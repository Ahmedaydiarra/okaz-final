<?php

namespace App\Controller;

use App\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DetailController extends AbstractController
{
    /**
     * @Route("/detail/{id}", name="app_detail")
     */
    public function index(Produit $produit): Response
    {
        return $this->render('detail/index.html.twig', [
            'produit' => $produit,
        ]);
    }
}
