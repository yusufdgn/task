<?php


namespace App\Controller;


use App\Service\CreditCardService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class CreditCardController
 * @package App\Controller
 */
class CreditCardController extends BaseController
{
    /**
     * @param RequestStack $requestStack
     * @param CreditCardService $creditCardService
     * @return JsonResponse
     */
    public function getCreditCards(RequestStack $requestStack, CreditCardService $creditCardService): JsonResponse
    {
        return new JsonResponse($creditCardService->getCreditCards($this->getSubscriberId($requestStack)));
    }

}