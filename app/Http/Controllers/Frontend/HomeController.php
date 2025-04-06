<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Slider;
use App\Models\Pro_category;
use App\Models\Offer_ad;
use App\Models\Brand;
use App\Models\Testimonial;
use App\Models\Condition;
use App\Models\Product;

class HomeController extends Controller
{
    public function index(){
        //Slider
		$sliders = Slider::where('is_publish', '=', 1)->orderBy('id', 'desc')->limit(3)->get();
        //Product Category
        $pro_categores = DB::table('pro_categories')
        ->leftJoin('products', 'pro_categories.id', '=', 'products.category_ids')
        ->select('pro_categories.id','pro_categories.name','pro_categories.image','pro_categories.slug', DB::raw('COUNT(products.id) as product_count'))
        ->groupBy('pro_categories.id', 'pro_categories.name')
        ->where('pro_categories.is_publish', '=', 1)
        ->orderBy('pro_categories.id', 'desc')
        ->limit(10)
        ->get();
        //product
        $np_sql = "SELECT a.id, a.brand_id, a.title, a.slug, a.image, a.image2, a.sale_price, a.user_fullName, a.old_price, a.end_date, a.is_discount, a.shop_id, a.short_desc, b.name as category_name,b.slug as category_slug, c.name as brand_name
			FROM products a
            INNER JOIN pro_categories b ON a.category_ids = b.id AND b.is_publish = 1 
            INNER JOIN brands c ON a.brand_id = c.id AND c.is_publish = 1  
			WHERE a.is_publish = 1 AND a.is_featured = 0 AND a.collection_id = 0
			ORDER BY a.id DESC LIMIT 15;";
			$products = DB::select($np_sql);
			
			for($i=0; $i<count($products); $i++){
				$Reviews = getReviews($products[$i]->id);
				$products[$i]->TotalReview = $Reviews[0]->TotalReview;
				$products[$i]->TotalRating = $Reviews[0]->TotalRating;
				$products[$i]->ReviewPercentage = number_format($Reviews[0]->ReviewPercentage);
			}

            $feature_sql = "SELECT a.id, a.brand_id, a.title, a.slug, a.image, a.image2, a.sale_price, a.user_fullName, a.old_price, a.end_date, a.is_discount, a.shop_id, a.short_desc, b.name as category_name,b.slug as category_slug, c.name as brand_name
			FROM products a
            INNER JOIN pro_categories b ON a.category_ids = b.id AND b.is_publish = 1
            INNER JOIN brands c ON a.brand_id = c.id AND c.is_publish = 1  
			WHERE a.is_publish = 1 AND a.is_featured = 1
			ORDER BY a.id DESC LIMIT 15;";
			$feature_products = DB::select($feature_sql);
			
			for($i=0; $i<count($products); $i++){
				$Reviews = getReviews($products[$i]->id);
				$products[$i]->TotalReview = $Reviews[0]->TotalReview;
				$products[$i]->TotalRating = $Reviews[0]->TotalRating;
				$products[$i]->ReviewPercentage = number_format($Reviews[0]->ReviewPercentage);
			}

            $popular_sql = "SELECT a.id, a.brand_id, a.title, a.slug, a.image, a.image2, a.sale_price, a.user_fullName, a.old_price, a.end_date, a.is_discount, a.shop_id, a.short_desc, b.name as category_name,b.slug as category_slug, c.name as brand_name
			FROM products a
            INNER JOIN pro_categories b ON a.category_ids = b.id AND b.is_publish = 1
            INNER JOIN brands c ON a.brand_id = c.id AND c.is_publish = 1  
			WHERE a.is_publish = 1 AND a.collection_id = 1
			ORDER BY a.id DESC LIMIT 15;";
			$popular_products = DB::select($popular_sql);
			
			for($i=0; $i<count($products); $i++){
				$Reviews = getReviews($products[$i]->id);
				$products[$i]->TotalReview = $Reviews[0]->TotalReview;
				$products[$i]->TotalRating = $Reviews[0]->TotalRating;
				$products[$i]->ReviewPercentage = number_format($Reviews[0]->ReviewPercentage);
			}
        //dd($products);
		//Offer & Ads 
		$offer_ads = Offer_ad::where('is_publish', '=', 1)->where('offer_ad_type', '=', 'top')->orderBy('id', 'desc')->limit(3)->get();
        //Sidebar & Ads 
        $sidebar_ads = Offer_ad::where('is_publish', '=', 1)->where('offer_ad_type', '=', 'sidebar')->orderBy('id', 'desc')->limit(1)->get();
        //Sidebar & Ads 
       
		//Brand
        $brands = Brand::where('is_publish', '=', 1)->where('is_featured', '=', 1)->orderBy('id', 'desc')->limit(10)->get();
        //Testmonial
        $testimonials = Testimonial::where('is_publish', '=', 1)->orderBy('id', 'desc')->limit(3)->get();
        //conditions
        $conditions = Condition::where('is_publish', '=', 1)->orderBy('id', 'desc')->limit(5)->get();
        //blog
        $blogs = DB::table('blogs')->where('blogs.is_publish', '=', 1)->orderBy('id','desc')->limit(3)->get();
        return view('index', compact(
            'sliders',
            'pro_categores',
            'offer_ads',
            'brands',
            'sidebar_ads',
            'testimonials',
            'conditions',
            'blogs',
            'products',
            'feature_products',
            'popular_products'
        ));
    }
}
