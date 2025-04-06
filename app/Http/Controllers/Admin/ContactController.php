<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Contact;

class ContactController extends Controller
{

    //Get Contact
    public function getContactData(){
		
		$statuslist = DB::table('dp__statuses')->orderBy('id', 'asc')->get();
		
		$AllCount = Contact::count();
		$PublishedCount = Contact::where('is_publish', '=', 1)->count();
		$DraftCount = Contact::where('is_publish', '=', 2)->count();

		$datalist = DB::table('contacts')
			->join('dp__statuses', 'contacts.is_publish', '=', 'dp__statuses.id')
			->select('contacts.*', 'dp__statuses.status')
			->orderBy('contacts.id','desc')
			->paginate(20);
		
        return view('admin.contact', compact('AllCount', 'PublishedCount', 'DraftCount', 'datalist', 'statuslist'));
    }
	
	//Get data for Contact Pagination
	public function getContactPaginationData(Request $request){

		$search = $request->search;
		$post_status = $request->post_status;
		
		if($request->ajax()){
			if($search != ''){
				$datalist = DB::table('contacts')
					->join('dp__statuses', 'contacts.is_publish', '=', 'dp__statuses.id')
					->select('contacts.*', 'dp__statuses.status')
					->where(function ($query) use ($search){
						$query->where('title', 'like', '%'.$search.'%');
					})
					->orderBy('contacts.id','desc')
					->paginate(20);
			}else{
				$datalist = DB::table('contacts')
					->join('dp__statuses', 'contacts.is_publish', '=', 'dp__statuses.id')
					->select('contacts.*', 'dp__statuses.status')
					->where(function ($query) use ($post_status){
						$query->whereRaw("contacts.is_publish = '".$post_status."' OR '".$post_status."' = '0'");
					})
					->orderBy('contacts.id','desc')
					->paginate(20);
			}

			return view('admin.partials.contact_table', compact('datalist'))->render();
		}
	}
	 
	//Save data for Contact
    public function saveContactData(Request $request){
		$res = array();

		$id = $request->input('RecordId');
		$title = esc($request->input('title'));
		$is_publish = $request->input('is_publish');
		$mail_subject = str_slug($request->input('mail_subject'));
		$email = $request->input('email');
		$phone = $request->input('phone');
		$address = $request->input('address');
		$short_desc = $request->input('short_desc');
		
 		$validator_array = array(
			'title' => $request->input('title'),
			'email' => $request->input('email'),
			'phone' => $request->input('phone'),
			'address' => $request->input('address')
		);
		
		$validator = Validator::make($validator_array, [
			'title' => 'required',
			'email' => 'required',
			'phone' => 'required',
			'address' => 'required'
		]);

		$errors = $validator->errors();	

		if($errors->has('title')){
			$res['id'] = '';
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('title');
			return response()->json($res);
		}
		
		if($errors->has('email')){
			$res['id'] = '';
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('email');
			return response()->json($res);
		}
		
		if($errors->has('phone')){
			$res['id'] = '';
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('phone');
			return response()->json($res);
		}
		
		if($errors->has('address')){
			$res['id'] = '';
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('address');
			return response()->json($res);
		}

		$contact_info = array(
			'email' => $email,
			'phone' => $phone,
			'address' => $address,
			'short_desc' => $short_desc
		);
		
		
		$data = array(
			'title' => $title,
			'contact_info' => json_encode($contact_info),
			'mail_subject' => $mail_subject,
			'is_publish' => $is_publish,
		);
		
		if($id ==''){
			$response = Contact::create($data);
			if($response){
				$res['msgType'] = 'success';
				$res['msg'] = __('New Data Added Successfully');
			}else{
				$res['msgType'] = 'error';
				$res['msg'] = __('Data insert failed');
			}
		}else{
			$response = Contact::where('id', $id)->update($data);
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
	
	//Get data for Contact by id
    public function getContactById(Request $request){

		$id = $request->id;
		
		$data = Contact::where('id', $id)->first();
		$data->contact_info = json_decode($data->contact_info);
		
		return response()->json($data);
	}
	
	//Delete data for Contact
	public function deleteContact(Request $request){
		$res = array();

		$id = $request->id;

		if($id != ''){
			$response = Contact::where('id', $id)->delete();
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
	
	//Bulk Action for Contact
	public function bulkActionContact(Request $request){
		
		$res = array();

		$idsStr = $request->ids;
		$idsArray = explode(',', $idsStr);
		
		$BulkAction = $request->BulkAction;

		if($BulkAction == 'publish'){
			$response = Contact::whereIn('id', $idsArray)->update(['is_publish' => 1]);
			if($response){
				$res['msgType'] = 'success';
				$res['msg'] = __('Data Updated Successfully');
			}else{
				$res['msgType'] = 'error';
				$res['msg'] = __('Data update failed');
			}
			
		}elseif($BulkAction == 'draft'){
			
			$response = Contact::whereIn('id', $idsArray)->update(['is_publish' => 2]);
			if($response){
				$res['msgType'] = 'success';
				$res['msg'] = __('Data Updated Successfully');
			}else{
				$res['msgType'] = 'error';
				$res['msg'] = __('Data update failed');
			}
			
		}elseif($BulkAction == 'delete'){
			$response = Contact::whereIn('id', $idsArray)->delete();
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
