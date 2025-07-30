<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function showAll(Request $request)
    {
        $users = $this->userService->userFilter($request);
        return view('Admin.adminUsers', compact('users'));
    }
}
