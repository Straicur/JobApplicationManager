<?php

declare(strict_types=1);

namespace App\User\Application\Service;

use App\Core\Domain\Entity\User;
use App\Core\Infrastructure\Exception\DataNotFoundException;
use App\User\Domain\Generator\PasswordHashGenerator;
use App\User\Domain\Message\RegisterEmailMessage;
use Psr\Log\LoggerInterface;
use SensitiveParameter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

readonly class UserRegisterService implements UserRegisterServiceInterface
{
    public function __construct(
        private UserInformationRepository    $userInformationRepository,
        private UserRepository               $userRepository,
        private LoggerInterface              $endpointLogger,
        private MailerInterface              $mailer,
        private UserPasswordRepository       $userPasswordRepository,
        private TranslateServiceInterface    $translateService,
        private MessageBusInterface $bus
    ) {
    }

    public function checkIfUserExists(RegisterQuery $registerQuery, Request $request): void
    {
        $existingEmail = $this->userInformationRepository->findOneBy([
            'email' => $registerQuery->getEmail(),
        ]);

        if ($existingEmail !== null) {
            $this->endpointLogger->error('Email already exists');
            $this->translateService->setPreferredLanguage($request);
            throw new DataNotFoundException([$this->translateService->getTranslation('EmailExists')]);
        }

        $existingPhone = $this->userInformationRepository->findOneBy([
            'phoneNumber' => $registerQuery->getPhoneNumber(),
        ]);

        if ($existingPhone !== null) {
            $this->endpointLogger->error('Phone number already exists');
            $this->translateService->setPreferredLanguage($request);
            throw new DataNotFoundException([$this->translateService->getTranslation('PhoneNumberExists')]);
        }
    }

    public function createUser(#[SensitiveParameter] string $password): User
    {
        $newUser = new User();
        $passwordGenerator = new PasswordHashGenerator($newPassword);

        return $newUser;
    }

    public function sendMail(User $newUser): void
    {
        $message = new RegisterEmailMessage($newUser);
        $this->bus->dispatch($message);
    }
}
