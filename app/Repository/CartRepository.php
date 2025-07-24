<?php

namespace App\Repository;

use App\Models\Cart;
use App\Repository\Interfaces\ICartRepository;
use Illuminate\Support\Facades\DB;

class CartRepository extends BaseRepository implements ICartRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(Cart $cart)
    {
        parent::__construct($cart);
    }
    public function addToCart($user_id = null, $session_id = null, $variant_id, $quantity, $price)
    {
        // Validate input
        if (!$user_id && !$session_id) {
            return null;
        }

        // Check if variant already exists in cart
        if ($this->hasVariantInCart($user_id, $session_id, $variant_id)) {
            // Update existing quantity
            if ($user_id) {
                $existing_item = $this->findOne(['user_id' => $user_id, 'variant_id' => $variant_id]);
            } else {
                $existing_item = $this->findOne(['session_id' => $session_id, 'variant_id' => $variant_id]);
            }

            if ($existing_item) {
                $existing_item->update([
                    'quantity' => $existing_item->quantity + $quantity
                ]);
                return $existing_item;
            }
        }

        // Create new cart item
        $attributes = [
            'user_id' => $user_id,
            'session_id' => $session_id,
            'variant_id' => $variant_id,
            'quantity' => $quantity,
            'price' => $price
        ];

        $result = $this->model->create($attributes);
        return $result;
    }
    public function deleteItem($user_id = null, $session_id = null, $variant_id)
    {
        // Validate input - cần có ít nhất user_id hoặc session_id
        if (!$user_id && !$session_id) {
            return 0;
        }

        // Build conditions để tìm đúng item của user/session
        if ($user_id) {
            $item = $this->findOne(['user_id' => $user_id, 'variant_id' => $variant_id]);
        } else {
            $item = $this->findOne(['session_id' => $session_id, 'variant_id' => $variant_id]);
        }

        if ($item) {
            $item->delete();
            return 1;
        }

        return 0;
    }
    public function deleteCart($user_id = null, $session_id = null)
    {
        // Validate input
        if (!$user_id && !$session_id) {
            return 0;
        }

        if ($user_id) {
            $items = $this->find(['user_id' => $user_id]);
            if ($items->count() > 0) {
                // Xóa từng item
                foreach ($items as $item) {
                    $item->delete();
                }
                return 1;
            }
        }

        if ($session_id) {
            $items = $this->find(['session_id' => $session_id]);
            if ($items->count() > 0) {
                // Xóa từng item
                foreach ($items as $item) {
                    $item->delete();
                }
                return 1;
            }
        }

        return 0;
    }
    public function updateQuantity($user_id = null, $session_id = null, $variant_id, $quantity)
    {
        // Validate input
        if (!$user_id && !$session_id) {
            return 0;
        }

        if ($quantity <= 0) {
            return 0;
        }

        if ($user_id) {
            $item = $this->findOne(['user_id' => $user_id, 'variant_id' => $variant_id]);
            if ($item) {
                $item->update(['quantity' => $quantity]);
                return 1;
            }
        }

        if ($session_id) {
            $item = $this->findOne(['session_id' => $session_id, 'variant_id' => $variant_id]);
            if ($item) {
                $item->update(['quantity' => $quantity]);
                return 1;
            }
        }

        return 0;
    }
    public function getCart($user_id = null, $session_id = null)
    {
        // Validate input
        if (!$user_id && !$session_id) {
            return collect(); // Return empty collection
        }

        if ($user_id) {
            return $this->find(['user_id' => $user_id]);
        }

        if ($session_id) {
            return $this->find(['session_id' => $session_id]);
        }

        return collect(); // Return empty collection
    }
    public function getCartCount($user_id = null, $session_id = null)
    {
        // Validate input
        if (!$user_id && !$session_id) {
            return 0;
        }

        if ($user_id) {
            $items = $this->find(['user_id' => $user_id]);
            return $items->count();
        }

        if ($session_id) {
            $items = $this->find(['session_id' => $session_id]);
            return $items->count();
        }

        return 0;
    }

    public function hasVariantInCart($user_id = null, $session_id = null, $variant_id)
    {
        // Validate input
        if (!$user_id && !$session_id) {
            return false;
        }

        if ($user_id) {
            $item = $this->findOne(['user_id' => $user_id, 'variant_id' => $variant_id]);
            return $item ? true : false;
        }

        if ($session_id) {
            $item = $this->findOne(['session_id' => $session_id, 'variant_id' => $variant_id]);
            return $item ? true : false;
        }

        return false;
    }

    public function changeVariant($user_id = null, $session_id = null, $old_variant_id, $new_variant_id, $quantity)
    {
        // Validate input parameters
        if ((!$user_id && !$session_id) || !$old_variant_id || !$new_variant_id || $quantity <= 0) {
            return 0;
        }

        // Build query conditions
        $query = $this->model->where('variant_id', $old_variant_id);

        if ($user_id) {
            $query->where('user_id', $user_id);
        } else {
            $query->where('session_id', $session_id);
        }

        // Find the old item in cart
        $old_item = $query->first();

        if (!$old_item) {
            return 0; // Old item not found in cart
        }

        // Start database transaction
        DB::beginTransaction();

        try {
            // Step 1: Delete old variant from cart
            $old_item->delete();

            // Step 2: Check if new variant already exists in cart
            $existing_query = $this->model->where('variant_id', $new_variant_id);

            if ($user_id) {
                $existing_query->where('user_id', $user_id);
            } else {
                $existing_query->where('session_id', $session_id);
            }

            $existing_item = $existing_query->first();

            if ($existing_item) {
                // If new variant exists, update quantity (merge)
                $existing_item->update([
                    'quantity' => $existing_item->quantity + $quantity
                ]);
            } else {
                // If new variant doesn't exist, create new item
                $this->model->create([
                    'user_id' => $user_id,
                    'session_id' => $session_id,
                    'variant_id' => $new_variant_id,
                    'quantity' => $quantity,
                    'price' => $old_item->price // Keep same price or you might want to get new variant price
                ]);
            }

            DB::commit();
            return 1; // Success

        } catch (\Exception $e) {
            DB::rollback();
            return 0; // Failed
        }
    }
}
