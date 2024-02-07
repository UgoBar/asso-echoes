<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener implements EventSubscriberInterface
{

    public static function getSubscribedEvents(): array
    {
        return [
            // Listen to 'kernel.exception' event
            'kernel.exception' => 'onKernelException',
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {

        $exception = $event->getThrowable();

        if ($exception instanceof HttpExceptionInterface && $event->getThrowable()->getStatusCode() === 404) {
            // Redirect user to route 'front_not_found'
            $response = new RedirectResponse('/not_found');
            $event->setResponse($response);
        }
    }
}
