<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/categories', name: 'app_categories')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('category/index.html.twig', [
            'categories' => $categories
        ]);
    }

    
    #[Route('/category/{id}', name: 'category_show')]
    public function show(Category $category): Response
    {
        return $this->render("category/show.html.twig", [
            "category" => $category
        ]);
    }

    
    #[Route('/create', name: 'category_create')]
    public function create(Request $request, CategoryRepository $categoryRepository): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$categoryRepository->persist($category);
            //$categoryRepository->flush();

            $categoryRepository->save($category, true);

            return $this->redirectToRoute('app_categories');
        }
        
        return $this->render('category/create.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }
}
