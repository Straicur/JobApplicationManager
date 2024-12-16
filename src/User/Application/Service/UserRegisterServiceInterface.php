<?php

namespace App\User\Application\Service;

use App\Core\Domain\Entity\User;
use Symfony\Component\HttpFoundation\Request;

interface UserRegisterServiceInterface
{
    public function checkIfUserExists(RegisterQuery $registerQuery, Request $request): void;
    public function createUser(string $password): User;

    public function sendMail(User $newUser, string $registerCode, Request $request): void;
}