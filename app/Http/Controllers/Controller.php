<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

abstract class Controller
{
    public function isAuth(Request $request){
        // Lấy user_id nếu đã đăng nhập, nếu không thì null
        $user_id = Auth::check() ? Auth::id() : null;

        // Luôn ưu tiên lấy session_id đã có trong session (được tạo khi thêm vào giỏ hàng)
        $session_id = null;
        if ($user_id) {
            // Nếu đã đăng nhập, không cần session_id
            $session_id = null;
        } else {
            // Nếu chưa đăng nhập, lấy session_id từ session (nếu có)
            $session_id = $request->session()->get('cart_session_id');
        }

        return [
           'user_id' => $user_id,
           'session_id' => $session_id,
        ];
    }
}
