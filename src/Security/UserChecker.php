<?php

namespace App\Security;

use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{

    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user->isCuentaActivada()) {
            throw new CustomUserMessageAuthenticationException("Tu cuenta aún no ha sido activada");
        }
    }

    public function checkPostAuth(UserInterface $user): void
    {

    }
}
