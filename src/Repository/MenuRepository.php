<?php

// src/Repository/MenuRepository.php

namespace App\Repository;

use App\Entity\Menu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class MenuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Menu::class);
    }

    public function findAll()
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.enabled = :val')
            ->setParameter('val', 1)
            ->getQuery()
            ->getResult()
            ;
    }
}