<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Validator;

use App\Core\Infrastructure\Exception\InvalidJsonDataException;
use App\Core\Infrastructure\Serializer\JsonSerializer;
use App\Core\Infrastructure\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Throwable;

readonly class RequestValidator implements RequestValidatorInterface
{
    private SerializerInterface $serializer;

    public function __construct(
        private ValidatorInterface $validator,
    ) {
        $this->serializer = new JsonSerializer();
    }

    public function getRequestBodyContent(Request $request, string $className): object
    {
        $bodyContent = $request->getContent();

        try {
            $query = $this->serializer->deserialize($bodyContent, $className);
        } catch (Throwable $e) {
            throw new InvalidJsonDataException('Error', null, [$e->getMessage()]);
        }

        if ($query instanceof $className) {
            $validationErrors = $this->validator->validate($query);
            if ($validationErrors->count() > 0) {
                throw new InvalidJsonDataException('Error', $validationErrors);
            }

            return $query;
        }

        throw new InvalidJsonDataException('Error');
    }
}
