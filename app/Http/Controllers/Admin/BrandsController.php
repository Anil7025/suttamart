<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Brand;

class BrandsController extends Controller
{
    //Brands page load
    public function getBrandsPageLoad() {
		
		$statuslist = DB::table('dp__statuses')->orderBy('id', 'asc')->get();
		
		$datalist = DB::table('brands')
			->join('dp__statuses', 'brands.is_publish', '=', 'dp__statuses.id')
			->select('brands.id', 'brands.name', 'brands.thumbnail', 'brands.is_featured', 'brands.is_publish', 'dp__statuses.status', )
			->orderBy('brands.id','desc')
			->paginate(10);

        return view('admin.brands', compact('statuslist', 'datalist'));
    }
	
	//Get data for Brands Pagination
	public function getBrandsTableData(Request $request){

		$search = $request->search;
		if($request->ajax()){

			if($search != ''){
				$datalist = DB::table('brands')
					->join('dp__statuses', 'brands.is_publish', '=', 'dp__statuses.id')
					->select('brands.id', 'brands.name', 'brands.thumbnail', 'brands.is_featured', 'brands.is_publish', 'dp__statuses.status', )
					->where(function ($query) use ($search){
						$query->where('name', 'like', '%'.$search.'%')
							->orWhere('thumbnail', 'like', '%'.$search.'%');
					})
					->orderBy('brands.id','desc')
					->paginate(10);
			}else{
				
				$datalist = DB::table('brands')
					->join('dp__statuses', 'brands.is_publish', '=', 'dp__statuses.id')
					->select('brands.id', 'brands.name', 'brands.thumbnail', 'brands.is_featured', 'brands.is_publish', 'dp__statuses.status',)
					->orderBy('brands.id','desc')
					->paginate(10);
			}

			return view('admin.partials.brands_table', compact('datalist'))->render();
		}
	}
	
	//Save data for Brands

	public function saveBrandsData(Request $request)
	{
		//dd($request->all());
		$res = array();
		$id = $request->input('RecordId');
		$name = $request->input('name');
		$is_featured = $request->input('is_featured');
		$is_publish = $request->input('is_publish');

		// Validate input
		$validator = Validator::make($request->all(), [
			'name' => 'required|max:191',
			'is_publish' => 'required',
			'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
		]);

		if ($validator->fails()) {
			return response()->json(['msgTypes' => 'error', 'msg' => $validator->errors()->first()]);
		}

		// Handle Image Upload
	
		$imageName ='';
			// Handle Image Upload
			if ($request->hasFile('thumbnail')) {
				$image = $request->file('thumbnail');
				
				$imageName = time() . '.' . $image->getClientOriginalExtension();
				$imagePath = 'uploads/brands/' . $imageName;
				
				// Move the image to the public folder
				$image->move(public_path('uploads/brands/'), $imageName);
			}
			$existingRecord = Brand::where('name', $name)->first();

			if (!$id && $existingRecord) {
				return response()->json(['msgTypes' => 'error', 'msg' => __('Brand with this name already exists')]);
			}
		// Prepare data
		$data = [
			'name' => $name,
			'thumbnail' => $imageName ?: ($existingRecord->thumbnail ?? null),
			'is_featured' => $is_featured,
			'is_publish' => $is_publish
		];

		// Insert or update record
		if (!$id) {
			$response = Brand::create($data);
			$msg = $response ? __('New Data Added Successfully') : __('Data insert failed');
		} else {
			$response = Brand::where('id', $id)->update($data);
			$msg = $response ? __('Data Updated Successfully') : __('Data update failed');
		}

		return response()->json(['msgTypes' => $response ? 'success' : 'error', 'msg' => $msg]);
	}


	
	//Get data for Brand by id
    public function getBrandsById(Request $request){

		$id = $request->id;
		
		$data = Brand::where('id', $id)->first();
		
		return response()->json($data);
	}
	
	//Delete data for Brands
	public function deleteBrands(Request $request){
		
		$res = array();

		$id = $request->id;

		if($id != ''){
			$response = Brand::where('id', $id)->delete();
			if($response){
				$res['msgTypes'] = 'success';
				$res['msg'] = __('Data Removed Successfully');
			}else{
				$res['msgTypes'] = 'error';
				$res['msg'] = __('Data remove failed');
			}
		}
		
		return response()->json($res);
	}
	
	//Bulk Action for Brands
	public function bulkActionBrands(Request $request){
		
		$res = array();

		$idsStr = $request->ids;
		$idsArray = explode(',', $idsStr);
		
		$BulkAction = $request->BulkAction;

		if($BulkAction == 'publish'){
			$response = Brand::whereIn('id', $idsArray)->update(['is_publish' => 1]);
			if($response){
				$res['msgTypes'] = 'success';
				$res['msg'] = __('Data Updated Successfully');
			}else{
				$res['msgTypes'] = 'error';
				$res['msg'] = __('Data update failed');
			}
			
		}elseif($BulkAction == 'draft'){
			
			$response = Brand::whereIn('id', $idsArray)->update(['is_publish' => 2]);
			if($response){
				$res['msgTypes'] = 'success';
				$res['msg'] = __('Data Updated Successfully');
			}else{
				$res['msgTypes'] = 'error';
				$res['msg'] = __('Data update failed');
			}
			
		}elseif($BulkAction == 'delete'){
			$response = Brand::whereIn('id', $idsArray)->delete();
			if($response){
				$res['msgTypes'] = 'success';
				$res['msg'] = __('Data Removed Successfully');
			}else{
				$res['msgTypes'] = 'error';
				$res['msg'] = __('Data remove failed');
			}
		}
		
		return response()->json($res);
	}	
}

