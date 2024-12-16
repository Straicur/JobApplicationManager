<?php

namespace App\Core\Infrastructure\Tool;

use App\Core\Infrastructure\Model\ModelInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

interface ResponseToolInterface
{
    public static function getResponse(?ModelInterface $responseModel = null, int $httpCode = Response::HTTP_OK): Response;

    public static function getBinaryFileResponse($fileDir, $delete = false): BinaryFileResponse;
}