<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteplanController extends AbstractController
{
    /**
     * @Route("/siteplan", name="app_siteplan")
     */
    public function index(): Response
    {
        return $this->render('siteplan/index.html.twig', [
            'controller_name' => 'SiteplanController',
        ]);
    }
}
