<?php 
/*

namespace App\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Security\Authenticator\JWTAuthenticator as BaseJWTAuthenticator;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class CustomJWTAuthenticator extends BaseJWTAuthenticator
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function getCredentials(Request $request)
    {
        $token = $request->headers->get('Authorization');

        $this->logger->info('Token JWT reçu : ' . $token);

        if (!$token) {
            return null;
        }

        return str_replace('Bearer ', '', $token);
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $this->logger->info('Validation du token : ' . $credentials);

        try {
            $data = $this->decode($credentials);
            $username = $data['username'];
        } catch (\Exception $e) {
            $this->logger->error('Erreur lors de la validation du token : ' . $e->getMessage());
            return null;
        }

        return $userProvider->loadUserByUsername($username);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null; // Laisser l'utilisateur continuer
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $this->logger->error('Échec de l\'authentification : ' . $exception->getMessage());
        return new JsonResponse(['message' => 'Authentication Failed'], Response::HTTP_UNAUTHORIZED);
    }

    public function supportsRememberMe()
    {
        return false;
    }
}
*/