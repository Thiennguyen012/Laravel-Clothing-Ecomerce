<?php

namespace App\Services\interfaces;

interface ICartService
{
    public function addToCart($user_id = null, $session_id = null, $variant_id, $quantity, $price);
    public function deleteItem($user_id = null, $session_id = null, $variant_id);
    public function deleteCart($user_id = null, $session_id = null);
    public function updateCart($user_id = null, $session_id = null, $variant_id, $quantity);
    public function getCart($user_id = null, $session_id = null);
    public function getCartCount($user_id = null, $session_id = null);
    public function hasVariantInCart($user_id = null, $session_id = null, $variant_id);
    public function changeVariant($user_id = null, $session_id = null, $old_variant_id, $new_variant_id, $quantity);
}
