<?php

namespace App\Repository;

use App\Entity\BusRoute;
use App\Repository\StopRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BusRoute|null find($id, $lockMode = null, $lockVersion = null)
 * @method BusRoute|null findOneBy(array $criteria, array $orderBy = null)
 * @method BusRoute[]    findAll()
 * @method BusRoute[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BusRouteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BusRoute::class);
    }


    /**
     * Query all records.
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    public function queryAll(): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->orderBy('br.id', 'DESC');
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
        return $queryBuilder ?: $this->createQueryBuilder('br');
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
     * @param \App\Entity\BusRoute $busroute BusRoute entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(BusRoute $busroute): void
    {
        $this->_em->persist($busroute);
        $this->_em->flush($busroute);
    }

    /**
     * Delete record.
     *
     * @param \App\Entity\BusRoute $busroute BusRoute entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(BusRoute $busroute): void
    {
        $this->_em->remove($busroute);
        $this->_em->flush($busroute);
    }

    /**
     * @param $value
     * @return mixed
     */
    /*public function search($value)
    {
        $qb = $this->getOrCreateQueryBuilder()
            ->leftJoin('br.stop', 's')
            ->leftJoin('br.bus_line', 'bl')
            ->addSelect('s.name')
            ->addSelect('bl.number')
            ->where($this->expr()->like('s.name', ':value'))
            ->setParameter('value','%'.$value.'%')
            ->getQuery()
            ->getResult();

        $qb1 = $this->getOrCreateQueryBuilder();

        return $qb1->leftJoin('br.stop', 's')
            ->leftJoin('br.bus_line', 'bl')
            ->addSelect('s.name')
            ->addSelect('bl.number')
            ->where($qb1->expr()->like('bl.number', $this->$qb))
            ->getQuery()
            ->getResult();
    }*/
    public function search($value)
    {
        $qb = $this->getOrCreateQueryBuilder();

        return $qb->leftJoin('br.stop', 's')
            ->leftJoin('br.bus_line', 'bl')
            ->addSelect('s.name')
            ->addSelect('bl.number')
            ->where($qb->expr()->like('s.name', ':value'))
            ->setParameter('value','%'.$value.'%')
            ->getQuery()
            ->getResult();
    }
    /*
    public function search($value)
    {
        $qb = $this->getOrCreateQueryBuilder();
        return $qb->select('br.id')
            ->where($qb->expr()->like('br.id', ':value'))
            ->setParameter('value','%'.$value.'%')
            ->getQuery()
            ->getResult();
    }
    */

    // /**
    //  * @return Stop[] Returns an array of Stop objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Stop
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

    // /**
    //  * @return BusRoute[] Returns an array of BusRoute objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BusRoute
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

