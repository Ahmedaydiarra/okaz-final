<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CguCgvController extends AbstractController
{
    /**
     * @Route("/cgu/cgv", name="app_cgu_cgv")
     */
    public function index(): Response
    {
        return $this->render('cgu_cgv/index.html.twig', [
            'controller_name' => 'CguCgvController',
        ]);
    }
}
