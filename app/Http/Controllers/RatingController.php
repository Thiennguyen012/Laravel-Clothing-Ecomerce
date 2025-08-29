<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Services\Interfaces\IRatingService;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    protected $ratingService;
    public function __construct(IRatingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }

    public function newRating(Request $request)
    {
        // Lấy user_id nếu đã đăng nhập
        $user_id = Auth::check() ? Auth::id() : null;

        // Lấy hoặc tạo session_id cho guest
        $session_id = null;
        if (!$user_id) {
            // Nếu chưa có session cart, tạo mới
            if (!$request->session()->has('cart_session_id')) {
                $session_id = 'cart_' . uniqid() . '_' . time();
                $request->session()->put('cart_session_id', $session_id);
            } else {
                $session_id = $request->session()->get('cart_session_id');
            }
        }
        // $auth = $this->isAuth($request);
        // $user_id = $auth['user_id'];
        // $session_id = $auth['session_id'];
        // dd($user_id);
        $newRating =  $this->ratingService->newRating($user_id, $session_id, $request);
        if ($newRating) {
            return response()->json([
                'success' => true,
                'message' => 'Đã gửi đánh giá thành công',
                'rating' => $newRating,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Gửi đánh giá thất bại, vui lòng thử lại',
        ]);
    }
}
