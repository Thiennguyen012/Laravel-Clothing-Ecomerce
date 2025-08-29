<?php

namespace App\Services;

use App\Repository\Interfaces\IRatingRepository;
use App\Services\Interfaces\IRatingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RatingService implements IRatingService
{
    protected $ratingRepository;
    public function __construct(IRatingRepository $ratingRepository)
    {
        $this->ratingRepository = $ratingRepository;
    }

    public function getRating($variant_id){
        return $this->ratingRepository->find(['variant_id' => $variant_id]);
    }

    public function newRating($user_id = null, $session_id = null, Request $request){
        if($user_id){
           $user = DB::table('users')->where('id', $user_id)->first();
           $name = $user->name;
        }
        $data = [
            'variant_id' => $request->input('variant_id'),
            'user_id' => $request->input('user_id'),
            'session_id' => $session_id,
            'star' => $request->input('star'),
            'comment' => $request->input('comment'),
            'reviewer_name' => ($user_id) ? $name : $request->input('reviewer_name'),
        ];
        
        return $this->ratingRepository->create($data);
    }

    public function updateRating($rating_id, $user_id, array $data){
        if($user_id){
            return $this->ratingRepository->update($rating_id, $data);
        }
        return null;
    }

    public function deleteRating($rating_id, $user_id){
        if($user_id){
            return $this->ratingRepository->delete($rating_id);
        }
        return null;
    }
}
