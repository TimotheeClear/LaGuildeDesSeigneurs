<?php

namespace App\Repository;

use App\Entity\Character;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Character|null find($id, $lockMode = null, $lockVersion = null)
 * @method Character|null findOneBy(array $criteria, array $orderBy = null)
 * @method Character[]    findAll()
 * @method Character[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CharacterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Character::class);
    }

    // /**
    //  * @return Character[] Returns an array of Character objects
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
    public function findOneBySomeField($value): ?Character
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     *  Returns all the Characters based on their intelligence level
     */
    public function getAllByIntelligenceLevel(int $minIntelligence)
    {
        return $this->createQueryBuilder('c')
            ->select('c', 'p')
            ->leftJoin('c.player', 'p')
            ->where('c.intelligence >= :level')
            ->setParameter('level', $minIntelligence)
            ->getQuery()
            ->getResult();
    }

    public function findOneByIdentifier($identifier)
    {
        return $this->createQueryBuilder('c')
        ->select('c', 'p')
        ->leftJoin('c.player', 'p')
        ->where('c.identifier = :identifier')
        ->setParameter('identifier', $identifier)
        ->getQuery()
        ->getOneOrNullResult();
    }
}
