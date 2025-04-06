<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Review;

class ReviewsController extends Controller
{
	
    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|integer',
            'user_id' => 'required|integer',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string'
        ]);
        DB::table('products')->where('id',$request->item_id)->update(['user_id'=>$request->user_id]);
        Review::create([
            'item_id' => $request->item_id,
            'user_id' => $request->user_id,
            'rating' => $request->rating,
            'comments' => $request->comment
        ]);

        return response()->json(['success' => 'Review submitted successfully!']);
    }

}
