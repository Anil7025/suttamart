<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Blog;
use App\Models\Blog_category;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
	//Blog page load
    public function getBlogPageLoad() {
		$blog_category = Blog_category::where('is_publish', 1)->orderBy('name', 'asc')->get();
		$statuslist = DB::table('dp__statuses')->orderBy('id', 'asc')->get();
		$datalist = DB::table('blogs')
			->join('dp__statuses', 'blogs.is_publish', '=', 'dp__statuses.id')
			->join('blog_categories', 'blogs.category_id', '=', 'blog_categories.id')
			->select('blogs.*', 'dp__statuses.status', 'blog_categories.name')
			->orderBy('blogs.id','desc')
			->paginate(20);

        return view('admin.blog', compact('blog_category', 'statuslist', 'datalist'));
    }
	
	//Get data for Blog Pagination
	public function getBlogTableData(Request $request){

		$search = $request->search;

		if($request->ajax()){

			if($search != ''){
				$datalist = DB::table('blogs')
					->join('dp__statuses', 'blogs.is_publish', '=', 'dp__statuses.id')
					->join('blog_categories', 'blogs.category_id', '=', 'blog_categories.id')
					->select('blogs.*', 'dp__statuses.status', 'blog_categories.name')
					->where(function ($query) use ($search){
						$query->where('blog_categories.name', 'like', '%'.$search.'%')
							->orWhere('blogs.title', 'like', '%'.$search.'%');
					})
					->orderBy('blogs.id','desc')
					->paginate(20);
				
			}else{
				$datalist = DB::table('blogs')
					->join('dp__statuses', 'blogs.is_publish', '=', 'dp__statuses.id')
					->join('blog_categories', 'blogs.category_id', '=', 'blog_categories.id')
					->select('blogs.*', 'dp__statuses.status','blog_categories.name')
					->orderBy('blogs.id','desc')
					->paginate(20);
			}

			return view('admin.partials.blog_table', compact('datalist'))->render();
		}
	}
	
	//Save data for Blog
    public function saveBlogData(Request $request){
		$res = array();
		
		$id = $request->input('RecordId');
		$blog_title = esc($request->input('blog_title'));
		$slug = esc(str_slug($request->input('slug')));
		$category_id = $request->input('category_id');
		$image = $request->input('image');
		$description = $request->input('description');
		$is_publish = $request->input('is_publish');
		$og_title = $request->input('og_title');
		$og_description = $request->input('og_description');
		$og_keywords = $request->input('og_keywords');
		
		$validator_array = array(
			'title' => $request->input('blog_title'),
			'slug' => $slug,
			'category' => $request->input('category_id'),
			'is_publish' => $request->input('is_publish')
		);
		
		$rId = $id == '' ? '' : ','.$id;
		$validator = Validator::make($validator_array, [
			'title' => 'required|max:191',
			'slug' => 'required|max:191|unique:blogs,slug' . $rId,
			'category' => 'required',
			'is_publish' => 'required'
		]);

		$errors = $validator->errors();

		if($errors->has('title')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('title');
			return response()->json($res);
		}
		
		if($errors->has('slug')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('slug');
			return response()->json($res);
		}
		
		if($errors->has('category')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('category');
			return response()->json($res);
		}
		
		if($errors->has('is_publish')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('is_publish');
			return response()->json($res);
		}
        $imageName ='';
        // Handle Image Upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = 'uploads/blogs/' . $imageName;
            
            // Move the image to the public folder
            $image->move(public_path('uploads/blogs/'), $imageName);
        }
        $existingRecord = Blog::where('title', $blog_title)->first();

        if (!$id && $existingRecord) {
            return response()->json(['msgTypes' => 'error', 'msg' => __('offer ads image with this title already exists')]);
        }
		$admin = Auth::guard('admin')->user()->name;
		$data = array(
			'title' => $blog_title,
			'slug' => $slug,
			'image' => $imageName,
			'description' => $description,
			'category_id' => $category_id,
			'is_publish' => $is_publish,
			'og_title' => $og_title,
			'og_description' => $og_description,
			'og_keywords' => $og_keywords,
			'user_name' => $admin,
		);

		if($id ==''){
			$response = Blog::create($data);
			if($response){
				$res['msgType'] = 'success';
				$res['msg'] = __('New Data Added Successfully');
			}else{
				$res['msgType'] = 'error';
				$res['msg'] = __('Data insert failed');
			}
		}else{
			$response = Blog::where('id', $id)->update($data);
			if($response){
				
				$res['msgType'] = 'success';
				$res['msg'] = __('Data Updated Successfully');
			}else{
				$res['msgType'] = 'error';
				$res['msg'] = __('Data update failed');
			}
		}
		
		return response()->json($res);
    }
	
	//Get data for by id
    public function getBlogById(Request $request){

		$id = $request->id;
		
		$data = Blog::where('id', $id)->first();
		
		return response()->json($data);
	}
	
	//Delete data for Blog
	public function deleteBlog(Request $request){
		
		$res = array();

		$id = $request->id;

		if($id != ''){
			$response = Blog::where('id', $id)->delete();
			if($response){
				$res['msgType'] = 'success';
				$res['msg'] = __('Data Removed Successfully');
			}else{
				$res['msgType'] = 'error';
				$res['msg'] = __('Data remove failed');
			}
		}
		
		return response()->json($res);
	}
	
	//Bulk Action for Blog
	public function bulkActionBlog(Request $request){
		
		$res = array();

		$idsStr = $request->ids;
		$idsArray = explode(',', $idsStr);
		
		$BulkAction = $request->BulkAction;

		if($BulkAction == 'publish'){
			$response = Blog::whereIn('id', $idsArray)->update(['is_publish' => 1]);
			if($response){
				$res['msgType'] = 'success';
				$res['msg'] = __('Data Updated Successfully');
			}else{
				$res['msgType'] = 'error';
				$res['msg'] = __('Data update failed');
			}
			
		}elseif($BulkAction == 'draft'){
			
			$response = Blog::whereIn('id', $idsArray)->update(['is_publish' => 2]);
			if($response){
				$res['msgType'] = 'success';
				$res['msg'] = __('Data Updated Successfully');
			}else{
				$res['msgType'] = 'error';
				$res['msg'] = __('Data update failed');
			}
			
		}elseif($BulkAction == 'delete'){
			$response = Blog::whereIn('id', $idsArray)->delete();
			if($response){
				$res['msgType'] = 'success';
				$res['msg'] = __('Data Removed Successfully');
			}else{
				$res['msgType'] = 'error';
				$res['msg'] = __('Data remove failed');
			}
		}
		
		return response()->json($res);
	}

	//has Blog Slug
    public function hasBlogSlug(Request $request){
		$res = array();
		
		$slug = str_slug($request->slug);
        $count = Blog::where('slug', 'like', '%'.$slug.'%') ->count();
		if($count == 0){
			$res['slug'] = $slug;
		}else{
			$incr = $count+1;
			$res['slug'] = $slug.'-'.$incr;
		}
		
		return response()->json($res);
	}
}
