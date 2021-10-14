<?php

namespace App\Repository;

use App\Entity\Message;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Message|null find($id, $lockMode = null, $lockVersion = null)
 * @method Message|null findOneBy(array $criteria, array $orderBy = null)
 * @method Message[]    findAll()
 * @method Message[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    // /**
    //  * @return Message[] Returns an array of Message objects
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
    public function findOneBySomeField($value): ?Message
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findBordMessage($bordId)
    {
        return $this->createQueryBuilder('m')
        ->select('m.message', 'IDENTITY(m.to_user) AS to_user_id', 'IDENTITY(m.from_user) AS from_user_id', 'm.createdAt, u.image, u.username')
        ->join('App\Entity\Bord', 'b', 'WITH', 'b.id = m.bord')
        ->join('App\Entity\User', 'u', 'WITH', 'u.id = from_user_id')
        ->andWhere('m.bord = ?1')
        ->setParameter(1, $bordId)
        ->orderBy('m.createdAt', 'ASC')
        ->getQuery()
        ->getResult();
    }

    

    public function myMessage($userId)
    {
        return $this->createQueryBuilder('m')
        ->select('m.message', 'IDENTITY(m.to_user) AS to_user_id', 'IDENTITY(m.from_user) AS from_user_id', 'MAX(m.createdAt) AS message_at', 'u.image', 'u.username', 'IDENTITY(b.contribute) AS bord_contribute_id', 'c.textarea', 'c.updatedAt AS contribute_at', 'b.id AS bord_id', 'IDENTITY(m.contribute) AS message_contribute_id', 'IDENTITY(c.user) AS contribute_user_id')
        ->join('App\Entity\Bord', 'b', 'WITH', 'b.id = m.bord')
        ->join('App\Entity\User', 'u', 'WITH', 'u.id = from_user_id')
        ->join('App\Entity\Contribute', 'c', 'WITH', 'c.id = message_contribute_id')
        ->groupBy('u.id')
        ->where('contribute_user_id = ?1')
        ->orderBy('message_at', 'DESC')
        ->setParameter(1, $userId)
        ->getQuery()
        ->getResult();
    }

    public function guestWhichContribute($userId)
    {
        return $this->createQueryBuilder('m')
        ->select('IDENTITY(m.contribute) AS message_contribute_id', 'IDENTITY(m.from_user) AS from_user_id', 'c.textarea','IDENTITY(c.user) AS contribute_user_id', 'IDENTITY(m.to_user) AS to_user_id')
        ->join('App\Entity\Contribute', 'c', 'WITH', 'c.id = message_contribute_id')
        ->groupBy('c.textarea')
        ->orderBy('m.createdAt', 'DESC')
        ->where('from_user_id = ?1')
        ->setParameter(1, $userId)
        ->getQuery()
        ->getResult();
    }

    public function myMessageGuest($userId)
    {
        return $this->createQueryBuilder('m')
        ->select('m.message', 'IDENTITY(m.to_user) AS to_user_id', 'IDENTITY(m.from_user) AS from_user_id', 'MAX(m.createdAt) AS message_at', 'u.image', 'u.username', 'IDENTITY(b.contribute) AS bord_contribute_id', 'c.textarea', 'c.updatedAt AS contribute_at', 'b.id AS bord_id', 'IDENTITY(m.contribute) AS message_contribute_id', 'IDENTITY(c.user) AS contribute_user_id')
        ->join('App\Entity\Bord', 'b', 'WITH', 'b.id = m.bord')
        ->join('App\Entity\User', 'u', 'WITH', 'u.id = from_user_id')
        ->join('App\Entity\Contribute', 'c', 'WITH', 'c.id = message_contribute_id')
        ->groupBy('u.id')
        ->andWhere('to_user_id = ?1')
        ->setParameter(1, $userId)
        ->orderBy('m.createdAt', 'ASC')
        ->getQuery()
        ->getResult();
    }

    
}
