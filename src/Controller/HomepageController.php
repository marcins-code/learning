<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Core\Security;

class HomepageController extends AbstractController
{
//    private $security;
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @Route("/", name="homepage")
     */

    public function index()
    {

        return $this->render('homepage/homepage.html.twig', [
            'controller_name' => 'HomepageController',
        ]);
    }
}
