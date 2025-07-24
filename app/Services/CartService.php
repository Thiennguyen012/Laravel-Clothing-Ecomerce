<?php

namespace App\Services;

use App\Repository\CartRepository;
use App\Services\interfaces\ICartService;

class CartService implements ICartService
{
    protected $cartRepository;
    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }
    public function addToCart($user_id = null, $session_id = null, $variant_id, $quantity, $price)
    {
        // Validate input
        if (!$user_id && !$session_id) {
            return null;
        }

        if ($quantity <= 0) {
            return null;
        }

        $result = $this->cartRepository->addToCart($user_id, $session_id, $variant_id, $quantity, $price);
        return $result;
    }
    public function deleteItem($user_id = null, $session_id = null, $variant_id)
    {
        // Validate input
        if (!$user_id && !$session_id) {
            return 0;
        }

        if (!$variant_id) {
            return 0;
        }

        $result = $this->cartRepository->deleteItem($user_id, $session_id, $variant_id);
        return $result;
    }
    public function deleteCart($user_id = null, $session_id = null)
    {
        // Validate input
        if (!$user_id && !$session_id) {
            return 0;
        }

        $result = $this->cartRepository->deleteCart($user_id, $session_id);
        return $result;
    }
    public function updateCart($user_id = null, $session_id = null, $variant_id, $quantity)
    {
        // Validate input
        if (!$user_id && !$session_id) {
            return 0;
        }

        if (!$variant_id || $quantity <= 0) {
            return 0;
        }

        $result = $this->cartRepository->updateQuantity($user_id, $session_id, $variant_id, $quantity);
        return $result;
    }

    public function getCart($user_id = null, $session_id = null)
    {
        // Validate input
        if (!$user_id && !$session_id) {
            return collect();
        }

        $cart = $this->cartRepository->getCart($user_id, $session_id);
        return $cart;
    }

    public function getCartCount($user_id = null, $session_id = null)
    {
        // Validate input
        if (!$user_id && !$session_id) {
            return 0;
        }

        $count = $this->cartRepository->getCartCount($user_id, $session_id);
        return $count;
    }

    public function hasVariantInCart($user_id = null, $session_id = null, $variant_id)
    {
        // Validate input
        if (!$user_id && !$session_id) {
            return false;
        }

        if (!$variant_id) {
            return false;
        }

        $exists = $this->cartRepository->hasVariantInCart($user_id, $session_id, $variant_id);
        return $exists;
    }

    public function changeVariant($user_id = null, $session_id = null, $old_variant_id, $new_variant_id, $quantity)
    {
        // Validate input
        if (!$user_id && !$session_id) {
            return 0;
        }

        if (!$old_variant_id || !$new_variant_id || $quantity <= 0) {
            return 0;
        }

        $result = $this->cartRepository->changeVariant($user_id, $session_id, $old_variant_id, $new_variant_id, $quantity);
        return $result;
    }

    public function clearExpiredSessions()
    {
        // Helper method để clear expired cart sessions
        // Có thể implement sau nếu cần
        return true;
    }

    public function mergeGuestCartToUser($session_id, $user_id)
    {
        // Helper method để merge guest cart vào user cart khi login
        if (!$session_id || !$user_id) {
            return false;
        }

        try {
            // Get guest cart
            $guestCart = $this->cartRepository->getCart(null, $session_id);

            if ($guestCart->isEmpty()) {
                return true;
            }

            // Move each item to user cart
            foreach ($guestCart as $item) {
                // Check if user already has this variant
                if ($this->cartRepository->hasVariantInCart($user_id, null, $item->variant_id)) {
                    // Update existing quantity
                    $existingItem = $this->cartRepository->findOne([
                        'user_id' => $user_id,
                        'variant_id' => $item->variant_id
                    ]);
                    if ($existingItem) {
                        $existingItem->update([
                            'quantity' => $existingItem->quantity + $item->quantity
                        ]);
                    }
                } else {
                    // Create new item for user
                    $this->cartRepository->addToCart(
                        $user_id,
                        null,
                        $item->variant_id,
                        $item->quantity,
                        $item->price
                    );
                }

                // Delete guest item
                $item->delete();
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
