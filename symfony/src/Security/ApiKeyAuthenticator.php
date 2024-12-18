<?php 

namespace App\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;



class ApiKeyAuthenticator extends AbstractAuthenticator
{
    private $logger;

    public function __construct(JWTTokenManagerInterface $jwtManager, LoggerInterface $logger)
    {
        $this->logger = $logger; 
    } 
    
    public function supports(Request $request): ?bool 
    { 
        return $request->headers->has('Authorization') && str_contains($request->headers->get('Authorization'), 'Bearer'); 
    } 

    public function authenticate(Request $request): Passport 
    { 
        $identifier = str_replace('Bearer', '', $request->headers->get('Authorization'));
        $this->logger->info('Token JWT reçu : ' . $identifier);
        return new SelfValidatingPassport(
            new UserBadge($identifier)
        );
    } 

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }


    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response 
    { 
        $this->logger->error('Échec de l\'authentification : ' . $exception->getMessage());
        return new JsonResponse(['message' => $exception->getMessage()
        ], Response::HTTP_UNAUTHORIZED); 
    }
}
