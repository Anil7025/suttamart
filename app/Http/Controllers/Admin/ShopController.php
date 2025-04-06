<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Shop;

class ShopController extends Controller
{
    public function getShopsPageLoad() {
		
		$statuslist = DB::table('dp__statuses')->orderBy('id', 'asc')->get();
		
		$datalist = DB::table('Shops')
			->join('dp__statuses', 'Shops.is_publish', '=', 'dp__statuses.id')
			->select('Shops.id', 'Shops.name', 'Shops.shop_logo', 'Shops.mobile','Shops.is_publish', 'dp__statuses.status', )
			->orderBy('Shops.id','desc')
			->paginate(10);

        return view('admin.Shops', compact('statuslist', 'datalist'));
    }
	
	//Get data for Shops Pagination
	public function getShopsTableData(Request $request){

		$search = $request->search;
		if($request->ajax()){

			if($search != ''){
				$datalist = DB::table('Shops')
					->join('dp__statuses', 'Shops.is_publish', '=', 'dp__statuses.id')
					->select('Shops.id', 'Shops.name', 'Shops.shop_logo', 'Shops.mobile','Shops.is_publish', 'dp__statuses.status', )
					->where(function ($query) use ($search){
						$query->where('name', 'like', '%'.$search.'%')
							->orWhere('shop_logo', 'like', '%'.$search.'%');
					})
					->orderBy('Shops.id','desc')
					->paginate(10);
			}else{
				
				$datalist = DB::table('Shops')
					->join('dp__statuses', 'Shops.is_publish', '=', 'dp__statuses.id')
					->select('Shops.id', 'Shops.name', 'Shops.shop_logo', 'Shops.mobile','Shops.is_publish', 'dp__statuses.status',)
					->orderBy('Shops.id','desc')
					->paginate(10);
			}

			return view('admin.partials.Shops_table', compact('datalist'))->render();
		}
	}
	
	//Save data for Shops

	public function saveShopsData(Request $request)
	{
		//dd($request->all());
		$res = array();
		$id = $request->input('RecordId');
		$name = $request->input('name');
		$email = $request->input('email');
		$mobile = $request->input('mobile');
		$address = $request->input('address');
		$is_publish = $request->input('is_publish');

		// Validate input
		$validator = Validator::make($request->all(), [
			'name' => 'required|max:191',
			'email' => 'required',
			'mobile' => 'required',
			'address' => 'required',
			'shop_logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
		]);

		if ($validator->fails()) {
			return response()->json(['msgTypes' => 'error', 'msg' => $validator->errors()->first()]);
		}

		// Handle Image Upload
	
		$imageName ='';
			// Handle Image Upload
			if ($request->hasFile('shop_logo')) {
				$image = $request->file('shop_logo');
				
				$imageName = time() . '.' . $image->getClientOriginalExtension();
				$imagePath = 'uploads/shops/' . $imageName;
				
				// Move the image to the public folder
				$image->move(public_path('uploads/shops/'), $imageName);
			}
			$existingRecord = Shop::where('name', $name)->first();

			if (!$id && $existingRecord) {
				return response()->json(['msgTypes' => 'error', 'msg' => __('Shop with this name already exists')]);
			}
		// Prepare data
		$data = [
			'name' => $name,
			'email' => $email,
			'mobile' => $mobile,
			'address' => $address,
			'shop_logo' => $imageName ?: ($existingRecord->shop_logo ?? null),
			'is_publish' => $is_publish
		];

		// Insert or update record
		if (!$id) {
			$response = Shop::create($data);
			$msg = $response ? __('New Data Added Successfully') : __('Data insert failed');
		} else {
			$response = Shop::where('id', $id)->update($data);
			$msg = $response ? __('Data Updated Successfully') : __('Data update failed');
		}

		return response()->json(['msgTypes' => $response ? 'success' : 'error', 'msg' => $msg]);
	}


	
	//Get data for Shop by id
    public function getShopsById(Request $request){

		$id = $request->id;
		
		$data = Shop::where('id', $id)->first();
		
		return response()->json($data);
	}
	
	//Delete data for Shops
	public function deleteShops(Request $request){
		
		$res = array();

		$id = $request->id;

		if($id != ''){
			$response = Shop::where('id', $id)->delete();
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
	
	//Bulk Action for Shops
	public function bulkActionShops(Request $request){
		
		$res = array();

		$idsStr = $request->ids;
		$idsArray = explode(',', $idsStr);
		
		$BulkAction = $request->BulkAction;

		if($BulkAction == 'publish'){
			$response = Shop::whereIn('id', $idsArray)->update(['is_publish' => 1]);
			if($response){
				$res['msgTypes'] = 'success';
				$res['msg'] = __('Data Updated Successfully');
			}else{
				$res['msgTypes'] = 'error';
				$res['msg'] = __('Data update failed');
			}
			
		}elseif($BulkAction == 'draft'){
			
			$response = Shop::whereIn('id', $idsArray)->update(['is_publish' => 2]);
			if($response){
				$res['msgTypes'] = 'success';
				$res['msg'] = __('Data Updated Successfully');
			}else{
				$res['msgTypes'] = 'error';
				$res['msg'] = __('Data update failed');
			}
			
		}elseif($BulkAction == 'delete'){
			$response = Shop::whereIn('id', $idsArray)->delete();
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
