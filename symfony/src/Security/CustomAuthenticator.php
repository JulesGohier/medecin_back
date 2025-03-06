<?php 
namespace App\Security;

use App\Entity\Medecin;
use App\Entity\Patient;
use App\Entity\Admin;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\JsonLoginAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Repository\MedecinRepository;
use App\Repository\PatientRepository;
use App\Repository\AdminRepository;

class CustomAuthenticator extends JsonLoginAuthenticator
{
    private JWTTokenManagerInterface $jwtManager;
    private MedecinRepository $medecinRepository;
    private PatientRepository $patientRepository;
    private AdminRepository $adminRepository;

    public function __construct(
        JWTTokenManagerInterface $jwtManager,
        MedecinRepository $medecinRepository,
        PatientRepository $patientRepository,
        AdminRepository $adminRepository
    ) {
        $this->jwtManager = $jwtManager;
        $this->medecinRepository = $medecinRepository;
        $this->patientRepository = $patientRepository;
        $this->adminRepository = $adminRepository;
    }

    public function authenticate(Request $request): Passport
    {
        $credentials = json_decode($request->getContent(), true);

        if (!$credentials || !isset($credentials['email'], $credentials['password'])) {
            throw new AuthenticationException('Email et mot de passe requis.');
        }

        return new Passport(
            new UserBadge($credentials['email'], function ($email) {

                $admin = $this->adminRepository->findOneBy(['email' => $email]);
                if ($admin) {
                    return $admin;
                }

                // Rechercher d'abord un médecin
                $medecin = $this->medecinRepository->findOneBy(['email' => $email]);
                if ($medecin) {
                    return $medecin;
                }

                // Si ce n'est pas un médecin, chercher un patient
                $patient = $this->patientRepository->findOneBy(['email' => $email]);
                if ($patient) {
                    return $patient;
                }

                throw new AuthenticationException('Utilisateur non trouvé.');
            }),
            new PasswordCredentials($credentials['password'])
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): JsonResponse
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return new JsonResponse(['error' => 'Utilisateur non valide'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $jwt = $this->jwtManager->create($user);
        $roles = $user->getRoles();
        $id = null;

        if ($user instanceof Medecin) {
            $id = $user->getNumRpps(); // Récupérer le numéro RPPS pour un médecin
        } elseif ($user instanceof Patient) {
            $id = $user->getNumSecuSociale(); // Récupérer le numéro de sécurité sociale pour un patient

            return new JsonResponse([
                'token' => $jwt,
                'roles' => $roles,
                'patient' => [
                    'num_secu_sociale' => $user->getNumSecuSociale(),
                    'nom' => $user->getNom(),
                    'prenom' => $user->getPrenom(),
                    'sexe' => $user->getSexe()?->value,
                    'medecin_perso' => $user->getMedecinPerso()?->getNumRpps(),
                    'num_tel' => $user->getNumTel(),
                    'antecedent' => $user->getAntecedent(),
                    'date_naissance' => $user->getDateNaissance()?->format('Y-m-d'),
                    'email' => $user->getEmail(),
                    'rendez_vous' => array_map(fn($rdv) => [
                        'id' => $rdv->getId(),
                        'date' => $rdv->getDate()->format('Y-m-d H:i:s'),
                    ], $user->getRdv()->toArray())
                ],
            ]);
        } elseif ($user instanceof Admin) {
            $id = $user->getId();
        }

        return new JsonResponse([
            'token' => $jwt,
            'roles' => $roles,
            'id' => $id,
        ]);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): JsonResponse
    {
        return new JsonResponse(['error' => $exception->getMessage()], JsonResponse::HTTP_UNAUTHORIZED);
    }
}