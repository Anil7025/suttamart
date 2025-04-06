<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Testimonial;

class TestimonialsController extends Controller
{
    //testimonials page load
    public function getTestimonialsPageLoad() {
		
		$statuslist = DB::table('dp__statuses')->orderBy('id', 'asc')->get();
		
		$datalist = DB::table('testimonials')
			->join('dp__statuses', 'testimonials.is_publish', '=', 'dp__statuses.id')
			->select('testimonials.id', 'testimonials.name', 'testimonials.image', 'testimonials.description', 'testimonials.designation',  'testimonials.is_publish', 'dp__statuses.status', )
			->orderBy('testimonials.id','desc')
			->paginate(10);

        return view('admin.testimonials', compact('statuslist', 'datalist'));
    }
	
	//Get data for testimonials Pagination
	public function getTestimonialsTableData(Request $request){

		$search = $request->search;
		if($request->ajax()){

			if($search != ''){
				$datalist = DB::table('testimonials')
					->join('dp__statuses', 'testimonials.is_publish', '=', 'dp__statuses.id')
					->select('testimonials.id', 'testimonials.name', 'testimonials.image', 'testimonials.description', 'testimonials.designation', 'testimonials.is_publish', 'dp__statuses.status', )
					->where(function ($query) use ($search){
						$query->where('name', 'like', '%'.$search.'%')
							->orWhere('image', 'like', '%'.$search.'%');
					})
					->orderBy('testimonials.id','desc')
					->paginate(10);
			}else{
				
				$datalist = DB::table('testimonials')
					->join('dp__statuses', 'testimonials.is_publish', '=', 'dp__statuses.id')
					->select('testimonials.id', 'testimonials.name', 'testimonials.image', 'testimonials.description', 'testimonials.designation', 'testimonials.is_publish', 'dp__statuses.status',)
					->orderBy('testimonials.id','desc')
					->paginate(10);
			}

			return view('admin.partials.testimonials_table', compact('datalist'))->render();
		}
	}
	
	//Save data for Testimonials

	public function saveTestimonialsData(Request $request)
	{
		//dd($request->all());
		$res = array();
		$id = $request->input('RecordId');
		$name = $request->input('name');
		$description = $request->input('description');
		$designation = $request->input('designation');
		$image = $request->input('image');
		$is_publish = $request->input('is_publish');

		// Validate input
		$validator = Validator::make($request->all(), [
			'name' => 'required|max:191',
			'description' => 'required',
			'designation' => 'required',
			'is_publish' => 'required',
			'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
		]);

		if ($validator->fails()) {
			return response()->json(['msgTypes' => 'error', 'msg' => $validator->errors()->first()]);
		}

		// Handle Image Upload
	
		$imageName ='';
			// Handle Image Upload
			if ($request->hasFile('image')) {
				$image = $request->file('image');
				
				$imageName = time() . '.' . $image->getClientOriginalExtension();
				$imagePath = 'uploads/testimonials/' . $imageName;
				
				// Move the image to the public folder
				$image->move(public_path('uploads/testimonials/'), $imageName);
			}
			$existingRecord = Testimonial::where('name', $name)->first();

			if (!$id && $existingRecord) {
				return response()->json(['msgTypes' => 'error', 'msg' => __('testimonial with this name already exists')]);
			}
		// Prepare data
		$data = [
			'name' => $name,
			'description' => $description,
			'designation' => $designation,
			'image' => $imageName ?: ($existingRecord->image ?? null),
			'is_publish' => $is_publish
		];

		// Insert or update record
		if (!$id) {
			$response = Testimonial::create($data);
			$msg = $response ? __('New Data Added Successfully') : __('Data insert failed');
		} else {
			$response = Testimonial::where('id', $id)->update($data);
			$msg = $response ? __('Data Updated Successfully') : __('Data update failed');
		}

		return response()->json(['msgTypes' => $response ? 'success' : 'error', 'msg' => $msg]);
	}


	
	//Get data for Testimonials by id
    public function getTestimonialsById(Request $request){
		$id = $request->id;
		$data = Testimonial::where('id', $id)->first();
	
		if ($data) {
			$data->image_url = $data->image ? asset('uploads/testimonials/' . $data->image) : null;
		}
	
		return response()->json($data);
	}
	
	
	//Delete data for testimonials
	public function deletetestimonials(Request $request){
		
		$res = array();

		$id = $request->id;

		if($id != ''){
			$response = Testimonial::where('id', $id)->delete();
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
	
	//Bulk Action for Testimonials
	public function bulkActionTestimonials(Request $request){
		
		$res = array();

		$idsStr = $request->ids;
		$idsArray = explode(',', $idsStr);
		
		$BulkAction = $request->BulkAction;

		if($BulkAction == 'publish'){
			$response = Testimonial::whereIn('id', $idsArray)->update(['is_publish' => 1]);
			if($response){
				$res['msgTypes'] = 'success';
				$res['msg'] = __('Data Updated Successfully');
			}else{
				$res['msgTypes'] = 'error';
				$res['msg'] = __('Data update failed');
			}
			
		}elseif($BulkAction == 'draft'){
			
			$response = Testimonial::whereIn('id', $idsArray)->update(['is_publish' => 2]);
			if($response){
				$res['msgTypes'] = 'success';
				$res['msg'] = __('Data Updated Successfully');
			}else{
				$res['msgTypes'] = 'error';
				$res['msg'] = __('Data update failed');
			}
			
		}elseif($BulkAction == 'delete'){
			$response = Testimonial::whereIn('id', $idsArray)->delete();
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

