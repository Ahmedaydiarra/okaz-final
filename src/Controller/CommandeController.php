<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Entity\Facture;
use DateTime;
use App\Entity\Commande;
use App\Service\CartService;
use Stripe\Checkout\Session;
use App\Repository\FactureRepository;
use App\Repository\ProduitRepository;
use App\Repository\CommandeRepository;
use Stripe\PaymentIntent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommandeController extends AbstractController
{
    /**
     * @Route("/profile/commande/success", name="app_commande_success")
     */
    public function succes(FactureRepository $factureRepository,
    RequestStack $session,
    ProduitRepository $produitRepository,
    CommandeRepository $commandeRepository, CartService $cartService): Response
    {
        $facture = new Facture();

        $facture->setUser($this->getUser());

        $facture->setDate(new DateTime());

        $factureRepository->add($facture, true);

        $panier=$session->getSession()->get("democart");

        foreach($panier as $key => $value){

            // création d'un objet commande
            $commandes= new Commande();
            // affectation de la propriété quantité issue du tableau panier
            $commandes->setQuantite($value);
            // affectation de la propriété produit
            // grace au repo du produit
            $commandes->setProduit($produitRepository->find($key));
            // affectation de la propriété facture issue du 
            // de la facture créé au dessus
            $commandes->setFacture($facture);
            $commandeRepository->add($commandes,true);
        }

        $cartService->clear();
 
        return $this->render(
            "commande/success.html.twig"
        );
    } 


    /**
     * @Route("/profile/commande/cancel", name="app_commande_cancel")
     */

     public function cancel(){
        
    } 

    /**
     * @Route("/profile/commande", name="app_commande")
     */

     public function index(
        //   CommandeRepository $commandeRepository,
           RequestStack $session,
           ProduitRepository $produitRepository,
   
           CartService $cart,
           FactureRepository $factureRepository,
   
           CommandeRepository $commandesRepository 
       ): Response

       {


        // 1. Payer sur STRIPE
        // communiquer avec stripe

        // on a le montant du panier
        $montant=$cart->getTotalAll()*100;


        $stripeSecretKey="sk_test_51NAttJAra2Hq4sinifViDnudhHLPXjNBWagdNhoBUUPd0FVm2SzxdVPjdFPAYCYYom7O7UUpiAcpep6mSqE6N0DN00Iotm0IXg";
        Stripe::setApiKey($stripeSecretKey);
        
        if (isset($_SERVER['HTTPS'])){
            $protocol="https://";
        } 
        $protocol="http://";

        $serveur=$_SERVER['SERVER_NAME'];
        $YOUR_DOMAIN=$protocol.$serveur;
        $checkout_session = \Stripe\Checkout\Session::create([
            'line_items' => [[
              # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
              'price_data' => [
                'currency' => 'eur',
                'unit_amount' => $montant,
                'product_data' => [
                  'name' => 'Paiement de votre panier'
                ],
              ],
              'quantity' => 1,
              ]],
              'mode' => 'payment',
              'success_url' => $YOUR_DOMAIN . '/profile/commande/success',
              'cancel_url' => $YOUR_DOMAIN . '/profile/commande/cancel',
  
          ]);
        //   dd($checkout_session);

        return $this->render('commande/index.html.twig', [
            'controller_name' => 'CommandeController',
            'id_session'=>$checkout_session->id
        ]);
    }
}
