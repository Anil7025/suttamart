<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Slider;

class HomeSliderController extends Controller
{
    //Slider page load
    public function getSliderPageLoad() {
		
		
		$statuslist = DB::table('dp__statuses')->orderBy('id', 'asc')->get();
		
		$datalist = DB::table('sliders')
			->join('dp__statuses', 'sliders.is_publish', '=', 'dp__statuses.id')
			->select('sliders.*', 'dp__statuses.status')
			->orderBy('sliders.id','desc')
			->paginate(10);

        return view('admin.slider', compact( 'statuslist', 'datalist'));
    }

	//Get data for Slider Pagination
	public function getSliderTableData(Request $request)
	{
		$search = $request->search;
		$slider_title = $request->title;

		if ($request->ajax()) {
			// Start Query
			$datalist = DB::table('sliders')
				->join('dp__statuses', 'sliders.is_publish', '=', 'dp__statuses.id')
				->select('sliders.*', 'dp__statuses.status')
				->orderBy('sliders.id', 'desc');

			// Apply Search Filter
			if (!empty($search)) {
				$datalist->where(function ($query) use ($search) {
					$query->where('sliders.title', 'like', '%' . $search . '%')
						->orWhere('sliders.description', 'like', '%' . $search . '%')
						->orWhere('sliders.url', 'like', '%' . $search . '%');
				});
			}

			// Apply Title Filter
			if (!empty($slider_title) && $slider_title != '0') {
				$datalist->where('sliders.title', $slider_title);
			}

			// Paginate Data
			$datalist = $datalist->paginate(10);

			// Render View
			return view('admin.partials.slider_table', compact('datalist'))->render();
		}
	}

	
	//Save data for Slider
    public function saveSliderData(Request $request)
	{
    $res = array();
    $id = $request->input('RecordId');
    $title = $request->input('title');
    $description = $request->input('description');
    $url = $request->input('url');
    $is_publish = $request->input('is_publish');

    // Validation
    $validator = Validator::make($request->all(), [
        'title' => 'required',
        'description' => 'required',
        'is_publish' => 'required',
        'image' => $id ? 'nullable|image|mimes:jpg,png,jpeg|max:2048' : 'required|image|mimes:jpg,png,jpeg|max:2048'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'msgType' => 'error',
            'msg' => $validator->errors()->first()
        ]);
    }

    // Handle Image Upload
    $imageName = null;
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/sliders/'), $imageName);
    }

    // Check for existing record
    $existingRecord = $id ? Slider::find($id) : Slider::where('title', $title)->first();

    if (!$id && $existingRecord) {
        return response()->json(['msgType' => 'error', 'msg' => __('Slider with this name already exists')]);
    }

    $data = [
        'title' => $title,
        'description' => $description,
        'url' => $url,
        'is_publish' => $is_publish
    ];

    // Preserve existing image if no new one is uploaded
    if ($imageName) {
        $data['image'] = $imageName;
    } elseif ($existingRecord) {
        $data['image'] = $existingRecord->image;
    }

    // Insert or update
    if (!$id) {
        $response = Slider::create($data);
        $msg = __('New Data Added Successfully');
    } else {
        $response = Slider::where('id', $id)->update($data);
        $msg = __('Data Updated Successfully');
    }

    return response()->json([
        'msgType' => $response ? 'success' : 'error',
        'msg' => $response ? $msg : __('Operation failed')
    ]);
	}

	
	//Get data for Slider by id
	public function getSliderById(Request $request)
	{
		$id = $request->id;
		$slider = DB::table('sliders')->where('id', $id)->first();
	
		if ($slider) {
			return response()->json($slider);
		} else {
			return response()->json(['error' => 'Record not found'], 404);
		}
	}
	
	
	//Delete data for Slider
	public function deleteSlider(Request $request){
		
		$res = array();

		$id = $request->id;

		if($id != ''){
			$response = Slider::where('id', $id)->delete();
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
	
	//Bulk Action for Slider
	public function bulkActionSlider(Request $request){
		
		$res = array();

		$idsStr = $request->ids;
		$idsArray = explode(',', $idsStr);
		
		$BulkAction = $request->BulkAction;

		if($BulkAction == 'publish'){
			$response = Slider::whereIn('id', $idsArray)->update(['is_publish' => 1]);
			if($response){
				$res['msgType'] = 'success';
				$res['msg'] = __('Data Updated Successfully');
			}else{
				$res['msgType'] = 'error';
				$res['msg'] = __('Data update failed');
			}
			
		}elseif($BulkAction == 'draft'){
			
			$response = Slider::whereIn('id', $idsArray)->update(['is_publish' => 2]);
			if($response){
				$res['msgType'] = 'success';
				$res['msg'] = __('Data Updated Successfully');
			}else{
				$res['msgType'] = 'error';
				$res['msg'] = __('Data update failed');
			}
			
		}elseif($BulkAction == 'delete'){
			$response = Slider::whereIn('id', $idsArray)->delete();
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
}
