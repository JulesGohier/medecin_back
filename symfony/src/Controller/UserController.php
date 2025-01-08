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
    #[Route('/register', name: 'register', methods: ['POST'])]
    public function register(
        Request $request, 
        UserPasswordHasherInterface $passwordHasher, 
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        // Vérification des champs requis
        if (!isset($data['username']) || !isset($data['password']) || !isset($data['type'])) {
            return new JsonResponse(['error' => "username, password et type d'utilisateur sont requis."], JsonResponse::HTTP_BAD_REQUEST);
        }

        $existingUserPatient = $entityManager->getRepository(Patient::class)->findOneBy(['username' => $data['username']]);
        $existingUserMedecin = $entityManager->getRepository(Medecin::class)->findOneBy(['username' => $data['username']]);
        
        if ($existingUserMedecin || $existingUserPatient) {
            return new JsonResponse(['error' => 'Cet utilisateur existe déjà.'], JsonResponse::HTTP_CONFLICT);
        }

        if ($data['type'] === 'patient') {                      
            if(!isset($data['nom']) || !isset($data['prenom']) || !isset($data['num_secu_sociale']) || !isset($data['sexe'])){
                return new JsonResponse(['error' => "nom, prenom, sexe et num_secu_sociale sont requis."], JsonResponse::HTTP_BAD_REQUEST);
            }else{
                $user = new Patient();
                $user->setUsername($data['username']) 
                    ->setNom($data['nom'])
                    ->setPrenom($data['prenom'])
                    ->SetUsername($data['username'])
                    ->setRoles(['ROLE_PATIENT']);
                if(isset($data['num_tel'])){
                    $user->setNumTel($data['num_tel']);
                }
                if(isset($data['num_secu_sociale'])){                           
                    $numSecAlreadyUsed = $entityManager->getRepository(Patient::class)->findOneBy(['num_secu_sociale' => $data['num_secu_sociale']]);  
                    if($numSecAlreadyUsed){   
                        return new JsonResponse(['error' => "ce numero de securite sociale est deja utilise"], JsonResponse::HTTP_CONFLICT);
                    }else{
                        $user->setNumSecuSociale($data['num_secu_sociale']);
                    }
                }
                if(isset($data['email'])){                    
                    $user->setEmail($data['email']);
                }                
                if(isset($data['rpps_medecin'])){                    
                    $medecinDonne = $entityManager->getRepository(Medecin::class)->findOneBy(['num_rpps' => $data['rpps_medecin']]);                      
                    $user->setMedecinPerso($medecinDonne);
                } 
                if(isset($data['date_naissance'])){                    
                    $user->setDateNaissance(new \DateTime($data['date_naissance']));
                }   
                if(isset($data['antecedent'])){                    
                    $user->setAntecedent($data['antecedent']);
                }                               

                if ($data['sexe'] == 'homme'){
                    $user->setSexe(Sexe::HOMME);            
                } else if ($data['sexe'] == 'femme'){
                    $user->setSexe(Sexe::FEMME); 
                }


                $hashedPassword = $passwordHasher->hashPassword($user, $data['password']);
                $user->setPassword($hashedPassword);
        
                // Sauvegarde dans la base de données
                $entityManager->persist($user);
                $entityManager->flush();

                return new JsonResponse(['message' => 'Utilisateur de type Patient créé avec succès.'], JsonResponse::HTTP_CREATED);
            }
        } else if ($data['type'] === 'medecin'){
            if(!isset($data['nom']) || !isset($data['prenom']) || !isset($data['num_rpps'])){
                return new JsonResponse(['error' => "nom, prenom et num_rpps sont requis."], JsonResponse::HTTP_BAD_REQUEST);
            }else{
                $user = new Medecin();
                $user->setUsername($data['username'])
                    ->setNom($data['nom'])
                    ->setPrenom($data['prenom'])
                    ->setRoles(['ROLE_MEDECIN']);
                if(isset($data['num_tel'])){                    
                    $user->setNumTel($data['num_tel']);
                }
                if(isset($data['num_rpps'])){     
                    $numRppsAlreadyUsed = $entityManager->getRepository(Medecin::class)->findOneBy(['num_rpps' => $data['num_rpps']]);  
                    if($numRppsAlreadyUsed){   
                        return new JsonResponse(['error' => "ce numero rpps est deja utilise"], JsonResponse::HTTP_CONFLICT);
                    }else{
                        $user->setNumRpps($data['num_rpps']);
                    }   
                }
                if(isset($data['email'])){                    
                    $user->setEmail($data['email']);
                }                
                $hashedPassword = $passwordHasher->hashPassword($user, $data['password']);
                $user->setPassword($hashedPassword);
        
                // Sauvegarde dans la base de données
                $entityManager->persist($user);
                $entityManager->flush();

                return new JsonResponse(['message' => 'Utilisateur de type Medecin créé avec succès.'], JsonResponse::HTTP_CREATED);
            }
        } else {
            return new JsonResponse(['message' => "Type d'utilisateur non existant"], JsonResponse::HTTP_BAD_REQUEST);
        }


    }

    // #[Route('/login', name: 'login', methods: ['POST'])]
    // public function login(
    //     Request $request, 
    //     JWTTokenManagerInterface $jwtManager, 
    //     UserPasswordHasherInterface $passwordHasher, 
    //     EntityManagerInterface $entityManager
    // ): JsonResponse {
    //     $data = json_decode($request->getContent(), true);

    //     if (!isset($data['username']) || !isset($data['password'])) {
    //         return new JsonResponse(['error' => 'Username et mot de passe sont requis.'], JsonResponse::HTTP_BAD_REQUEST);
    //     }

    //     $user = $entityManager->getRepository(User::class)->findOneBy(['username' => $data['username']]);
    //     if (!$user) {
    //         return new JsonResponse(['error' => 'Identifiants incorrects.'], JsonResponse::HTTP_UNAUTHORIZED);
    //     }

    //     if (!$passwordHasher->isPasswordValid($user, $data['password'])) {
    //         return new JsonResponse(['error' => 'Identifiants incorrects.'], JsonResponse::HTTP_UNAUTHORIZED);
    //     }

    //     $token = $jwtManager->create($user);

    //     return new JsonResponse(['token' => $token]);
    // }
}
