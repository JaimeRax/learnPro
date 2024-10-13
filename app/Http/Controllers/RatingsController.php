<?php

namespace App\Http\Controllers;

use App\Models\Ratings;
use Illuminate\Http\Request;

class RatingsController extends Controller
{
    public function listRatings(){

        return view('ratings.listRatings');
    }
}
