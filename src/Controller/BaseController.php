<?php


namespace App\Controller;


use App\Service\TokenService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class BaseController
 * @package App\Controller
 */
class BaseController extends AbstractController
{
    public TokenService $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /**
     * @param $requestStack
     * @return string|null
     */
    public function getSubscriberId($requestStack): ?string
    {
        $authorizationHeader = $requestStack->getMainRequest()->headers->get('authorization');
        $jwtToken = $this->tokenService->getJwtOnAuthorizationHeader($authorizationHeader);
        return $this->tokenService->getJwtPayload($jwtToken, 'subscriberId');
    }

}