<?php

namespace App\Repository\Interfaces;

use Illuminate\Http\Client\Request;

interface ICartRepository extends IBaseRepository
{
    // Thêm sản phẩm vào giỏ hàng
    public function addToCart($user_id = null, $session_id = null, $variant_id, $quantity, $price);

    // Xóa 1 item cụ thể khỏi cart
    public function deleteItem($user_id = null, $session_id = null, $variant_id);

    // Xóa toàn bộ cart
    public function deleteCart($user_id = null, $session_id = null);

    // Cập nhật số lượng của variant trong cart
    public function updateQuantity($user_id = null, $session_id = null, $variant_id, $quantity);

    // Lấy danh sách cart
    public function getCart($user_id = null, $session_id = null);

    // Đếm số lượng items trong cart
    public function getCartCount($user_id = null, $session_id = null);

    // Thay đổi variant (khi đổi màu/size)
    public function changeVariant($user_id = null, $session_id = null, $old_variant_id, $new_variant_id, $quantity);
}
