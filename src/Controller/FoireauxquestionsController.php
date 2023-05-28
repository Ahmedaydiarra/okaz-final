<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FoireauxquestionsController extends AbstractController
{
    /**
     * @Route("/foireauxquestions", name="app_foireauxquestions")
     */
    public function index(): Response
    {
        return $this->render('foireauxquestions/index.html.twig', [
            'controller_name' => 'FoireauxquestionsController',
        ]);
    }
}
