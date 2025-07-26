<?php

namespace App\Repository;

use App\Models\User;
use App\Repository\Interfaces\IUserRepository;

class UserRepository extends BaseRepository implements IUserRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(User $user)
    {
        parent::__construct($user);
    }
    public function newUser(array $data = [])
    {
        return $this->model->create($data);
    }
}
