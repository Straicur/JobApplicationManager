<?php

namespace App\Core\Infrastructure\Validator;

use Symfony\Component\HttpFoundation\Request;

interface RequestValidatorInterface
{
    public function getRequestBodyContent(Request $request, string $className): object;
}
