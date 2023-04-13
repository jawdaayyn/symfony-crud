<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
Use App\Repository\UserRepository;
Use App\Entity\User;
use App\Form\UserType;

class UserController extends AbstractController
{


    #[Route('/users', name: 'user_index')]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        return $this->render('user/index.html.twig', [
            'users' => $users
        ]);
    }


    #[Route('/user/{id}', name: 'user_show')]
    public function show(User $user): Response
    {
        return $this->render("user/show.html.twig", [
            "user" => $user
        ]);
    }

    
    #[Route('/new', name: 'user_create')]
    public function create(Request $request, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$userRepository->persist($user);
            //$userRepository->flush();

            $userRepository->save($user, true);

            return $this->redirectToRoute('user_index');
        }
        
        return $this->render('user/create.html.twig', [
            'users' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/edit/{id}', name: 'user_edit')]
    public function edit(User $user, Request $request, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$userRepository->persist($user);
            //$userRepository->flush();

            $userRepository->save($user, true);

            return $this->redirectToRoute('user_index');
        }
        
        return $this->render('user/edit.html.twig', [
            'users' => $user,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/delete/{id}', name: 'user_delete')]
    public function delete(User $user, UserRepository $userRepository): Response
    {
            $userRepository->remove($user, true);
            return $this->redirectToRoute('user_index');
    }


    #[Route('/user-j', name: 'user_showJ')]
    public function showJ( UserRepository $userRepository): Response
    {
        $users = $userRepository->getUserJReverse();

        return $this->render("user/index.html.twig", [
            "users" => $users
        ]);
    }
} 
