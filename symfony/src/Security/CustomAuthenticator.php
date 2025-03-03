<?php 
namespace App\Security;

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

class CustomAuthenticator extends JsonLoginAuthenticator
{
    private JWTTokenManagerInterface $jwtManager;

    public function __construct(JWTTokenManagerInterface $jwtManager)
    {
        $this->jwtManager = $jwtManager;
    }

    public function authenticate(Request $request): Passport
    {
        $credentials = json_decode($request->getContent(), true);

        if (!$credentials || !isset($credentials['username'], $credentials['password'])) {
            throw new AuthenticationException('Username et mot de passe requis.');
        }

        return new Passport(
            new UserBadge($credentials['username']),
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


        return new JsonResponse([
            'token' => $jwt,
            'roles' => $user->getRoles()
        ]);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): JsonResponse
    {
        return new JsonResponse(['error' => $exception->getMessage()], JsonResponse::HTTP_UNAUTHORIZED);
    }
}
