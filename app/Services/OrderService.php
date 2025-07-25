<?php

namespace App\Services;

use App\Repository\Interfaces\ICartRepository;
use App\Repository\Interfaces\IOrderItemRepository;
use App\Repository\Interfaces\IOrderRepository;
use App\Repository\Interfaces\IVariantRepository;
use App\Services\Interfaces\IOrderService;
use Illuminate\Support\Facades\DB;

class OrderService implements IOrderService
{
    protected $orderRepository;
    protected $orderItemRepository;
    protected $cartRepository;
    protected $variantRepository;
    public function __construct(IOrderRepository $orderRepository, IOrderItemRepository $orderItemRepository, ICartRepository $cartRepository, IVariantRepository $variantRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->orderItemRepository = $orderItemRepository;
        $this->cartRepository = $cartRepository;
        $this->variantRepository = $variantRepository;
    }
    public function checkout($user_id = null, $session_id = null, $customer_name, $customer_email, $customer_phone, $shipping_address, $note = null)
    {

        // Lấy ra giỏ hàng của người dùng hiện tại
        $cart = $this->cartRepository->getCartWithVariantAndProduct($user_id, $session_id);
        // dd($cart);

        // Tính tổng tiền hàng (subtotal)
        $subtotal = $cart->sum(function ($item) {
            return $item->variant->price * $item->quantity;
        });
        // dd($subtotal);
        // Phí vận chuyển (có thể thay đổi logic tính phí nếu cần)
        $shipping_fee = 0;
        // Tổng thanh toán
        $total = $subtotal + $shipping_fee;

        // Chuẩn bị dữ liệu order
        $orderData = [
            'user_id' => $user_id,
            'session_id' => $session_id,
            'customer_name' => $customer_name,
            'customer_email' => $customer_email,
            'customer_phone' => $customer_phone,
            'shipping_address' => $shipping_address,
            'subtotal' => $subtotal,
            'shipping_fee' => $shipping_fee,
            'total' => $total,
            'notes' => $note,
        ];

        // mapping cart với array cartItems, sau đó lưu cartItems vào bảng cart_items
        $cartItems = $cart->map(function ($item) {
            return [
                'variant_id'    => $item->variant_id,
                'product_name'  => $item->variant->product->product_name ?? null,
                'variant_sku'   => $item->variant->sku ?? null,
                'color'         => $item->variant->color ?? null,
                'size'          => $item->variant->size ?? null,
                'product_image' => $item->variant->images ?? null,
                'quantity'      => $item->quantity,
                'unit_price'    => $item->variant->price,
                'total_price'   => $item->variant->price * $item->quantity,
            ];
        })->toArray();
        // dd($cartItems);
        return DB::transaction(function () use ($orderData, $cartItems, $user_id, $session_id) {
            $order = $this->orderRepository->newOrder($orderData);
            foreach ($cartItems as $item) {
                $item['order_id'] = $order->id;
                $this->orderItemRepository->newOrderItem($item);
                // xử lý trừ kho
                $variant_id = $item['variant_id'];
                $quantity = $item['quantity'];
                $this->variantRepository->decreaseStock($variant_id, $quantity);
            }
            // Xử lý thêm: trừ kho, gửi mail, xóa cart...
            // xử lý xóa cart
            $this->cartRepository->deleteCart($user_id, $session_id);


            return $order;
        });
    }
}
