<?php

namespace App\Repository;

use App\Entity\RendezVous;
use App\Entity\Medecin;
use App\Entity\Patient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RendezVous>
 */
class RendezVousRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RendezVous::class);
    }

    public function findRdvByMedecin(Medecin $medecin): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.rpps_medecin = :medecin')
            ->setParameter('medecin', $medecin)
            ->orderBy('r.date', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findRdvByPatient(Patient $patient): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.num_secu_sociale_patient = :patient')
            ->setParameter('patient', $patient)
            ->orderBy('r.date', 'ASC')
            ->getQuery()
            ->getResult();
    }


//    /**
//     * @return RendezVous[] Returns an array of RendezVous objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RendezVous
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
