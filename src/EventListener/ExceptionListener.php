<?php


namespace App\EventListener;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Validator\Exception\ValidatorException;

// @todo bu class gözden geçirilecek.
class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        $response = new JsonResponse();

        if ($exception instanceof ValidatorException) {
            $response = new JsonResponse();
            $response->setStatusCode(400);
            $exceptionMessage = json_encode(
                ['type' => 'Validation Exception', 'fields' => json_decode($exception->getMessage(), true)]
            );
            $response->setContent($exceptionMessage);
        } else {
            $exceptionMessage = json_encode(
                ['type' => 'Exception', 'errorMessage' => $exception->getMessage()]
            );
            $response->setContent($exceptionMessage);
            if ($exception instanceof HttpExceptionInterface) {
                $response->setStatusCode($exception->getStatusCode());
            } else {
                $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }

        $event->setResponse($response);
    }
}
