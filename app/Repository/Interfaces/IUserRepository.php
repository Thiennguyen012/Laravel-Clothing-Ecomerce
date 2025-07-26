<?php

namespace App\Repository\Interfaces;

interface IUserRepository extends IBaseRepository
{
    public function newUser(array $data = []);
}
