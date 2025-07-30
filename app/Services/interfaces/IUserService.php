<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface IUserService
{
    public function userFilter(Request $request);
    public function getUserWithOrderById($user_id);
    public function updateUser(Request $request, $user_id);
    public function updateUserPassword(Request $request, $user_id);
    public function deleteUser($user_id);
    public function newUser(Request $request);
}
