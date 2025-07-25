<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\ICartService;
use App\Services\Interfaces\IOrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected $cartService;
    protected $orderService;
    public function __construct(ICartService $cartService, IOrderService $orderService)
    {
        $this->cartService = $cartService;
        $this->orderService = $orderService;
    }

    public function getOrderList(Request $request)
    {
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


        $cart = $this->cartService->getCart($user_id, $session_id);
        return view('checkout', compact('cart'));
    }

    public function placeOrder(Request $request)
    {
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

        $customer_name = $request->input('customer_name');
        $customer_email = $request->input('customer_email');
        $customer_phone = $request->input('customer_phone');
        $shipping_address = $request->input('shipping_address');
        $note = $request->input('note');

        $order = $this->orderService->checkout($user_id, $session_id, $customer_name, $customer_email, $customer_phone, $shipping_address, $note);
        return view('checkout', compact('order'));
    }
}
