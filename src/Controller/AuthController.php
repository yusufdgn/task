<?php


namespace App\Controller;

use App\Service\Validation\Constraint\LoginConstraint;
use App\Service\Jwt\TokenGenerator;
use App\Service\Validation\ValidationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class AuthController
 * @package App\Controller
 */
class AuthController extends AbstractController
{
    public function login(RequestStack $requestStack)
    {
        $content = json_decode($requestStack->getCurrentRequest()->getContent(), true);
        $validationService = new ValidationService();
        $validationService->validate($content, LoginConstraint::rules());
        $tokenGenerator = new TokenGenerator();
        return new JsonResponse(['token'=>$tokenGenerator->generate($content)]);
    }

    public function JwtTest(RequestStack $requestStack)
    {
        dd("test");
    }
}
