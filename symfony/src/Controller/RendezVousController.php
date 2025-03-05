<?php
namespace App\Controller;

use App\Entity\Medecin;
use App\Entity\Patient;
use App\Repository\RendezVousRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/rendez_vouses', name: 'api_')]
class RendezVousController extends AbstractController
{
    #[Route('/patient/{num_secu_sociale}', name: 'rdv_patient', methods: ['GET'])]
    public function getRendezVousByPatient(string $num_secu_sociale, EntityManagerInterface $entityManager, RendezVousRepository $rdvRepository): JsonResponse    
    {
        // Chercher le patient par son numéro de sécurité sociale
        $patient = $entityManager->getRepository(Patient::class)->findOneBy(['num_secu_sociale' => $num_secu_sociale]);

        if (!$patient) {
            return new JsonResponse(['error' => 'Patient non trouvé'], JsonResponse::HTTP_NOT_FOUND);
        }

        // Récupérer tous les rendez-vous du patient
        $rendezVous = $rdvRepository->findBy(['num_secu_sociale_patient' => $patient]);

        // Retourner les rendez-vous en format JSON
        return $this->json($rendezVous);
    }

    #[Route('/medecin/{num_rpps}', name: 'rdv_medecin', methods: ['GET'], defaults: ['num_rpps' => ''])]
    public function getRendezVousByMedecin(string $num_rpps, EntityManagerInterface $entityManager, RendezVousRepository $rdvRepository): JsonResponse    
    {
        // Chercher le médecin par son numéro RPPS
        $medecin = $entityManager->getRepository(Medecin::class)->findOneBy(['num_rpps' => (string) $num_rpps]);


        if (!$medecin) {
            return new JsonResponse(['error' => 'Médecin non trouvé'], JsonResponse::HTTP_NOT_FOUND);
        }

        // Récupérer tous les rendez-vous du médecin
        $rendezVous = $rdvRepository->findBy(['rpps_medecin' => $medecin]);

        return $this->json($rendezVous);
    }
}