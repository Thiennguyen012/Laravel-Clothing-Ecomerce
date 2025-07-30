<?php

namespace App\Services;

use App\Repository\UserRepository;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class UserService
{
    protected $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function userFilter(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $sort = $request->input('sort');
        $direction = $request->input('direction');
        $result = $this->userRepository->userFilter($name, $email, $sort, $direction);
        return $result;
    }
    public function getUserWithOrderById($user_id)
    {
        $result = $this->userRepository->getUserWithOrderById($user_id);
        return $result;
    }
    public function updateUser(Request $request, $user_id)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $result = $this->userRepository->updateUser($user_id, $name, $email);
        return $result;
    }
    public function updateUserPassword(Request $request, $user_id)
    {
        $password = $request->input('password');
        $result = $this->userRepository->updateUserPassword($user_id, $password);
        return $result;
    }
    public function deleteUser($user_id)
    {
        return $this->userRepository->deleteUser($user_id);
    }
}
