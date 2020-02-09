<?php

namespace App\Controller;

use App\Entity\Articles;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends AbstractController
{
    /**
     * @Route("/categories", name="categories")
     */
    public function index(Request $request)
    {

        $q = $request->query->get('cat_id');

        $test = $this->getDoctrine()
            ->getRepository(Articles::class)
            ->findBy(['category_id' => $q], ['createdAt' => 'DESC']);

//        dd($q);
        return $this->render('categories/categories.html.twig', [
            'controller_name' => 'CategoriesController',
            'q' => $q,
            'test' => $test,
        ]);
    }
}
