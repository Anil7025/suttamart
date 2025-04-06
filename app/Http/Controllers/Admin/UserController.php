<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Admin;

class UserController extends Controller
{
    public function getUsersPageLoad()
    {
   
        $datalist = User::where('status', 'active')
            ->orderBy('name', 'asc')
            ->paginate(20);

        return view('admin.users', compact('datalist'));
    }
    public function getUsersTableData(Request $request){

		$search = $request->search;
		
		if($request->ajax()){

			if($search != ''){

				$datalist = DB::table('users')
					->where(function ($query) use ($search){
						$query->where('users.name', 'like', '%'.$search.'%')
							->orWhere('users.email', 'like', '%'.$search.'%')
							->orWhere('users.mobile', 'like', '%'.$search.'%');
					})
					->where('users.status', 'active')
					->orderBy('users.name','asc')
					->paginate(20);
			}else{

				$datalist = DB::table('users')
                ->where('users.status', 'active')
					->orderBy('users.name','asc')
					->paginate(20);
			}

			return view('admin.partials.users_table', compact('datalist'))->render();
		}
	}
	//Get data for Users Pagination

	//Save data for Users
    public function saveUsersData(Request $request) {
		$res = array();
		$id = $request->input('RecordId');
	
		// Validate input data
		$validator = Validator::make($request->all(), [
			'name' => 'required|max:191',
			'email' => 'required|max:191|unique:users,email,' . ($id ?? 'NULL') . ',id',
			'password' => $id ? 'nullable|max:191' : 'required|max:191',
			'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image file
		]);
	
		if ($validator->fails()) {
			return response()->json(['msgType' => 'error', 'msg' => $validator->errors()->first()]);
		}
		$imageName ='';
		// Handle Image Upload
		if ($request->hasFile('image')) {
			$image = $request->file('image');
			
			$imageName = time() . '.' . $image->getClientOriginalExtension();
			$imagePath = 'uploads/users/' . $imageName;
			
			// Move the image to the public folder
			$image->move(public_path('uploads/users/'), $imageName);
		}
		// Assign input values
		$data = [
			'name' => $request->input('name'),
			'email' => $request->input('email'),
			'mobile' => $request->input('phone'),
			'address' => $request->input('address'),
			'pincode' => $request->input('pincode'),
			'state' => $request->input('state'),
			'country' => $request->input('country'),
			'status' => $request->input('status'),
			'image' => $imageName,
		];
	
		if ($request->filled('password')) {
			$data['password'] = Hash::make($request->input('password'));
		}
		
	
		// Insert or Update the record
		if (!$id) {
			$response = User::create($data);
			$msg = $response ? __('New Data Added Successfully') : __('Data insert failed');
		} else {
			$response = User::where('id', $id)->update($data);
			$msg = $response ? __('Data Updated Successfully') : __('Data update failed');
		}
	
		return response()->json(['msgType' => $response ? 'success' : 'error', 'msg' => $msg]);
	}
	
		
	
	//Get data for User by id
    public function getUserById(Request $request){

		$id = $request->id;
		
		$data = DB::table('users')->where('id', $id)->first();
		
		return response()->json($data);
	}
	
	//Delete data for User
	public function deleteUser(Request $request){
		
		$res = array();

		$id = $request->id;

		if($id != ''){
			$response = User::where('id', $id)->delete();
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
	
	//Bulk Action for Users
	public function bulkActionUsers(Request $request){
		
		$res = array();

		$idsStr = $request->ids;
		$idsArray = explode(',', $idsStr);
		
		$BulkAction = $request->BulkAction;

		if($BulkAction == 'active'){
			$response = User::whereIn('id', $idsArray)->update(['status_id' => 1]);
			if($response){
				$res['msgType'] = 'success';
				$res['msg'] = __('Data Updated Successfully');
			}else{
				$res['msgType'] = 'error';
				$res['msg'] = __('Data update failed');
			}
			
		}elseif($BulkAction == 'inactive'){
			
			$response = User::whereIn('id', $idsArray)->update(['status_id' => 2]);
			if($response){
				$res['msgType'] = 'success';
				$res['msg'] = __('Data Updated Successfully');
			}else{
				$res['msgType'] = 'error';
				$res['msg'] = __('Data update failed');
			}
			
		}elseif($BulkAction == 'delete'){
			$response = User::whereIn('id', $idsArray)->delete();
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
	
    //Profile page load
    public function getProfilePageLoad(){
		$adminId = Auth::guard('admin')->id();
		$media_datalist = Admin::where('id', $adminId)->first();
        return view('admin.profile', compact('media_datalist'));
    }
	
	//Save data for User Profile
    public function profileUpdate(Request $request){
		$res = array();
		
		$id = $request->input('RecordId');
		$name = $request->input('name');
		$email = $request->input('email');
		$password = $request->input('password');
		$phone = $request->input('phone');
		$address = $request->input('address');
		$photo = $request->input('photo');
		
		$validator_array = array(
			'name' => $request->input('name'),
			'email' => $request->input('email'),
			'password' => $request->input('password')
		);
		
		$rId = $id == '' ? '' : ','.$id;
		$validator = Validator::make($validator_array, [
			'name' => 'required|max:191',
			'email' => 'required|max:191|unique:users,email' . $rId,
			'password' => 'required|max:191'
		]);

		$errors = $validator->errors();

		if($errors->has('name')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('name');
			return response()->json($res);
		}
		
		if($errors->has('email')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('email');
			return response()->json($res);
		}
		
		if($errors->has('password')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('password');
			return response()->json($res);
		}

		$data = array(
			'name' => $name,
			'email' => $email,
			'password' => Hash::make($password),
			'phone' => $phone,
			'address' => $address,
			'photo' => $photo,
			'bactive' => base64_encode($password)
		);

		$response = User::where('id', $id)->update($data);
		if($response){
			$res['msgType'] = 'success';
			$res['msg'] = __('Data Updated Successfully');
		}else{
			$res['msgType'] = 'error';
			$res['msg'] = __('Data update failed');
		}
		
		return response()->json($res);
    }

}
