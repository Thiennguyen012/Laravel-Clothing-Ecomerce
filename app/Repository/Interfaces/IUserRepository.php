<?php

namespace App\Repository\Interfaces;

interface IUserRepository extends IBaseRepository
{
    public function newUser(array $data = []);
    public function userFilter($name = null, $email = null, $sort = null, $direction = null);
    public function getUserWithOrderById($user_id);
    public function updateUser($user_id, $name, $email);
    public function updateUserPassword($user_id, $password);
    public function deleteUser($user_id);
}
