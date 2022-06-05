<?php


namespace App\EventListener;


use App\Entity\Subscriber;
use App\Service\TokenService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Event\RequestEvent;

/**
 * Class RequestListener
 * @package App\EventListener
 */
class RequestListener
{
    private TokenService $tokenService;

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager, TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
        $this->entityManager = $entityManager;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $pathInfo = $event->getRequest()->getPathInfo();
        $whiteList = ['/login', '/register', '/subscription-hook'];
        if (in_array($pathInfo, $whiteList)) {
            return;
        }

        $headers = $event->getRequest()->headers;
        if ($headers->get('authorization') === null || !str_contains($headers->get('authorization'), 'Bearer')) {
            throw new BadRequestException("Authorization failure");
        }

        $jwt = $this->tokenService->getJwtOnAuthorizationHeader($headers->get('authorization'));
        $this->tokenService->validate($jwt);
        $subscriberId = $this->tokenService->getJwtPayload($jwt, 'subscriberId');
        /** @var Subscriber $subscriber */
        $subscriber = $this->entityManager->getRepository(Subscriber::class)->findOneBy(["uniqueId" => $subscriberId]);
        if ($subscriber == null) {
            throw new BadRequestException("Subscriber not found.");
        }
    }

}
