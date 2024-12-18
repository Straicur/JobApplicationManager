<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Controller;

use App\User\Domain\Message\RegisterEmailMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

#[OA\Tag(name: 'Sample')]
final class SampleController extends AbstractController
{
    #[Route('/api/examlpe', name: 'examlpe', methods: ['GET'])]
    #[OA\Get(
        description: 'Method get all notifications from the system for logged user',
        requestBody: new OA\RequestBody(
        ),
        responses  : [
            new OA\Response(
                response   : 200,
                description: 'Success',
            ),
        ]
    )]
    public function examlpe(MessageBusInterface $bus): Response
    {
        $message = new RegisterEmailMessage('content');
        $bus->dispatch($message);

        return new Response(sprintf('XZDSAD with content %s was published', $message->getContent()));
    }
}