<?php

namespace App\Controller;

use App\Entity\Categorie;
// use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    /**
     * @Route("/produit/{id}", name="app_produit", methods={"GET"})
     */
    public function index(Categorie $categorie): Response
    {
       $produits = $categorie->getProduits();
        
        return $this->render('produit/index.html.twig', [
            'categorie' => $categorie,
            'produits' => $produits
              
        ]);
    }
}
