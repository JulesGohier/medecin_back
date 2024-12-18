<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SecurityController extends AbstractController
{
    #[Route('/api/login_check', name: 'api_login_check')]
    public function index()
    {

    }

    #[Route('/api/test', name: 'api_test')]
    public function test(): Response
    {
        return new Response('ca marche enfin, (c\'est que un test calmos)');
    }
}
