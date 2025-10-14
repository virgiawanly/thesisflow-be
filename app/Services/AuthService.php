<?php

namespace App\Services;

use App\Exceptions\InvalidCredentialsException;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * Create a new service instance.
     *
     * @param \App\Repositories\UserRepository $userRepository
     * @return void
     */
    public function __construct(protected UserRepository $userRepository) {}

    /**
     * Basic login user using username and password.
     *
     * @param array $data
     * @return \App\Models\User
     */
    public function basicLogin(array $data)
    {
        $user = $this->userRepository->findUserByUsername($data['username']);

        if (empty($user) || !Hash::check($data['password'], $user->password)) {
            throw new InvalidCredentialsException();
        }

        return [
            'user' => $user,
            'token' => $user->createToken('appToken')->plainTextToken
        ];
    }
}
