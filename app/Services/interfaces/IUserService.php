<?php

namespace App\Services\Interfaces;
use Illuminate\Http\Request;

interface IUserService
{
    public function userFilter(Request $request);
}
