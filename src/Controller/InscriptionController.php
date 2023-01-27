<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\InscriptionType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'inscription')]
    public function index(Request $request ,ManagerRegistry $doctrine,UserPasswordHasherInterface $passwordhasher): Response
    {
        $user = new User;
        $form = $this->createForm(InscriptionType::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() contient des valeiurs soumises
            // mais, la variable `$user` d'origine a également été mise à jour

            $user = $form->getData();
            $mot_de_passe = $user->getPassword();
            $hashedPassword = $passwordhasher->hashPassword(
                $user,
                $mot_de_passe
            );
            $user->setPassword($hashedPassword);

            $entityManager = $doctrine->getManager();
            //entitymanager est un outils de doctrine pour gerer l'insersion en bdd
            $entityManager->persist($user);
            //indiquez à Doctrine que vous souhaitez (éventuellement) enregistrer le produit (aucune requête pour le moment)
            $entityManager->flush();
            //exécute réellement les requêtes (c'est-à-dire la requête INSERT)

            return $this->redirectToRoute('home');
        }

        return $this->render('inscription/index.html.twig', [
            'controller_name' => 'InscriptionController',
            'form'=>$form->createView()
        ]);
    }
}
