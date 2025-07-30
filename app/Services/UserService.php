<?php

namespace App\Services;

use App\Repository\UserRepository;

use Illuminate\Http\Request;

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
}
