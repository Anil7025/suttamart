<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Team;

class TeamsController extends Controller
{
    public function team(){
        $teams = Team::where('is_publish', '=', 1)->orderBy('id','desc')->limit(6)->get();
        return view('frontend.pages.team', compact('teams'));
    }
}
