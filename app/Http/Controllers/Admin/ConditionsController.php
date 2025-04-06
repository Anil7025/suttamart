<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Condition;

class ConditionsController extends Controller
{
    //conditions page load
    public function getconditionsPageLoad() {
		
		$statuslist = DB::table('dp__statuses')->orderBy('id', 'asc')->get();
		
		$datalist = DB::table('conditions')
			->join('dp__statuses', 'conditions.is_publish', '=', 'dp__statuses.id')
			->select('conditions.id', 'conditions.title', 'conditions.icon', 'conditions.description', 'conditions.sort_description', 'conditions.is_publish', 'dp__statuses.status', )
			->orderBy('conditions.id','desc')
			->paginate(10);

        return view('admin.conditions', compact('statuslist', 'datalist'));
    }
	
	//Get data for conditions Pagination
	public function getConditionsTableData(Request $request){

		$search = $request->search;
		if($request->ajax()){

			if($search != ''){
				$datalist = DB::table('conditions')
					->join('dp__statuses', 'conditions.is_publish', '=', 'dp__statuses.id')
					->select('conditions.id', 'conditions.title', 'conditions.icon', 'conditions.description', 'conditions.sort_description', 'conditions.is_publish', 'dp__statuses.status', )
					->where(function ($query) use ($search){
						$query->where('conditions.title', 'like', '%'.$search.'%')
							->orWhere('conditions.sort_description', 'like', '%'.$search.'%')
							->orWhere('conditions.icon', 'like', '%'.$search.'%');
					})
					->orderBy('conditions.id','desc')
					->paginate(10);
			}else{
				
				$datalist = DB::table('conditions')
					->join('dp__statuses', 'conditions.is_publish', '=', 'dp__statuses.id')
					->select('conditions.id', 'conditions.title', 'conditions.icon', 'conditions.description', 'conditions.sort_description', 'conditions.is_publish', 'dp__statuses.status', )
					->orderBy('conditions.id','desc')
					->paginate(10);
			}

			return view('admin.partials.conditions_table', compact('datalist'))->render();
		}
	}
	
	//Save data for conditions

	public function saveConditionsData(Request $request)
	{
		//dd($request->all());
		$res = array();
		$id = $request->input('RecordId');
		$title = $request->input('title');
		$sort_description = $request->input('sort_description');
		$description = $request->input('description');
		$icon = $request->input('icon');
		$is_publish = $request->input('is_publish');

		// Validate input
		$validator = Validator::make($request->all(), [
			'title' => 'required|max:191',
			'sort_description' => 'required',
			'description' => 'required',
			'is_publish' => 'required',
			'icon' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
		]);

		if ($validator->fails()) {
			return response()->json(['msgTypes' => 'error', 'msg' => $validator->errors()->first()]);
		}

		// Handle Image Upload
	
		$imagetitle ='';
			// Handle Image Upload
			if ($request->hasFile('icon')) {
				$image = $request->file('icon');
				
				$imagetitle = time() . '.' . $image->getClientOriginalExtension();
				$imagePath = 'uploads/conditions/' . $imagetitle;
				
				// Move the image to the public folder
				$image->move(public_path('uploads/conditions/'), $imagetitle);
			}
			$existingRecord = Condition::where('title', $title)->first();

			if (!$id && $existingRecord) {
				return response()->json(['msgTypes' => 'error', 'msg' => __('condition with this title already exists')]);
			}
		// Prepare data
		$data = [
			'title' => $title,
			'description' => $description,
			'sort_description' => $sort_description,
			'icon' => $imagetitle ?: ($existingRecord->image ?? null),
			'is_publish' => $is_publish
		];

		// Insert or update record
		if (!$id) {
			$response = Condition::create($data);
			$msg = $response ? __('New Data Added Successfully') : __('Data insert failed');
		} else {
			$response = Condition::where('id', $id)->update($data);
			$msg = $response ? __('Data Updated Successfully') : __('Data update failed');
		}

		return response()->json(['msgTypes' => $response ? 'success' : 'error', 'msg' => $msg]);
	}


	
	//Get data for conditions by id
    public function getConditionsById(Request $request){
		$id = $request->id;
		$data = Condition::where('id', $id)->first();
	
		if ($data) {
			$data->image_url = $data->image ? asset('uploads/conditions/' . $data->image) : null;
		}
	
		return response()->json($data);
	}
	
	
	//Delete data for conditions
	public function deleteconditions(Request $request){
		
		$res = array();

		$id = $request->id;

		if($id != ''){
			$response = Condition::where('id', $id)->delete();
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
	
	//Bulk Action for conditions
	public function bulkActionConditions(Request $request){
		
		$res = array();

		$idsStr = $request->ids;
		$idsArray = explode(',', $idsStr);
		
		$BulkAction = $request->BulkAction;

		if($BulkAction == 'publish'){
			$response = Condition::whereIn('id', $idsArray)->update(['is_publish' => 1]);
			if($response){
				$res['msgTypes'] = 'success';
				$res['msg'] = __('Data Updated Successfully');
			}else{
				$res['msgTypes'] = 'error';
				$res['msg'] = __('Data update failed');
			}
			
		}elseif($BulkAction == 'draft'){
			
			$response = Condition::whereIn('id', $idsArray)->update(['is_publish' => 2]);
			if($response){
				$res['msgTypes'] = 'success';
				$res['msg'] = __('Data Updated Successfully');
			}else{
				$res['msgTypes'] = 'error';
				$res['msg'] = __('Data update failed');
			}
			
		}elseif($BulkAction == 'delete'){
			$response = Condition::whereIn('id', $idsArray)->delete();
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

