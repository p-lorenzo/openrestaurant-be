<?php

namespace App\Repository;

use App\Entity\MenuSection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MenuSection|null find($id, $lockMode = null, $lockVersion = null)
 * @method MenuSection|null findOneBy(array $criteria, array $orderBy = null)
 * @method MenuSection[]    findAll()
 * @method MenuSection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MenuSectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MenuSection::class);
    }

    // /**
    //  * @return MenuSection[] Returns an array of MenuSection objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MenuSection
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
