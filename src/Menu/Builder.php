<?php

namespace App\Menu;

use App\Entity\Categories;
use App\Entity\Pages;
use App\Repository\CategoriesRepository;
use App\Repository\PagesRepository;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Knp\Menu\MenuItem;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{

    use ContainerAwareTrait;

    /** @var ItemInterface */
    private $menu;



    private $factory;
//
    private $repository;
//
//
//

    public function __construct(FactoryInterface $factory, CategoriesRepository $repository)
    {
        $this->factory = $factory;
        $this->repository = $repository;
    }


    /**
     * @param FactoryInterface $factory
     * @param array $options
     *
     * @return ItemInterface
     */

    public function mainMenu( array $options)
    {
        $this->menu = $this->factory->createItem('root') ->setChildrenAttributes(['class'=>'uk-nav-default uk-nav-parent-icon','data-uk-nav'=>'data-uk-nav']);
        $this->menu->addChild('Home', array('route' => 'homepage'));

//        $em = $this->container->get('doctrine')->getManager();
        $categoriesRoute='categories';
// get all published pages
        $pages = $this->repository->findAll();

//        dd($pages);
// build pages
        try {
            $this->buildPageTree($pages );
//            dd($this->buildPageTree($pages));
        } catch (\Exception $e) {
            error_log($e->getMessage());
        }

        return $this->menu;
    }

    /**
     *
     * @param array $pages
     * @param Categories $parent
     * @param MenuItem $menuItem
     *
     * @throws \Exception
     */
    private function buildPageTree(array $pages, $parent = null, $menuItem = null)
    {

        $categoriesRoute='categories';
        /** @var Categories $page */
        foreach ($pages as $page) {

// If page doesn't have a parent, and no menuItem was passed then this is a top level add.
            if (empty($page->getParentPage())  && empty($menuItem))
                $parentMenu = $this->menu->addChild($page->getCategory(),  ['route' => $categoriesRoute,
                    'routeParameters' => [
                        'slug' => $page->getSlug(),
                    ]
                ]);

// if the current page's parent is === supplied parent, go deeper
            if ($page->getParentPage() === $parent) {
// if a menuItem was given, then this page is a child so added it to the provided menu.
                if (!empty($menuItem))

//                    $this->menu->setChildrenAttribute('class','uk-nav-sub');
                    $parentMenu = $menuItem->setChildrenAttribute('class','uk-nav-sub')
                        ->setAttributes(['class'=>'uk-parent', ])
                        ->addChild($page->getCategory(),  ['route' => $categoriesRoute,
                        'routeParameters' => [
                            'slug' => $page->getSlug(),
                        ]
                    ])->setAttributes(['class'=>'dupa', ]);

// go deeper
                $this->buildPageTree($pages, $page, $parentMenu);
            }
        }
    }

}