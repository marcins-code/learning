<?php


namespace App\Menu;

use App\Entity\Categories;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\RequestStack;

class MenuBuilder
{

    private $factory;

    private $repo;




    public function __construct(FactoryInterface $factory, CategoriesRepository $repository)
    {
        $this->factory = $factory;
        $this->repository = $repository;
    }

    public function createSidebarMenu2(RequestStack $requestStack)
    {
//        $menu = $this->factory->createItem('root');
//        $repo = $this->repo->findActiveCategories();


//        $em = $this->container->get('doctrine')->getManager();
        // findMostRecent and Blog are just imaginary examples
//        $blog = $this->em->getRepository(Categories::class)->findActiveCategories();
//        dd($blog);
//        foreach ($blog as $li) {
//            $menu->addChild($li->getCategory(), [
//                'route' => 'homepage',
//                'routeParameters' => [
//                    'slug' => $li->getSlug()
//                ]
//            ]);
//        }
//        return $menu;

    }


    public function MyMenu()
    {
        $menu = $this->factory->createItem('root');
        $repository = $this->repository->findBy(array('parent'=>null));


            foreach ($repository as $repo) {

                echo $repo->getCategory();
            }

        foreach($repository as $li)
        {
            $menu->addChild($li->getCategory(), [
                'route' => 'homepage',
                'routeParameters' => [
                    'slug' => $li->getSlug()
                ]
            ]);
        }
        return $menu;
    }
}
