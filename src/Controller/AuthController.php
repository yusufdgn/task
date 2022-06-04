<?php


namespace App\Controller;

use App\Service\AuthService;
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
    /**
     * @param RequestStack $requestStack
     * @param AuthService $authService
     * @return JsonResponse
     */
    public function login(RequestStack $requestStack, AuthService $authService): JsonResponse
    {
        $content = json_decode($requestStack->getCurrentRequest()->getContent(), true);
        return new JsonResponse(['token' => $authService->generateSubscriberToken($content)]);
    }

    /**
     * @param RequestStack $requestStack
     * @param AuthService $authService
     * @return JsonResponse
     */
    public function register(RequestStack $requestStack, AuthService $authService): JsonResponse
    {
        $content = json_decode($requestStack->getCurrentRequest()->getContent(), true);
        $subscriber = $authService->createSubscriber($content);
        return new JsonResponse($subscriber->toArray());
    }
}
