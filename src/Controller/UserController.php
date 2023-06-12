<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\FactureRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="app_user", methods={"GET"})
     */
    public function index(FactureRepository $factureRepository): Response
    {

        // recuperation de user en cours
        $monuser = $this->getUser();

        // recuperation des factures selon le user en cours
        $facture_user = $factureRepository->findBy([
            'user' => $monuser
        ]);

       // dd($this->getUser());
        return $this->render('user/index.html.twig', [
            'user' => $monuser,
            'factures' => $facture_user

        ]);
    }
 

    /**
     * @Route("/{id}", name="app_user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_user_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
 
}
