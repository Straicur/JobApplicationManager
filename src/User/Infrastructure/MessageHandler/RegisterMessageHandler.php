<?php

declare(strict_types=1);

namespace App\User\Infrastructure\MessageHandler;

use App\User\Application\MessageHandler\RegisterMessageHandlerInterface;
use App\User\Domain\Message\RegisterEmailMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class RegisterMessageHandler implements RegisterMessageHandlerInterface
{
    public function __invoke(RegisterEmailMessage $message): void
    {
        // magically invoked when an instance of SampleMessage is dispatched

        //        if ($_ENV['APP_ENV'] !== 'test') {
//            $email = (new TemplatedEmail())
//                ->from($_ENV['INSTITUTION_EMAIL'])
//                ->to($newUser->getUserInformation()->getEmail())
//                ->subject($this->translateService->getTranslation('AccountActivationCodeSubject'))
//                ->htmlTemplate('emails/register.html.twig')
//                ->context([
//                    'userName'  => $newUser->getUserInformation()->getFirstname() . ' ' . $newUser->getUserInformation()->getLastname(),
//                    'code'      => $registerCode,
//                    'userEmail' => $newUser->getUserInformation()->getEmail(),
//                    'url'       => $_ENV['BACKEND_URL'],
//                    'lang'      => $request->getPreferredLanguage() !== null ? $request->getPreferredLanguage() : $this->translateService->getLocate(),
//                ]);
//
//            $this->mailer->send($email);
//        }

        print_r('Handler handled the message!');
    }
}