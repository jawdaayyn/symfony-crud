<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/products', name: 'product_index')]
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
    }

    
    #[Route('/product/{id}', name: 'product_show')]
    public function show(Product $product): Response
    {
        return $this->render("product/show.html.twig", [
            "product" => $product
        ]);
    }

    
    #[Route('/product-create',  name: 'product_create')]
    public function create(Request $request, ProductRepository $productRepository): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $productRepository->save($product, true);

            return $this->redirectToRoute('product_index');
        }
        
        return $this->render('product/create.html.twig', [
            'products' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/product-edit/{id}', name: 'product_edit')]
    public function edit(Product $product, Request $request, ProductRepository $productRepository): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $productRepository->save($product, true);

            return $this->redirectToRoute('product_index');
        }
        
        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/product-delete/{id}', name: 'product_delete')]
    public function delete(Product $product, ProductRepository $productRepository): Response
    {
            $productRepository->remove($product, true);
            return $this->redirectToRoute('product_index');
    }


}
