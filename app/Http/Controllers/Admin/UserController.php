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

    public function showUpdateUser($user_id)
    {
        $user = $this->userService->getUserWithOrderById($user_id);
        return view('Admin.adminUpdateUser', compact('user'));
    }
    public function updateUser(Request $request, $user_id)
    {
        $this->userService->updateUser($request, $user_id);
        return redirect()->back()->with('success', 'Cập nhật thông tin tài khoản thành công!');
    }
    public function updateUserPassword(Request $request, $user_id)
    {
        $this->userService->updateUserPassword($request, $user_id);
        return redirect()->back()->with('success_password', 'Cập nhật mật khẩu tài khoản thành công!');
    }
    public function showNewUser()
    {
        return view('Admin.adminNewUser');
    }
    public function newUser(Request $request)
    {
        $newUser = $this->userService->newUser($request);
        if($newUser === false){
            return redirect()->back()->withInput()->with('error', 'Email đã tồn tại!');
        }
        return redirect()->back()->with('success', 'Tạo tài khoản mới thành công!');
    }
}
