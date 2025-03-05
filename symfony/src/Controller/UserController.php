<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Entity\Medecin;
use App\Enum\Sexe;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_')]
class UserController extends AbstractController
{
    #[Route('/register/patient', name: 'register_patient', methods: ['POST'])]
    public function registerPatient(
        Request $request, 
        UserPasswordHasherInterface $passwordHasher, 
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['email'], $data['password'], $data['nom'], $data['prenom'], $data['num_secu_sociale'], $data['sexe'])) {
            return new JsonResponse(['error' => "Tous les champs sont requis."], JsonResponse::HTTP_BAD_REQUEST);
        }

        if ($entityManager->getRepository(Patient::class)->findOneBy(['email' => $data['email']])) {
            return new JsonResponse(['error' => 'Cet utilisateur existe déjà.'], JsonResponse::HTTP_CONFLICT);
        }

        if ($entityManager->getRepository(Patient::class)->findOneBy(['num_secu_sociale' => $data['num_secu_sociale']])) {
            return new JsonResponse(['error' => "Ce numéro de sécurité sociale est déjà utilisé."], JsonResponse::HTTP_CONFLICT);
        }

        $user = new Patient();
        $user->setEmail($data['email'])
            ->setNom($data['nom'])
            ->setPrenom($data['prenom'])
            ->setRoles(['ROLE_PATIENT'])
            ->setNumSecuSociale($data['num_secu_sociale'])
            ->setSexe($data['sexe'] === 'homme' ? Sexe::HOMME : Sexe::FEMME)
            ->setPassword($passwordHasher->hashPassword($user, $data['password']));

        if (isset($data['num_tel'])) {
            $user->setNumTel($data['num_tel']);
        }
        if (isset($data['email'])) {
            $user->setEmail($data['email']);
        }
        if (isset($data['date_naissance'])) {
            $user->setDateNaissance(new \DateTime($data['date_naissance']));
        }

        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Utilisateur de type Patient créé avec succès.'], JsonResponse::HTTP_CREATED);
    }

    #[Route('/register/medecin', name: 'register_medecin', methods: ['POST'])]
    public function registerMedecin(
        Request $request, 
        UserPasswordHasherInterface $passwordHasher, 
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['email'], $data['password'], $data['nom'], $data['prenom'], $data['num_rpps'])) {
            return new JsonResponse(['error' => "Tous les champs sont requis."], JsonResponse::HTTP_BAD_REQUEST);
        }

        if ($entityManager->getRepository(Medecin::class)->findOneBy(['email' => $data['email']])) {
            return new JsonResponse(['error' => 'Cet utilisateur existe déjà.'], JsonResponse::HTTP_CONFLICT);
        }

        if ($entityManager->getRepository(Medecin::class)->findOneBy(['num_rpps' => $data['num_rpps']])) {
            return new JsonResponse(['error' => "Ce numéro RPPS est déjà utilisé."], JsonResponse::HTTP_CONFLICT);
        }

        $user = new Medecin();
        $user->setEmail($data['email'])
            ->setNom($data['nom'])
            ->setPrenom($data['prenom'])
            ->setRoles(['ROLE_MEDECIN'])
            ->setNumRpps($data['num_rpps'])
            ->setPassword($passwordHasher->hashPassword($user, $data['password']));

        if (isset($data['num_tel'])) {
            $user->setNumTel($data['num_tel']);
        }
        if (isset($data['email'])) {
            $user->setEmail($data['email']);
        }

        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Utilisateur de type Médecin créé avec succès.'], JsonResponse::HTTP_CREATED);
    }
}
