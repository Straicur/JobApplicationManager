<?php

declare(strict_types=1);

namespace App\User\Application\MessageHandler;

use App\User\Domain\Message\ExamlpeMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class ExamlpeMessangeHandler implements MessageHandlerInterface
{
    public function __invoke(ExamlpeMessage $message): void
    {
        // magically invoked when an instance of SampleMessage is dispatched
        print_r('Handler handled the message!');
    }
}