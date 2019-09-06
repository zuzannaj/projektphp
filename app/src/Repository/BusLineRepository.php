<?php

namespace App\Repository;

use App\Entity\BusLine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BusLine|null find($id, $lockMode = null, $lockVersion = null)
 * @method BusLine|null findOneBy(array $criteria, array $orderBy = null)
 * @method BusLine[]    findAll()
 * @method BusLine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BusLineRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BusLine::class);
    }

    /**
     * Query all records.
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    public function queryAll(): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->orderBy('bl.id', 'DESC');
    }

    /**
     * Get or create new query builder.
     *
     * @param \Doctrine\ORM\QueryBuilder|null $queryBuilder Query builder
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return $queryBuilder ?: $this->createQueryBuilder('bl');
    }

    /**
     * @return array
     */
    /*public function findAll(): array
    {
        return $this->data;
    }

    /**
     * @param int $id
     * @return array|null
     */
    public function findById(int $id): ?array
    {
        return isset($this->data[$id]) && count($this->data)
            ? $this->data[$id] : null;
    }

    /**
     * Save record.
     *
     * @param \App\Entity\BusLine $busline BusLine entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(BusLine $busline): void
    {
        $this->_em->persist($busline);
        $this->_em->flush($busline);
    }

    /**
     * Delete record.
     *
     * @param \App\Entity\BusLine $busline BusLine entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(BusLine $busline): void
    {
        $this->_em->remove($busline);
        $this->_em->flush($busline);
    }

    /**
     * @param string $line
     * @return BusLine|null
     */
    public function findOneByNumber(string $line)
    {
        return $this->findOneBy(['number' => $line]);
    }

    // /**
    //  * @return BusLine[] Returns an array of BusLine objects
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
    public function findOneBySomeField($value): ?BusLine
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
