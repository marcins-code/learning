<?php

namespace App\Controller;

use App\Entity\Articles;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends AbstractController
{
    /**
     * @Route("/articles", name="articles")
     */
    public function index(Request $request)
    {

        $q = $request->query->get('slug');

        $article =$this->getDoctrine()->getRepository(Articles::class)->findOneBy(['slug'=>$q]);

//        var_dump($article);
        return $this->render('articles/articles.html.twig', [
            'title' => 'Artykuł',
            'article'=>$article
        ]);
    }
}
