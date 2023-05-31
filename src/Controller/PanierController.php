<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

// use Symfony\Component\DependencyInjection\Loader\Configurator\session;

class PanierController extends AbstractController
{

    /**
     * @Route("/panier/vider", name="app_vider")
     */
    public function clear(Request $request)
    {
        $session = $request->getSession();
        $session->remove("democart");
        dd($session->get("democart"));
    }






    /**
     * @Route("/panier/{id}", name="app_panier")
     */
    public function index(
        Request $request,
        Produit $produit
    ): Response {
        $cle_idproduit = $produit->getId();
        $val_quantite = 1;



        // $cle_idproduit=$produit->getId();
        // $val_quantite=1;

        // $cart[$cle_idproduit] = $val_quantite;


        $session = $request->getSession();
        $moncart = $session->get("democart", []);



        if (isset($moncart[$cle_idproduit])) {
            $moncart[$cle_idproduit] = $moncart[$cle_idproduit] + 1;
        } else {
            $moncart[$cle_idproduit] = 1;
        }




        $session->set('democart', $moncart);
        $moncart = $session->get("democart");
        // dd($moncart);












        return $this->redirectToRoute('app_voir', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @Route("/panier2/voir", name="app_voir")
     */

    public function voir(Request $request, ProduitRepository $produitRepository)
    {
        $session = $request->getSession();
        $moncart = $session->get("democart", []);
        $total = 0;
        $panier = [];
        foreach ($moncart as $cle => $value) {
            $produit_encours = $produitRepository->find($cle);



            $panier[] = [
                'produit' => $produit_encours,
                'quantite' => $value,
                'total' => $produit_encours->getPrix() * $value,
            ];
            $total = $total + $produit_encours->getPrix() * $value;
        }
        // dd($panier);
        return $this->render('panier/index.html.twig', [
            'panier' => $panier,
            'total' => $total

        ]);
    }

    /**
     * @Route("/Panier3/{id}", name="app_supprimer")
     */

    public function remove_all($id, RequestStack $session)
    {

        // on recupere le panier
        $panier = $session->getSession()->get("democart");
        // on supprimer la clé du panier
        unset($panier[$id]);
        // on modifie la variable panier en session
        $session->getSession()->set("democart", $panier);
        return $this->redirectToRoute('app_voir', [], Response::HTTP_SEE_OTHER);
    }
}
