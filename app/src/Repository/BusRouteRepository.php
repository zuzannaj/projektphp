<?php
/**
 * Bus route Repository.
 */
namespace App\Repository;

use App\Entity\BusRoute;
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
     * @param \App\Entity\BusRoute $busRoute BusRoute entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(BusRoute $busRoute): void
    {
        $this->_em->persist($busRoute);
        $this->_em->flush($busRoute);
    }

    /**
     * Delete record.
     *
     * @param \App\Entity\BusRoute $busRoute BusRoute entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(BusRoute $busRoute): void
    {
        $this->_em->remove($busRoute);
        $this->_em->flush($busRoute);
    }

    /**
     * @param $value
     * @return mixed
     */
    public function search($value)
    {
        $qb = $this->getOrCreateQueryBuilder();

        return $qb->leftJoin('br.stop', 's')
            ->leftJoin('br.bus_line', 'bl')
            ->addSelect('s.name')
            ->addSelect('bl.number')
            ->where($qb->expr()->like('s.name', ':value'))
            ->setParameter('value', '%'.$value.'%')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param $value
     *
     * @return QueryBuilder
     */
    public function showLine($value)
    {
        return $this->createQueryBuilder('br')
            ->leftJoin('br.stop', 's')
            ->leftJoin('br.bus_line', 'bl')
            //->addSelect('bl.number')
            //->addSelect('br.stop_order')
            ->where('bl.number = :value')
            ->setParameter('value', $value)
            ->orderBy('br.stop_order', 'ASC');
        //->getQuery()
            //->getResult();
    }

    /**
     * @param $value
     * @return BusRoute|null
     * @throws
     */
    public function findOneBySomeField($value): ?BusRoute
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.stop_order = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
