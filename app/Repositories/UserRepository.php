<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseResourceRepository
{
    /**
     * Create a new repository instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new User();
    }

    /**
     * Find user by username.
     *
     * @param string $username
     * @return \App\Models\User|null
     */
    public function findUserByUsername(string $username): ?User
    {
        return $this->model->where('username', $username)->first();
    }

    /**
     * Find user by email.
     *
     * @param string $email
     * @return \App\Models\User|null
     */
    public function findUserByEmail(string $email): ?User
    {
        return $this->model->where('email', $email)->first();
    }

    /**
     * Find user by id.
     *
     * @param int $id
     * @return \App\Models\User|null
     */
    public function findUserById(int $id): ?User
    {
        return $this->model->where('id', $id)->first();
    }
}
