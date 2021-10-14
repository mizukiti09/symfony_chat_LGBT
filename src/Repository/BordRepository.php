<?php

namespace App\Repository;

use App\Entity\Bord;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Bord|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bord|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bord[]    findAll()
 * @method Bord[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BordRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bord::class);
    }

    // /**
    //  * @return Bord[] Returns an array of Bord objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Bord
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function createBord($contribute_id, $contribute_user_id, $user_id)
    {
        $query = $this->createQueryBuilder('b')
        ->insert('bord')
        ->values(['contribute_id' => '?1', 'contribute_user_id' => '?2', 'user_id' => '?3', 'delete_flg' => '?4'])
        ->setParameter(1, $contribute_id)
        ->setParameter(2, $contribute_user_id)
        ->setParameter(3, $user_id)
        ->setParameter(4, 1)
        ->getQuery()
        ->execute();
    }

}
