<?php


namespace App\Controller;


use App\Service\SubscriptionService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class WebhookController
 * @package App\Controller
 */
class WebhookController extends BaseController
{
    /**
     * @param RequestStack $requestStack
     * @param SubscriptionService $subscriptionService
     * @return JsonResponse
     * @throws \Exception
     */
    public function subscriptionHook(RequestStack $requestStack, SubscriptionService $subscriptionService)
    {
        $content = json_decode($requestStack->getCurrentRequest()->getContent(), true);
        $subscriptionService->hookUpdateSubscription($content);
        return new JsonResponse(['success' => true]);
    }
}