<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface IRatingService
{
    public function getRating($variant_id);
    public function newRating($user_id = null, $session_id = null, Request $request);
    public function updateRating($rating_id, $user_id, array $data);
    public function deleteRating($rating_id, $user_id);
}
