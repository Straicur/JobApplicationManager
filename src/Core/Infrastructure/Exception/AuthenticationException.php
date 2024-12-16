<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Exception;

use App\Core\Infrastructure\Model\Error\NotAuthorizeModel;
use App\Core\Infrastructure\Tool\ResponseTool;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationException extends Exception implements ResponseExceptionInterface
{
    public function getResponse(): Response
    {
        return ResponseTool::getResponse(new NotAuthorizeModel(), Response::HTTP_UNAUTHORIZED);
    }
}
