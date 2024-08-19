<?php
// src/Controller/ProductController.php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Supplier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductController extends AbstractController
{
    #[Route('/api/products', name: 'add_product', methods: ['POST'])]
    public function addProduct(Request $request, EntityManagerInterface $em, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse
    {
        // Retrieve form fields
        $name = $request->request->get('name');
        $price = $request->request->get('price');
        $description = $request->request->get('description');
        $category_id = $request->request->get('category_id');
        $supplier_id = $request->request->get('supplier_id');
        $imageFile = $request->files->get('image');

        // Check for missing required fields
        if (!$name || !$price || !$description || !$category_id || !$supplier_id || !$imageFile) {
            return $this->json(['error' => 'Missing required fields'], 400);
        }

        // Handle file upload
        if ($imageFile) {
            $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = uniqid().'.'.$imageFile->guessExtension();

            try {
                $imageFile->move(
                    $this->getParameter('images_directory'), // Define this parameter in your services.yaml
                    $newFilename
                );
            } catch (FileException $e) {
                return $this->json(['error' => 'Failed to upload image'], 400);
            }
        } else {
            return $this->json(['error' => 'No image file uploaded'], 400);
        }

        // Find category
        $category = $em->getRepository(Category::class)->find($category_id);
        if (!$category) {
            return $this->json(['error' => 'Invalid category ID'], 400);
        }

        // Find supplier
        $supplier = $em->getRepository(Supplier::class)->find($supplier_id);
        if (!$supplier) {
            return $this->json(['error' => 'Invalid supplier ID'], 400);
        }

        // Create and set up product
        $product = new Product();
        $product->setName($name);
        $product->setPrice($price);
        $product->setDescription($description);
        $product->setImage($newFilename); // Save the filename to the entity
        $product->setCategory($category);
        $product->setSupplier($supplier);

        // Validate the product
        $errors = $validator->validate($product);
        if (count($errors) > 0) {
            return $this->json(['errors' => (string) $errors], 400);
        }

        // Save the product
        $em->persist($product);
        $em->flush();

        // Serialize the product
        $data = $serializer->normalize($product, null, ['groups' => 'product:read']);

        return $this->json($data, 201);
    }

    #[Route('/api/products/{id}', name: 'delete_product', methods: ['DELETE'])]
    public function deleteProduct(int $id, EntityManagerInterface $em): JsonResponse
    {
        $product = $em->getRepository(Product::class)->find($id);

        if (!$product) {
            return $this->json(['error' => 'Product not found'], 404);
        }

        $em->remove($product);
        $em->flush();

        return $this->json(['message' => 'Product deleted successfully'], 200);
    }

    #[Route('/api/categories', name: 'list_categories', methods: ['GET'])]
    public function listCategories(EntityManagerInterface $em): JsonResponse
    {
        $categories = $em->getRepository(Category::class)->findAll();
        $data = [];

        foreach ($categories as $category) {
            $data[] = [
                'id' => $category->getId(),
                'categoryName' => $category->getCategoryName(),
            ];
        }

        return $this->json($data, 200);
    }

    #[Route('/api/listing', name: 'list_products', methods: ['GET'])]
    public function listProducts(EntityManagerInterface $em, SerializerInterface $serializer): JsonResponse
    {
        // Fetch all products
        $products = $em->getRepository(Product::class)->findAll();

        // Serialize the products

        $data = [];

        foreach ($products as $product) {
            $data[] = [
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'description' => $product->getDescription(),
                'image' => $product->getImage(),
                'supplier' =>[
                    'name' => $product->getSupplier()->getName(),
                ],
                'category' =>[
                'categoryName' => $product->getCategory()->getCategoryName(),
                ]
            ];
        }

        return $this->json($data, 200);
    }
}
