<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Pro_category;

class Pro_categoriesController extends Controller
{
    //Product Categories page load
    public function getProductCategoriesPageLoad() {
		$statuslist = DB::table('dp__statuses')->orderBy('id', 'asc')->get();
		
		$datalist = DB::table('pro_categories')
			->join('dp__statuses', 'pro_categories.is_publish', '=', 'dp__statuses.id')
			->select('pro_categories.id', 'pro_categories.name', 'pro_categories.image', 'pro_categories.is_subheader', 'pro_categories.is_publish', 'dp__statuses.status')
			->orderBy('pro_categories.id','desc')
			->paginate(10);

        return view('admin.product-categories', compact('statuslist', 'datalist'));
    }
	
	//Get data for Product Categories Pagination
	public function getProductCategoriesTableData(Request $request) {
        $search = $request->search;
    
        if ($request->ajax()) {
            $query = DB::table('pro_categories')
                ->join('dp__statuses', 'pro_categories.is_publish', '=', 'dp__statuses.id')
                ->select('pro_categories.id', 'pro_categories.name', 'pro_categories.image', 'pro_categories.is_subheader', 'pro_categories.is_publish', 'dp__statuses.status')
                ->orderBy('pro_categories.id', 'desc');
    
            if (!empty($search)) {
                $query->where('pro_categories.name', 'like', '%' . $search . '%')
                      ->orWhere('pro_categories.image', 'like', '%' . $search . '%');
            }
    
            $datalist = $query->paginate(10);
    
            return view('admin.partials.product_categories_table', compact('datalist'))->render();
        }
    }
    
	
	//Save data for Product Categories
	public function saveProductCategoriesData(Request $request) {
		$res = array();
	
		$id = $request->input('RecordId');
		$name = esc($request->input('name'));
		$slug = esc(str_slug($request->input('slug')));
		$sortdescription = esc($request->input('sortdescription'));
		$description = esc($request->input('description'));
		$is_subheader = $request->input('is_subheader');
		$is_publish = $request->input('is_publish');
		$og_title = esc($request->input('og_title'));
		$og_description = esc($request->input('og_description'));
		$og_keywords = esc($request->input('og_keywords'));
	
		// Validation
		$rId = $id ? ",$id" : '';
		$validator = Validator::make([
			'name' => $name,
			'slug' => $slug,
			'is_publish' => $is_publish
		], [
			'name' => 'required|max:191',
			'slug' => 'required|max:191|unique:pro_categories,slug' . $rId,
			'is_publish' => 'required'
		]);
	
		if ($validator->fails()) {
			return response()->json([
				'msgType' => 'error',
				'msg' => $validator->errors()->first()
			]);
		}
	
		// Fetch existing category data
		$existingCategory = Pro_category::find($id);
	
		// Handle Image Upload
		$imageName = $existingCategory ? $existingCategory->image : '';
		if ($request->hasFile('image')) {
			$image = $request->file('image');
			$imageName = time() . '.' . $image->getClientOriginalExtension();
			$image->move(public_path('uploads/category/'), $imageName);
		}
	
		// Handle Subheader Image Upload
		$subImageName = $existingCategory ? $existingCategory->subheader_image : '';
		if ($request->hasFile('subheader_image')) {
			$image = $request->file('subheader_image');
			$subImageName = time() . '.' . $image->getClientOriginalExtension();
			$image->move(public_path('uploads/subcategory/'), $subImageName);
		}
	
		// Prepare Data
		$data = [
			'name' => $name,
			'slug' => $slug,
			'image' => $imageName,
			'subheader_image' => $subImageName,
			'sortdescription' => $sortdescription,
			'description' => $description,
			'is_subheader' => $is_subheader,
			'is_publish' => $is_publish,
			'og_title' => $og_title,
			'og_description' => $og_description,
			'og_keywords' => $og_keywords
		];
	
		// Insert or Update
		if ($id) {
			$updated = Pro_category::where('id', $id)->update($data);
			$res['msgType'] = $updated ? 'success' : 'error';
			$res['msg'] = $updated ? __('Data Updated Successfully') : __('Data update failed');
		} else {
			$created = Pro_category::create($data);
			$res['msgType'] = $created ? 'success' : 'error';
			$res['msg'] = $created ? __('New Data Added Successfully') : __('Data insert failed');
		}
	
		return response()->json($res);
	}
	
	//Get data for Product Categories by id
    public function getProductCategoriesById(Request $request){

		$id = $request->id;
		
		$data = Pro_category::where('id', $id)->first();
		
		return response()->json($data);
	}
	
	//Delete data for Product Categories
	public function deleteProductCategories(Request $request){
		
		$res = array();

		$id = $request->id;

		if($id != ''){
			$response = Pro_category::where('id', $id)->delete();
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
	
	//Bulk Action for Product Categories
	public function bulkActionProductCategories(Request $request){
		
		$res = array();

		$idsStr = $request->ids;
		$idsArray = explode(',', $idsStr);
		
		$BulkAction = $request->BulkAction;

		if($BulkAction == 'publish'){
			$response = Pro_category::whereIn('id', $idsArray)->update(['is_publish' => 1]);
			if($response){
				$res['msgType'] = 'success';
				$res['msg'] = __('Data Updated Successfully');
			}else{
				$res['msgType'] = 'error';
				$res['msg'] = __('Data update failed');
			}
			
		}elseif($BulkAction == 'draft'){
			
			$response = Pro_category::whereIn('id', $idsArray)->update(['is_publish' => 2]);
			if($response){
				$res['msgType'] = 'success';
				$res['msg'] = __('Data Updated Successfully');
			}else{
				$res['msgType'] = 'error';
				$res['msg'] = __('Data update failed');
			}
			
		}elseif($BulkAction == 'delete'){
			$response = Pro_category::whereIn('id', $idsArray)->delete();
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

	//has Product Category Slug
    public function hasProductCategorySlug(Request $request){
		$res = array();
		
		$slug = str_slug($request->slug);
        $count = Pro_category::where('slug', 'like', '%'.$slug.'%') ->count();
		if($count == 0){
			$res['slug'] = $slug;
		}else{
			$incr = $count+1;
			$res['slug'] = $slug.'-'.$incr;
		}
		
		return response()->json($res);
	}	
}