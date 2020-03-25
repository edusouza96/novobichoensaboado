<?php

namespace BichoEnsaboado\Services;

use Illuminate\Support\Facades\Hash;
use BichoEnsaboado\Repositories\UserRepository;

class AuthenticateAcessAdmin
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function validate(array $attributes)
    {
        $user = $this->userRepository->findByNickname($attributes['username']);

        if($user && $user->canSeeAdministrativePage())
            return Hash::check($attributes['password'], $user->getPassword());

        return false;
    }
}