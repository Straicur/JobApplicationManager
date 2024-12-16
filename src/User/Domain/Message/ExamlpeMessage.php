<?php

declare(strict_types=1);

namespace App\User\Domain\Message;

final class ExamlpeMessage
{
    public function __construct(private string $content)
    {
    }

    public function getContent(): string
    {
        return $this->content;
    }
}