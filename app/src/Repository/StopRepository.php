<?php
/**
 * Stop repository.
 */

namespace App\Repository;

use App\Entity\Stop;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class StopRepository.
 *
 * @method Stop|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stop|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stop[]    findAll()
 * @method Stop[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StopRepository extends ServiceEntityRepository
{
    /**
     * StopRepository constructor.
     *
     * @param \Symfony\Bridge\Doctrine\RegistryInterface $registry Registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Stop::class);
    }

    /**
     * Query all records.
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    public function queryAll(): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->orderBy('s.id', 'ASC');
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
        return $queryBuilder ?: $this->createQueryBuilder('s');
    }

    /**
     * Save record.
     *
     * @param \App\Entity\Stop $stop Stop entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Stop $stop): void
    {
        $this->_em->persist($stop);
        $this->_em->flush($stop);
    }

    /**
     * Delete record.
     *
     * @param \App\Entity\Stop $stop Lessons entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Stop $stop)
    {
        $this->_em->remove($stop);
        $this->_em->flush($stop);
    }

    /**
     * @param string $name
     * @return Stop|null
     */
    public function findOneByName(string $name)
    {
        return $this->findOneBy(['name' => $name]);
    }
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
    /**
     * @param int $id
     * @return array|null
     */
    /*
    public function findById(int $id): array
    {
        return isset($this->data[$id]) && count($this->data)
            ? $this->data[$id] : null;
    }
    /**
     * @return array
     */
    /*public function findAll(): array
    {
        return $this->data;
    }*/
}
