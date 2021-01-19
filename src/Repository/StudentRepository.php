<?php

namespace App\Repository;

use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Student|null find($id, $lockMode = null, $lockVersion = null)
 * @method Student|null findOneBy(array $criteria, array $orderBy = null)
 * @method Student[]    findAll()
 * @method Student[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }

    // /**
    //  * @return Student[] Returns an array of Student objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Student
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    /*
     * QueryBuilder - Question1-
     */
    public function findStudentsByOrder(){
        return $this->createQueryBuilder('s')
                    ->orderBy('s.email','ASC')
                    ->getQuery()
                    ->execute();

        /*
         * Solution avec DQL
         * $entityManager = $this->getEntityManager();
                            $query = $entityManager
                            ->createQuery('SELECT s FROM App\Entity\Student s ORDER BY s.email ASC');
                             return $query->getResult();
         */
    }

    /*
      * QueryBuilder - Question2-
      */
    public function searchStudent($nsc)
    {
        return $this->createQueryBuilder('s')
            ->Where('s.nsc LIKE :nsc')
            ->setParameter('nsc', '%'.$nsc.'%')
            ->getQuery()
            ->execute();
        /*
       * Solution avec DQL
       * $entityManager = $this->getEntityManager();
                          $query = $entityManager
                          ->createQuery('SELECT s FROM App\Entity\Student s WHERE s.nsc LIKE :nsc')
                          ->setParameter('nsc', '%'.$nsc.'%');
                           return $query->getResult();
       */
    }


    /*
     * QueryBuilder -Question3-
     */
    public function listStudentByClass($id)
    {
        return $this->createQueryBuilder('s')
            ->join('s.classroom', 'c')
            ->addSelect('c')
            ->where('c.id=:id')
            ->setParameter('id',$id)
            ->getQuery()
            ->getResult();
        /**
         * Solution avec DQL
         */
        /*$entityManager=$this->getEntityManager();
        $query=$entityManager
            ->createQuery("SELECT s FROM APP\Entity\Student s JOIN s.classroom c WHERE c.id=:id")
            ->setParameter('id',$id);
        return $query->getResult();*/


    }

    /**
     * @param $name
     * @return int|mixed|string
     * DQL -Question 3-
     */
      public function findStudentByClub($name){
          $entityManager=$this->getEntityManager();
          $query=$entityManager
              ->createQuery("SELECT s FROM APP\Entity\Student s JOIN s.clubs c WHERE c.ref=:name AND s.nsc LIKE :chaine ")
              ->setParameter('name',$name)
              ->setParameter('chaine','123%');
          return $query->getResult();
      }


}
