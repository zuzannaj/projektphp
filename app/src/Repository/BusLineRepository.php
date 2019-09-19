<?php
/**
 * Bus line repository.
 */
namespace App\Repository;

use App\Entity\BusLine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class BusLineRepository
 */
class BusLineRepository extends ServiceEntityRepository
{
    /**
     * BusLineRepository constructor.
     * @param RegistryInterface $registry
     */
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
    public function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return $queryBuilder ?: $this->createQueryBuilder('bl');
    }

    /**
     * Save record.
     *
     * @param \App\Entity\BusLine $busline BusLine entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(BusLine $busline)
    {
        $this->_em->persist($busline);
        $this->_em->flush($busline);
    }

    /**
     * Delete record.
     *
     * @param \App\Entity\BusLine $busLine BusLine entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(BusLine $busLine)
    {
        $this->_em->remove($busLine);
        $this->_em->flush($busLine);
    }

    /**
     * Find one by number.
     *
     * @param string $line
     *
     * @return object|null
     */
    public function findOneByNumber(string $line)
    {
        return $this->findOneBy(['number' => $line]);
    }

    /**
     * Find by example field.
     *
     * @param string $value
     *
     * @return mixed
     */
    public function findByExampleField(string $value)
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

    /**
     * Find one by some field.
     *
     * @param string $value
     *
     * @return BusLine
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneBySomeField(string $value): BusLine
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
