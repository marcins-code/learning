<?php

namespace App\Controller\SubControler;

use App\Entity\Articles;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RightSidebarController extends AbstractController
{
    /**
     * @Route("/right/sidebar", name="sidebar")
     */
    public function recentArticles()
    {
//        $article = $entity->getRepository(Articles::class)->findRecentArticles();
        $articles = $this->getDoctrine()->getRepository(Articles::class)->findRecentArticles();
//        var_dump($articles);
        return $this->render('sidebar/rigth_sidebar.html.twig', ['articles' => $articles]);
    }
}
