<?php

namespace App\Repository;

use App\Entity\Contribute;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @method Contribute|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contribute|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contribute[]    findAll()
 * @method Contribute[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContributeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contribute::class);
    }

    // /**
    //  * @return Contribute[] Returns an array of Contribute objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Contribute
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    // 投稿取得
    public function getResultContribute()
    {
        return $this->createQueryBuilder('c')
            ->select('c.textarea', 'c.updatedAt', 'u.username', 'u.image', 'u.age', 'u.sex', 'u.look')
            ->join('App\Entity\User', 'u', 'WITH', 'c.user = u.id')
            ->getQuery()
            ->getResult();
    }

    //投稿別
    public function getMyContribute($userId)
    {
        return $this->createQueryBuilder('c')
            ->select('c.id', 'c.textarea', 'c.updatedAt')
            ->andWhere('c.user = ?1')
            ->setParameter('1', $userId)
            ->getQuery()
            ->getResult();
    }

    


    // 投稿ページネーション

    // 全ページ取得
    public function getPage($currentPage = 1, $limit = 5)
    {
        $query = $this->createQueryBuilder('c')
        ->select('c.textarea', 'c.updatedAt', 'u.username', 'u.image', 'u.age', 'u.sex', 'u.look')
        ->join('App\Entity\User', 'u', 'WITH', 'c.user = u.id')
        ->orderBy('c.updatedAt', 'DESC')
        ->getQuery();
    
        $paginator = $this->paginate($query, $currentPage, $limit);

        return $paginator;
    }

    public function getPageArea($currentPage = 1, $limit = 5, $area)
    {

        if($area == '全エリア'){
            $query = $this->createQueryBuilder('c')
                ->select('c.id as contribute_id','u.id as user_id', 'c.textarea', 'c.updatedAt', 'u.username', 'u.image', 'u.age', 'u.sex', 'u.look')
                ->join('App\Entity\User', 'u', 'WITH', 'c.user = u.id')
                ->orderBy('c.updatedAt', 'DESC')
                ->getQuery();
        } else {
            $query = $this->createQueryBuilder('c')
                ->select('c.id as contribute_id', 'u.id as user_id', 'c.textarea', 'c.updatedAt', 'u.username', 'u.image', 'u.age', 'u.sex', 'u.look', 'u.area')
                ->join('App\Entity\User', 'u', 'WITH', 'c.user = u.id')
                ->orderBy('c.updatedAt', 'DESC')
                ->where('u.area = ?1')
                ->setParameter(1, $area)
                ->getQuery();
        }

            $paginator = $this->paginate($query, $currentPage, $limit);

            return $paginator;
    }

    // ページネーション作成
    public function paginate($dql, $page = 1 , $limit = 5)
    {
        $paginator = new Paginator($dql);

        $paginator->getQuery()
            ->setFirstResult($limit * ($page - 1))
            ->setMaxResults($limit);

        return $paginator;
    }
}
