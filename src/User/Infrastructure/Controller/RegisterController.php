<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Controller;

use App\Core\Infrastructure\Exception\InvalidJsonDataException;
use App\Core\Infrastructure\Model\Error\DataNotFoundModel;
use App\Core\Infrastructure\Model\Error\JsonDataInvalidModel;
use App\Core\Infrastructure\Tool\ResponseTool;
use App\Core\Infrastructure\Validator\RequestValidatorInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[OA\Response(
    response   : 400,
    description: 'JSON Data Invalid',
    content    : new Model(type: JsonDataInvalidModel::class)
)]
#[OA\Response(
    response   : 404,
    description: 'Data not found',
    content    : new Model(type: DataNotFoundModel::class)
)]
#[OA\Tag(name: 'Register')]
#[Route('/api')]
final class RegisterController extends AbstractController
{
    #[Route('/register', name: 'apiRegister', methods: ['PUT'])]
    #[OA\Put(
        description: 'Method used to register user',
        security   : [],
        requestBody: new OA\RequestBody(
            required: true,
            content : new OA\JsonContent(
                ref : new Model(type: RegisterQuery::class),
                type: 'object',
            ),
        ),
        responses  : [
            new OA\Response(
                response   : 201,
                description: 'Success',
            ),
        ]
    )]
    public function register(
        MessageBusInterface          $bus,
        Request                      $request,
        RequestValidatorInterface    $requestServiceInterface,
        UserRegisterServiceInterface $registerService,
    ): Response {
        $registerQuery = $requestServiceInterface->getRequestBodyContent($request, RegisterQuery::class);

        if ($registerQuery instanceof RegisterQuery) {
            $registerService->checkExistingUsers($registerQuery, $request);
            $registerService->checkInstitutionLimits($request);

            $newUser = $registerService->createUser($registerQuery);

            $registerCode = $registerService->getRegisterCode($newUser);

            $registerService->sendMail($newUser, $registerCode, $request);

            return ResponseTool::getResponse(httpCode: Response::HTTP_CREATED);
        }

        throw new InvalidJsonDataException('Invalid JSON Data');
    }
}