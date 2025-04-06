<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Blog_category;
use App\Models\Blog;

class BlogController extends Controller
{
    //get Blog Page
    public function getBlogPage(){
		
		$datalist = DB::table('blogs')
			->where('blogs.is_publish', '=', 1)
			->orderBy('id','desc')
			->paginate(9);
			
        return view('frontend.pages.blog', compact('datalist'));
    }
	
    //get Article Page
    public function getArticlePage($id, $title){

		$data = DB::table('blogs')
			->where('blogs.id', '=', $id)
			->where('blogs.is_publish', '=', 1)
			->first();
			
        return view('frontend.pages.blog-details', compact('data'));
    }
	
    //get Blog Category Page
    public function getBlogCategoryPage($id, $title){
		
		$params = array('category_id' => $id);

		$mdata = Blog_category::where('id', '=', $id)->where('is_publish', '=', 1)->first();
		if($mdata !=''){
			$metadata = $mdata;
		}else{
			$metadata = array(
				'id' => '',
				'name' => '',
				'slug' => '',
				'image' => '',
				'description' => '',
				'parent_id' => '',
				'is_publish' => '',
				'og_title' => '',
				'og_description' => '',
				'og_keywords' => ''
			);
		}
		
		$datalist = DB::table('blogs')
			->where('blogs.category_id', '=', $id)
			->where('blogs.is_publish', '=', 1)
			->orderBy('id','desc')
			->paginate(9);
			
        return view('frontend.pages.blog-category', compact('params', 'metadata', 'datalist'));
    }
}

