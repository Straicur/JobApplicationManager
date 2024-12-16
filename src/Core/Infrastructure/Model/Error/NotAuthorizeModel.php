<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Model\Error;

use App\Core\Infrastructure\Model\ModelInterface;

class NotAuthorizeModel implements ModelInterface
{
    private string $error = 'User not authorized';

    private string $description = 'Authorization token could be NULL, invalid or expired';

    public function __construct()
    {
    }

    public function getError(): string
    {
        return $this->error;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
