<?php

namespace App\Repository;

use App\Entity\MenuEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MenuEntry|null find($id, $lockMode = null, $lockVersion = null)
 * @method MenuEntry|null findOneBy(array $criteria, array $orderBy = null)
 * @method MenuEntry[]    findAll()
 * @method MenuEntry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MenuEntryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MenuEntry::class);
    }

    // /**
    //  * @return MenuEntry[] Returns an array of MenuEntry objects
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
    public function findOneBySomeField($value): ?MenuEntry
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
