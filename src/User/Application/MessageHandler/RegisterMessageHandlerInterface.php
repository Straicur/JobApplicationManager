<?php

declare(strict_types=1);

namespace App\User\Application\MessageHandler;

use App\User\Domain\Message\RegisterEmailMessage;

interface RegisterMessageHandlerInterface
{
    public function __invoke(RegisterEmailMessage $message): void;
}
