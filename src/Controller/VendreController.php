<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VendreController extends AbstractController
{
    /**
     * @Route("/vendre", name="app_vendre")
     */
    public function index(): Response
    {
        return $this->render('vendre/index.html.twig', [
            'controller_name' => 'VendreController',
        ]);
    }
}
