<?php

namespace App\Repository;

use App\Entity\Club;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Club|null find($id, $lockMode = null, $lockVersion = null)
 * @method Club|null findOneBy(array $criteria, array $orderBy = null)
 * @method Club[]    findAll()
 * @method Club[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClubRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Club::class);
    }

    // /**
    //  * @return Club[] Returns an array of Club objects
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
    public function findOneBySomeField($value): ?Club
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /*
     * QueryBuilder -Question 4-
     */
    public function orderByDate()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.creation_date', 'DESC')
            ->setMaxResults(3)
            ->getQuery()->getResult();

        /**
         * Solution avec DQL
         */
        /*$entityManager = $this->getEntityManager();
        $query = $entityManager
            ->createQuery('SELECT c FROM App\Entity\Club c ORDER BY c.creation_date DESC')
            ->setMaxResults(3);
        return $query->getResult();*/
    }

    /**
     * QueryBuilder -Question5-
     */
    public function findEnabledClub(){

        $qb= $this->createQueryBuilder('c');
        $qb ->where('c.enabled=:enabled');
        $qb->setParameter('enabled',true);
        return $qb->getQuery()->getResult();

        /**
         * Solution avec DQL
         */
        /*$entityManager = $this->getEntityManager();
        $query = $entityManager
            ->createQuery('SELECT c FROM App\Entity\Club c WHERE c.enabled=:enabled')
            ->setParameter('enabled',true);
        return  $query->getResult();*/

    }

    /*
     * DQL -Question1-
     */
    public function findByPriceRange($minValue,$maxValue){
        $entityManager=$this->getEntityManager();
        $query=$entityManager
            ->createQuery("SELECT c FROM APP\Entity\Club c WHERE c.price >= :minvalue AND c.price <= :maxvalue")
            ->setParameters(['minvalue'=>$minValue,'maxvalue'=>$maxValue]);
        return $query->getResult();

        /**
         * solution avec QueryBuilder
         */
        /*$qb= $this->createQueryBuilder('c');
        $qb ->where('c.price >= :minValue');
        $qb->setParameter('minValue',$minValue);
        $qb->andWhere('c.price <= :maxValue');
        $qb->setParameter('maxValue',$maxValue);
        return $qb->getQuery()->getResult();*/
    }


    /**
     * @param $dateOne
     * @param $dateTwo
     * @return int|mixed|string
     * DQL- Question2-
     */
    public function clubPerDate($dateOne,$dateTwo){
        $entityManager=$this->getEntityManager();
        $query=$entityManager
            ->createQuery("SELECT c FROM APP\Entity\Club c WHERE c.creation_date BETWEEN :dateOne AND :dateTwo")
            ->setParameters(['dateOne'=>$dateOne,'dateTwo'=>$dateTwo]);
        return $query->getResult();

        /**
         * Solution avec QueryBuilder
         */
        /*$qb= $this->createQueryBuilder('c');
        $qb ->where('c.creation_date BETWEEN :dateOne AND :dateTwo');
        $qb->setParameters(['dateOne'=>$dateOne,'dateTwo'=>$dateTwo]);
        return $qb->getQuery()->getResult();*/

    }

}
