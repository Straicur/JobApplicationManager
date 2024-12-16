<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Exception;

use Symfony\Component\HttpFoundation\Response;

interface ResponseExceptionInterface
{
    public function getResponse(): Response;
}
