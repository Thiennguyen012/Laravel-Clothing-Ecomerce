<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    protected $cartService;
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }
    public function showCart(Request $request)
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

        // Lấy cart items từ service
        $cartItems = $this->cartService->getCart($user_id, $session_id);
        $cartCount = $this->cartService->getCartCount($user_id, $session_id);

        // Tính tổng tiền
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item->quantity * $item->price;
        }

        return view('cart', compact('cartItems', 'cartCount', 'total', 'user_id', 'session_id'));
    }

    public function getCartCount(Request $request)
    {
        try {
            // Lấy user_id nếu đã đăng nhập
            $user_id = Auth::check() ? Auth::id() : null;

            // Lấy session_id cho guest
            $session_id = null;
            if (!$user_id) {
                $session_id = $request->session()->get('cart_session_id');
            }

            // Lấy cart count từ service
            $count = $this->cartService->getCartCount($user_id, $session_id);

            return response()->json([
                'success' => true,
                'count' => $count
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể lấy thông tin giỏ hàng'
            ], 500);
        }
    }

    public function addToCart(Request $request)
    {
        // Validate request
        $request->validate([
            'variant_id' => 'required|integer|exists:variants,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0'
        ]);

        // Lấy user_id hoặc session_id
        $user_id = Auth::check() ? Auth::id() : null;
        $session_id = null;

        if (!$user_id) {
            if (!$request->session()->has('cart_session_id')) {
                $session_id = 'cart_' . uniqid() . '_' . time();
                $request->session()->put('cart_session_id', $session_id);
            } else {
                $session_id = $request->session()->get('cart_session_id');
            }
        }

        // Thêm vào cart
        $result = $this->cartService->addToCart(
            $user_id,
            $session_id,
            $request->variant_id,
            $request->quantity,
            $request->price
        );

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Đã thêm sản phẩm vào giỏ hàng',
                'cart_count' => $this->cartService->getCartCount($user_id, $session_id)
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Không thể thêm sản phẩm vào giỏ hàng'
        ], 400);
    }

    public function updateCart(Request $request)
    {
        // Validate request
        $request->validate([
            'variant_id' => 'required|integer',
            'quantity' => 'required|integer|min:1'
        ]);

        $user_id = Auth::check() ? Auth::id() : null;
        $session_id = !$user_id ? $request->session()->get('cart_session_id') : null;

        $result = $this->cartService->updateCart(
            $user_id,
            $session_id,
            $request->variant_id,
            $request->quantity
        );

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Đã cập nhật giỏ hàng'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Không thể cập nhật giỏ hàng'
        ], 400);
    }

    public function removeItem(Request $request)
    {
        // Validate request
        $request->validate([
            'variant_id' => 'required|integer'
        ]);

        $user_id = Auth::check() ? Auth::id() : null;
        $session_id = !$user_id ? $request->session()->get('cart_session_id') : null;

        $result = $this->cartService->deleteItem(
            $user_id,
            $session_id,
            $request->variant_id
        );

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Đã xóa sản phẩm khỏi giỏ hàng',
                'cart_count' => $this->cartService->getCartCount($user_id, $session_id)
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Không thể xóa sản phẩm'
        ], 400);
    }

    public function clearCart(Request $request)
    {
        $user_id = Auth::check() ? Auth::id() : null;
        $session_id = !$user_id ? $request->session()->get('cart_session_id') : null;

        $result = $this->cartService->deleteCart($user_id, $session_id);

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Đã xóa toàn bộ giỏ hàng'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Không thể xóa giỏ hàng'
        ], 400);
    }
}
