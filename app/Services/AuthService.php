<?php

namespace App\Services;

use App\Enums\UserType;
use App\Exceptions\InvalidCredentialsException;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

        // If user is a student, sync student data from SIS to check the latest eligibility data
        if ($user->type === UserType::STUDENT->value) {
            try {
                $syncedStudent = SISIntegrationService::syncStudentWithSIS($user->student_id);
            } catch (ModelNotFoundException $e) {
                throw new InvalidCredentialsException();
            }

            $user['student'] = $syncedStudent;
        }

        return [
            'user' => $user,
            'token' => $user->createToken('appToken')->plainTextToken
        ];
    }

    /**
     * Get the authenticated user profile.
     *
     * @return \App\Models\User
     */
    public function getUserProfile(int $userId)
    {
        return $this->userRepository->findUserById($userId);
    }
}
