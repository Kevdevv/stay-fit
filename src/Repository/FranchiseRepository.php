<?php

namespace App\Repository;

use App\Entity\Franchise;
use App\Entity\FranchiseSearch;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Franchise>
 *
 * @method Franchise|null find($id, $lockMode = null, $lockVersion = null)
 * @method Franchise|null findOneBy(array $criteria, array $orderBy = null)
 * @method Franchise[]    findAll()
 * @method Franchise[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FranchiseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Franchise::class);
    }

    public function add(Franchise $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Franchise $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllVisible(FranchiseSearch $search)
    {

        $query = $this->createQueryBuilder('f');

        if($search->getName())
        {
            $query
                ->andwhere('f.name = :value')
                ->setParameter('value', $search->getName())
                ;
        }

        if($search->getOptions() == 'activé')
        {
            $query
                ->andwhere('f.active = true')
                ;
        }

        if($search->getOptions() == 'désactivé')
        {
            $query
                ->andwhere('f.active = false')
                ;
        }

        return $query
            ->getQuery()
            ->getResult()
            ;

    }

//    public function findOneBySomeField($value): ?Franchise
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
