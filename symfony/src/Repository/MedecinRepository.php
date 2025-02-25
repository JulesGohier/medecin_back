<?php

namespace App\Repository;

use App\Entity\Medecin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Medecin>
 */
class MedecinRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Medecin::class);
    }

    /**
     * Récupère le premier médecin de la base de données.
     *
     * @return Medecin|null Retourne le premier médecin ou null si aucun médecin n'existe.
     */
    public function findFirstMedecin(): ?Medecin
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.num_rpps', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Récupère le dernier médecin de la base de données.
     *
     * @return Medecin|null Retourne le dernier médecin ou null si aucun médecin n'existe.
     */
    public function findLastMedecin(): ?Medecin
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.num_rpps', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByRpps(string $rpps): ?Medecin
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.num_rpps = :rpps')
            ->setParameter('rpps', $rpps)
            ->getQuery()
            ->getOneOrNullResult();
    }

//    /**
//     * @return Medecin[] Returns an array of Medecin objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Medecin
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
