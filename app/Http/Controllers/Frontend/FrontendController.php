<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use App\Models\Condition;
use Illuminate\Support\Facades\DB;


class FrontendController extends Controller
{
    public function aboutPage(){
        return view('frontend.pages.about-us');
    }

    public function blogPage(){
        return view('frontend.pages.blog');
    }
    public function contactPage(){
        return view('frontend.pages.contact');
    }
    public function sellerPage(){
        $datalist = DB::table('sellers')
			->join('user_status', 'sellers.status', '=', 'user_status.id')
			->join('Shops', 'user_status.id', '=', 'Shops.is_publish')
			->select('sellers.*', 'Shops.name as shopName', 'user_status.status as user_status')
			->where('sellers.status', 1)
			->orderBy('sellers.id','desc')
			->paginate(20);
        return view('frontend.pages.seller', compact('datalist'));
    }
    public function productPage(){
        return view('frontend.pages.product');
    }
    public function productDetailPage(){
        return view('frontend.pages.product-detail');
    }  
    public function condition(){
        $conditions = Condition::where('is_publish', '=', 1)->orderBy('id', 'desc')->limit(9)->get();
        return view('frontend.pages.condition',compact('conditions'));
    }
    public function client(){
        $testimonials = Testimonial::where('is_publish', '=', 1)->orderBy('id', 'desc')->get();
        return view('frontend.pages.client',compact('testimonials'));
    }
    
}
