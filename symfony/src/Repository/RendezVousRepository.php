<?php

namespace App\Repository;

use App\Entity\RendezVous;
use App\Entity\Medecin;
use App\Entity\Patient;
use App\Enum\State;
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
            ->orderBy('CASE WHEN r.state = :reserved THEN 0 ELSE 1 END', 'ASC')  // Prioriser les rdv avec état "RESERVE"
            ->addOrderBy('r.date', 'ASC')  // Trier ensuite par date
            ->setParameter('reserved', State::RESERVE)  // État "RESERVE"
            ->getQuery()
            ->getResult();
    }

    public function findProchainRdvByPatient(Patient $patient): ?RendezVous
    {
        return $this->createQueryBuilder('r')
            ->where('r.num_secu_sociale_patient = :patient')
            ->andWhere('r.date >= :now')
            ->andWhere('r.state != :annule') // Exclure les rendez-vous annulés
            ->andWhere('r.state != :passe')
            ->setParameter('patient', $patient)
            ->setParameter('now', new \DateTime())
            ->setParameter('annule', State::ANNULE->value)  // Utiliser ->value si State est une Enum PHP 8
            ->setParameter('passe', State::PASSE->value)
            ->orderBy('r.date', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
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
