<?php


namespace App\EventListener;


use App\Service\Jwt\TokenValidator;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;


class RequestListener
{
    public function onKernelRequest(RequestEvent $event)
    {
        $pathInfo = $event->getRequest()->getPathInfo();
        if ($pathInfo === '/login') {
            return;
        }

        // @todo yeni exception sınıfları oluşturulacak.
        $headers = $event->getRequest()->headers;
        if ($headers->get('authorization') === null || !str_contains($headers->get('authorization'), 'Bearer')) {
            throw new BadRequestHttpException("Authorization failure");
        }

        $authorizationKeys = explode(' ', $headers->get('authorization'));
        if (count($authorizationKeys) !== 2) {
            // @todo Login Exception
            throw new BadRequestHttpException("Authorization Needed!");
        }

        if ($authorizationKeys[0] !== 'Bearer') {
            throw new BadRequestHttpException("Authorization header value not valid!");
        }

        // @todo service.yaml içerisine alınacak.
        $tokenValidator = new TokenValidator();
        $tokenValidator->validate($authorizationKeys[1]);
    }

}
