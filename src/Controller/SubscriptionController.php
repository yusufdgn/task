<?php


namespace App\Controller;

use App\Service\SubscriptionService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class SubscriptionController
 * @package App\Controller
 */
class SubscriptionController extends BaseController
{
    /**
     * @param RequestStack $requestStack
     * @param SubscriptionService $subscriptionService
     * @return JsonResponse
     */
    public function createSubscription(RequestStack $requestStack, SubscriptionService $subscriptionService): JsonResponse
    {
        $content = json_decode($requestStack->getCurrentRequest()->getContent(), true);
        $subscriptionResponse = $subscriptionService->createSubscription($this->getSubscriberId($requestStack), $content);
        return new JsonResponse($subscriptionResponse);
    }

    /**
     * @param RequestStack $requestStack
     * @param SubscriptionService $subscriptionService
     * @return JsonResponse
     */
    public function getSubscription(RequestStack $requestStack, SubscriptionService $subscriptionService): JsonResponse
    {
        $subscriptionResponse = $subscriptionService->getSubscription($this->getSubscriberId($requestStack));
        return new JsonResponse($subscriptionResponse);
    }

    /**
     * @param RequestStack $requestStack
     * @param SubscriptionService $subscriptionService
     * @return JsonResponse
     */
    public function deleteSubscription(RequestStack $requestStack, SubscriptionService $subscriptionService): JsonResponse
    {
        $content = json_decode($requestStack->getCurrentRequest()->getContent(), true);
        $response = $subscriptionService->deleteSubscription($this->getSubscriberId($requestStack), $content);
        return new JsonResponse($response);
    }
}