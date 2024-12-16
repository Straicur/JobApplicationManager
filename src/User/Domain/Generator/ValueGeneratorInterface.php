<?php

namespace App\User\Domain\Generator;

interface ValueGeneratorInterface
{
    public function generate(): string|int|array|object|float|bool|null;
}
