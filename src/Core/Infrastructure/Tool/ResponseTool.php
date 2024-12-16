<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Tool;

use App\Core\Infrastructure\Model\ModelInterface;
use App\Core\Infrastructure\Serializer\JsonSerializer;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class ResponseTool implements ResponseToolInterface
{
    public static function getResponse(?ModelInterface $responseModel = null, int $httpCode = Response::HTTP_OK): Response
    {
        $headers = [
            'Content-Type' => 'application/json',
        ];

        $serializeService = new JsonSerializer();

        $serializedObject = $responseModel !== null ? $serializeService->serialize($responseModel) : null;

        if ($serializedObject) {
            $headers['Content-Length'] = strlen($serializedObject);
        }

        return new Response($serializedObject, $httpCode, $headers);
    }

    public static function getBinaryFileResponse($fileDir, $delete = false): BinaryFileResponse
    {
        $response = new BinaryFileResponse($fileDir);

        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            basename($fileDir),
        );

        if ($delete) {
            $response->deleteFileAfterSend();
        }

        return $response;
    }
}
