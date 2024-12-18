<?php

declare(strict_types=1);

namespace App\User\Domain\Message;

use App\Core\Domain\Entity\User;

final class RegisterEmailMessage
{
    public function __construct(private User $user)
    {
    }

    public function getUser(): string
    {
        return $this->user->getUsername();
    }
}