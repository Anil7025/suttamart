<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Blog_category;

class Blog_categoriesController extends Controller
{
    //Blog Categories page load
    public function getBlogCategoriesPageLoad() {
		
		$statuslist = DB::table('dp__statuses')->orderBy('id', 'asc')->get();
		
		$datalist = DB::table('blog_categories')
			->join('dp__statuses', 'blog_categories.is_publish', '=', 'dp__statuses.id')
			->select('blog_categories.*', 'dp__statuses.status')
			->orderBy('blog_categories.id','desc')
			->paginate(10);

        return view('admin.blog-categories', compact('statuslist', 'datalist'));
    }
	
	//Get data for Blog Categories Pagination
	public function getBlogCategoriesTableData(Request $request){

		$search = $request->search;
		$language_code = $request->language_code;

		if($request->ajax()){

			if($search != ''){
				$datalist = DB::table('blog_categories')
					->join('dp__statuses', 'blog_categories.is_publish', '=', 'dp__statuses.id')
					->select('blog_categories.*', 'dp__statuses.status')
					->where(function ($query) use ($search){
						$query->where('name', 'like', '%'.$search.'%')
							->orWhere('image', 'like', '%'.$search.'%');
					})
					->orderBy('blog_categories.id','desc')
					->paginate(10);
				
			}else{
				$datalist = DB::table('blog_categories')
					->join('dp__statuses', 'blog_categories.is_publish', '=', 'dp__statuses.id')
					->select('blog_categories.*', 'dp__statuses.status')
					->orderBy('blog_categories.id','desc')
					->paginate(10);
			}

			return view('admin.partials.blog_categories_table', compact('datalist'))->render();
		}
	}
	
	//Save data for Categories
    public function saveBlogCategoriesData(Request $request){
		$res = array();
		$id = $request->input('RecordId');
		$name = esc($request->input('name'));
		$slug = esc(str_slug($request->input('slug')));
		$image = $request->input('image');
		$description = esc($request->input('description'));
		$is_publish = $request->input('is_publish');
		$og_title = esc($request->input('og_title'));
		$og_description = esc($request->input('og_description'));
		$og_keywords = esc($request->input('og_keywords'));
		
		$validator_array = array(
			'name' => $request->input('name'),
			'slug' => $slug,
			'is_publish' => $request->input('is_publish')
		);
		
		$rId = $id == '' ? '' : ','.$id;
		$validator = Validator::make($validator_array, [
			'name' => 'required|max:191',
			'slug' => 'required|max:191|unique:blog_categories,slug' . $rId,
			'is_publish' => 'required'
		]);

		$errors = $validator->errors();

		if($errors->has('name')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('name');
			return response()->json($res);
		}
		
		if($errors->has('slug')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('slug');
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
            $imagePath = 'uploads/blog-cat/' . $imageName;
            
            // Move the image to the public folder
            $image->move(public_path('uploads/blog-cat/'), $imageName);
        }
        $existingRecord = Blog_category::where('name', $name)->first();

        if (!$id && $existingRecord) {
            return response()->json(['msgTypes' => 'error', 'msg' => __('offer ads image with this title already exists')]);
        }
		$data = array(
			'name' => $name,
			'slug' => $slug,
			'image' => $imageName,
			'description' => $description,
			'is_publish' => $is_publish,
			'og_title' => $og_title,
			'og_description' => $og_description,
			'og_keywords' => $og_keywords
		);

		if($id ==''){
			$response = Blog_category::create($data);
			if($response){
				$res['msgType'] = 'success';
				$res['msg'] = __('New Data Added Successfully');
			}else{
				$res['msgType'] = 'error';
				$res['msg'] = __('Data insert failed');
			}
		}else{
			$response = Blog_category::where('id', $id)->update($data);
			if($response){
				
				//Update Parent and Child Menu
				gMenuUpdate($id, 'blog', $name, $slug);
				
				$res['msgType'] = 'success';
				$res['msg'] = __('Data Updated Successfully');
			}else{
				$res['msgType'] = 'error';
				$res['msg'] = __('Data update failed');
			}
		}
		
		return response()->json($res);
    }
	
	//Get data for Categories by id
    public function getBlogCategoriesById(Request $request){

		$id = $request->id;
		
		$data = Blog_category::where('id', $id)->first();
		
		return response()->json($data);
	}
	
	//Delete data for Blog Categories
	public function deleteBlogCategories(Request $request){
		
		$res = array();

		$id = $request->id;

		if($id != ''){
			$response = Blog_category::where('id', $id)->delete();
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
	
	//Bulk Action for Blog Categories
	public function bulkActionBlogCategories(Request $request){
		
		$res = array();

		$idsStr = $request->ids;
		$idsArray = explode(',', $idsStr);
		
		$BulkAction = $request->BulkAction;

		if($BulkAction == 'publish'){
			$response = Blog_category::whereIn('id', $idsArray)->update(['is_publish' => 1]);
			if($response){
				$res['msgType'] = 'success';
				$res['msg'] = __('Data Updated Successfully');
			}else{
				$res['msgType'] = 'error';
				$res['msg'] = __('Data update failed');
			}
			
		}elseif($BulkAction == 'draft'){
			
			$response = Blog_category::whereIn('id', $idsArray)->update(['is_publish' => 2]);
			if($response){
				$res['msgType'] = 'success';
				$res['msg'] = __('Data Updated Successfully');
			}else{
				$res['msgType'] = 'error';
				$res['msg'] = __('Data update failed');
			}
			
		}elseif($BulkAction == 'delete'){
			$response = Blog_category::whereIn('id', $idsArray)->delete();
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

	//has Blog Category Slug
    public function hasBlogCategorySlug(Request $request){
		$res = array();
		
		$slug = str_slug($request->slug);
        $count = Blog_category::where('slug', 'like', '%'.$slug.'%') ->count();
		if($count == 0){
			$res['slug'] = $slug;
		}else{
			$incr = $count+1;
			$res['slug'] = $slug.'-'.$incr;
		}
		
		return response()->json($res);
	}
}