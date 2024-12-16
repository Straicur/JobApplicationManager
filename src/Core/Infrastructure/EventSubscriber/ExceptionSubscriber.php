<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\EventSubscriber;

use App\Core\Infrastructure\Exception\DataNotFoundException;
use App\Core\Infrastructure\Exception\ResponseExceptionInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

readonly class ExceptionSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private LoggerInterface $responseLogger,
    ) {
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof ResponseExceptionInterface) {
            $loggingContext = [
                'statusCode' => $exception->getResponse()->getStatusCode(),
                'file' => '[' . $exception->getLine() . '](' . $exception->getFile() . ')',
                'responseData' => json_decode($exception->getResponse()->getContent(), true),
            ];

            $this->responseLogger->error('ResponseException', $loggingContext);

            $event->setResponse($exception->getResponse());
        } else {
            $this->responseLogger->critical('ResponseException', ['class' => $exception::class,
                                                                  'data'  => $exception]);

            $loggingContext = [
                'message' => $exception->getMessage(),
                'file'    => '[' . $exception->getLine() . '](' . $exception->getFile() . ')',
            ];

            switch ($exception::class) {
                case NotFoundHttpException::class:
                {
                    $notFoundException = new DataNotFoundException([$exception->getMessage()]);

                    $this->responseLogger->error('NotFoundHttpException', $loggingContext);
                    $event->setResponse($notFoundException->getResponse());
                    break;
                }
            }
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
}
