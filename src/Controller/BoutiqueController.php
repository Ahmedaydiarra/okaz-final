<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BoutiqueController extends AbstractController
{
    /**
     * @Route("/boutique", name="app_boutique")
     */
    public function index(CategorieRepository $categorieRepository): Response
    {
        return $this->render('boutique/index.html.twig', [
            'categories' => $categorieRepository->findAll() ,
        ]);
    }
}
