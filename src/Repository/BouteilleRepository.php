<?php

namespace App\Repository;

use App\Entity\Bouteille;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vente>
 *
 * @method Vente|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vente|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vente[]    findAll()
 * @method Vente[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BouteilleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bouteille::class);
    }

    public function save(Bouteille $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Bouteille $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
    * @return Bouteille[] Returns an array of Vente objects
    */
   public function findByExampleField($value): array
   {
       return $this->createQueryBuilder('v')
           ->andWhere('v.exampleField = :val')
           ->setParameter('val', $value)
           ->orderBy('v.id', 'ASC')
           ->setMaxResults(10)
           ->getQuery()
           ->getResult()
       ;
   }

   public function findOneBySomeField($value): ?Bouteille
   {
       return $this->createQueryBuilder('v')
           ->andWhere('v.exampleField = :val')
           ->setParameter('val', $value)
           ->getQuery()
           ->getOneOrNullResult()
       ;
   }

   /**
     * @return Bouteille[]
     */
    public function findByPricePlus(int $price): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT b
            FROM App\Entity\Bouteille b
            WHERE b.price > :price
            ORDER BY b.price ASC'
        )->setParameter('price', $price);

        // returns an array of Product objects
        return $query->getResult();
    }

     /**
     * @return Bouteille[]
     */
    public function orderByCritere(string $critere): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT b
            FROM App\Entity\Bouteille b
            ORDER BY b.' .$critere.' ASC'
        );
        // returns an array of Product objects
        return $query->getResult();
    }

    /**
     * @return Bouteille[]
     */
    public function orderByCritereWhereSup(string $critere, string $numb): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT b
            FROM App\Entity\Bouteille b
            WHERE b.price > :numb
            ORDER BY b.' . $critere .' ASC'
        )->setParameter('numb', $numb);
        // returns an array of Product objects
        return $query->getResult();
    }
}
