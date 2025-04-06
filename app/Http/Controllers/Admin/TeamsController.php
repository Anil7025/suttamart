<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Team;

class TeamsController extends Controller
{
    //teams page load
    public function getTeamsPageLoad() {
		
		$statuslist = DB::table('dp__statuses')->orderBy('id', 'asc')->get();
		
		$datalist = DB::table('teams')
			->join('dp__statuses', 'teams.is_publish', '=', 'dp__statuses.id')
			->select('teams.id', 'teams.name', 'teams.image', 'teams.description','teams.slug', 'teams.designation',  'teams.is_publish', 'dp__statuses.status', )
			->orderBy('teams.id','desc')
			->paginate(10);

        return view('admin.teams', compact('statuslist', 'datalist'));
    }
	
	//Get data for teams Pagination
	public function getTeamsTableData(Request $request){

		$search = $request->search;
		if($request->ajax()){

			if($search != ''){
				$datalist = DB::table('teams')
					->join('dp__statuses', 'teams.is_publish', '=', 'dp__statuses.id')
					->select('teams.id', 'teams.name', 'teams.image', 'teams.slug', 'teams.description', 'teams.designation', 'teams.is_publish', 'dp__statuses.status', )
					->where(function ($query) use ($search){
						$query->where('name', 'like', '%'.$search.'%')
							->orWhere('image', 'like', '%'.$search.'%');
					})
					->orderBy('teams.id','desc')
					->paginate(10);
			}else{
				
				$datalist = DB::table('teams')
					->join('dp__statuses', 'teams.is_publish', '=', 'dp__statuses.id')
					->select('teams.id', 'teams.name', 'teams.image', 'teams.slug', 'teams.description', 'teams.designation', 'teams.is_publish', 'dp__statuses.status',)
					->orderBy('teams.id','desc')
					->paginate(10);
			}

			return view('admin.partials.teams_table', compact('datalist'))->render();
		}
	}
	
	//Save data for Teams

	public function saveTeamsData(Request $request)
	{
		//dd($request->all());
		$res = array();
		$id = $request->input('RecordId');
		$name = $request->input('name');
		$slug = $request->input('slug');
		$description = $request->input('description');
		$designation = $request->input('designation');
		$image = $request->input('image');
		$is_publish = $request->input('is_publish');
		$facebook = $request->input('facebook');
		$instagram = $request->input('instagram');
		$twitter = $request->input('twitter');
		$youtube = $request->input('youtube');

		// Validate input
		$validator = Validator::make($request->all(), [
			'name' => 'required|max:191',
			'slug' => 'required',
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
				$imagePath = 'uploads/teams/' . $imageName;
				
				// Move the image to the public folder
				$image->move(public_path('uploads/teams/'), $imageName);
			}
			$existingRecord = Team::where('name', $name)->first();

			if (!$id && $existingRecord) {
				return response()->json(['msgTypes' => 'error', 'msg' => __('team with this name already exists')]);
			}
		// Prepare data
		$data = [
			'name' => $name,
			'slug'=>$slug,
			'description' => $description,
			'designation' => $designation,
			'is_publish' => $is_publish,
			'image' => $imageName ?: ($existingRecord->image ?? null),
			'facebook' => $facebook,
			'instagram' => $instagram,
			'twitter' => $twitter,
			'youtube' => $youtube,
			
		];

		// Insert or update record
		if (!$id) {
			$response = Team::create($data);
			$msg = $response ? __('New Data Added Successfully') : __('Data insert failed');
		} else {
			$response = Team::where('id', $id)->update($data);
			$msg = $response ? __('Data Updated Successfully') : __('Data update failed');
		}

		return response()->json(['msgTypes' => $response ? 'success' : 'error', 'msg' => $msg]);
	}


	
	//Get data for teams by id
    public function getteamsById(Request $request){
		$id = $request->id;
		$data = Team::where('id', $id)->first();
	
		if ($data) {
			$data->image_url = $data->image ? asset('uploads/teams/' . $data->image) : null;
		}
	
		return response()->json($data);
	}
	
	
	//Delete data for teams
	public function deleteteams(Request $request){
		
		$res = array();

		$id = $request->id;

		if($id != ''){
			$response = Team::where('id', $id)->delete();
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
	//has Team Title Slug
    public function hasTeamSlug(Request $request){
		$res = array();
		
		$slug = str_slug($request->slug);
        $count = team::where('slug', 'like', '%'.$slug.'%') ->count();
		if($count == 0){
			$res['slug'] = $slug;
		}else{
			$incr = $count+1;
			$res['slug'] = $slug.'-'.$incr;
		}
		
		return response()->json($res);
	}
	//Bulk Action for teams
	public function bulkActionteams(Request $request){
		
		$res = array();

		$idsStr = $request->ids;
		$idsArray = explode(',', $idsStr);
		
		$BulkAction = $request->BulkAction;

		if($BulkAction == 'publish'){
			$response = Team::whereIn('id', $idsArray)->update(['is_publish' => 1]);
			if($response){
				$res['msgTypes'] = 'success';
				$res['msg'] = __('Data Updated Successfully');
			}else{
				$res['msgTypes'] = 'error';
				$res['msg'] = __('Data update failed');
			}
			
		}elseif($BulkAction == 'draft'){
			
			$response = Team::whereIn('id', $idsArray)->update(['is_publish' => 2]);
			if($response){
				$res['msgTypes'] = 'success';
				$res['msg'] = __('Data Updated Successfully');
			}else{
				$res['msgTypes'] = 'error';
				$res['msg'] = __('Data update failed');
			}
			
		}elseif($BulkAction == 'delete'){
			$response = Team::whereIn('id', $idsArray)->delete();
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

