<?php

namespace App\Repository\Interfaces;

interface IUserRepository extends IBaseRepository
{
    public function newUser(array $data = []);
    public function userFilter($name = null, $email = null, $sort = null, $direction = null);
}
