<?php

namespace App\Repository;

use App\Models\Rating;
use App\Repository\Interfaces\IRatingRepository;

class RatingRepository extends BaseRepository implements IRatingRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(Rating $rating)
    {
        parent::__construct($rating);
    }
    
}
