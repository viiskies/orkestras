<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryFormType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategoryController extends Controller
{
    private $entityManager;
    private $categoryRepository;

    public function __construct(EntityManagerInterface $entityManager, CategoryRepository $categoryRepository)
    {
        $this->entityManager = $entityManager;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @Route("/category/", name="category")
     */
    public function index()
    {
        $categories = $this->categoryRepository
            ->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/category/create/", name="category.create")
     */
    public function create(Request $request)
    {
        $category = new Category();

        $form = $this->createForm(CategoryFormType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Category $data */
            $data = $form->getData();

            $this->entityManager->persist($data);
            $this->entityManager->flush();

            return $this->redirect('/category');
        }

        return $this->render('category/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/category/{id}/edit", name="category.edit")
     */
    public function edit($id, Request $request)
    {
        $category = $this->categoryRepository->find($id);
        if ($category === null) {
            throw $this->createNotFoundException("Category #" . $id . " does not exist.");
        }
        return $this->handleMethod($request, $category);
    }

    /**
     * @Route("/category/{id}/delete/", name="category.delete")
     */
    public function delete($id)
    {
        $category = $this->categoryRepository->find($id);
        if ($category === null) {
            throw $this->createNotFoundException("Task #" . $id . " does not exist.");
        }
        $this->entityManager->remove($category);
        $this->entityManager->flush();

        return $this->redirect('/category');
    }

    /**
     * @Route("/category/{id}", name="category.show")
     */
    public function show($id)
    {
        $category = $this->categoryRepository->find($id);
        return $this->render('category/single.html.twig', ['category' => $category]);
    }

    /**
     * @param Request $request
     * @param $task
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    private function handleMethod(Request $request, $category)
    {
        $form = $this->createForm(CategoryFormType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Task $data */
            $data = $form->getData();

            $this->entityManager->persist($data);
            $this->entityManager->flush();

            return $this->redirect('/category');
        }

        return $this->render('category/create.html.twig', ['form' => $form->createView()]);
    }
}
