<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Seller;
use App\Models\Subscriber;
use App\Models\Bank_information;
use App\Models\Withdrawal;
use App\Models\Withdrawal_image;
use App\Models\Product;
use App\Models\Pro_image;
use App\Models\Related_product;
use App\Models\Review;
use App\Models\Order_item;
use App\Models\Order;

class SellerController extends Controller
{
    public function LoadSellerRegister()
    {
        return view('frontend.seller-register');
    }
	
    public function SellerRegister(Request $request)
    {
		$gtext = gtext();

		$secretkey = $gtext['secretkey'];
		$recaptcha = $gtext['is_recaptcha'];
		if($recaptcha == 1){
			$request->validate([
				'g-recaptcha-response' => 'required',
				'name' => 'required',
				'email' => 'required|email|unique:users',
				'password' => 'required|confirmed|min:6',
				'shop_name' => 'required',
				'shop_url' => 'required',
				'shop_phone' => 'required',
			]);
			
			$captcha = $request->input('g-recaptcha-response');

			$ip = $_SERVER['REMOTE_ADDR'];
			$url = 'https://www.google.com/recaptcha/api/siteverify?secret='.urlencode($secretkey).'&response='.urlencode($captcha).'&remoteip'.$ip;
			$response = file_get_contents($url);
			$responseKeys = json_decode($response, true);
			if($responseKeys["success"] == false) {
				return redirect("seller/register")->withFail(__('The recaptcha field is required'));
			}
		}else{
			$request->validate([
				'name' => 'required',
				'email' => 'required|email|unique:users',
				'password' => 'required|confirmed|min:6',
				'shop_name' => 'required',
				'shop_url' => 'required',
				'shop_phone' => 'required',
			]);
		}
		
		$SellerSettings = gSellerSettings();
		if($SellerSettings['seller_auto_active'] == 1){
			$status_id = 1;
		}else{
			$status_id = 2;
		}
		
		$data = array(
			'name' => $request->input('name'),
			'email' => $request->input('email'),
			'password' => Hash::make($request->input('password')),
			'bactive' => base64_encode($request->input('password')),
			'shop_name' => $request->input('shop_name'),
			'shop_url' => $request->input('shop_url'),
			'phone' => $request->input('shop_phone'),
			'status_id' => $status_id,
			'role_id' => 3
		);
		
		$response = User::create($data);
		
		if($response){

			if($gtext['is_mailchimp'] == 1){
				$name = $request->input('name');
				$email_address = $request->input('email');

				$HTTP_Status = self::MailChimpSubscriber($name, $email_address);
				if($HTTP_Status == 200){
					$SubscriberCount = Subscriber::where('email_address', '=', $email_address)->count();
					if($SubscriberCount == 0){
						$data = array(
							'email_address' => $email_address,
							'first_name' => $name,
							'last_name' => $name,
							'status' => 'subscribed'
						);
						Subscriber::create($data);
					}
				}
			} 
			
			if($status_id == 1){
				return redirect()->back()->withSuccess(__('Thanks! You have register successfully. Please login.'));
			}else{
				return redirect()->back()->withSuccess(__('Thanks! You have register successfully. Your account is pending for review.'));
			}

		}else{
			return redirect()->back()->withFail(__('Oops! You are failed registration. Please try again.'));
		}
    }
	
	//MailChimp Subscriber
    public function MailChimpSubscriber($name, $email){
		$gtext = gtext();

		$apiKey = $gtext['mailchimp_api_key'];
		$listId = $gtext['audience_id'];
		
        //Create mailchimp API url
        $memberId = md5(strtolower($email));
        $dataCenter = substr($apiKey, strpos($apiKey, '-')+1);
        $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listId . '/members/' . $memberId; 

        //Member info
        $data = array(
            'email_address' => $email,
            'status' => 'subscribed',
            'merge_fields'  => [
                'FNAME'     => $name,
                'LNAME'     => $name
            ]
        );

        $jsonString = json_encode($data);

        // send a HTTP POST request with curl
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonString);
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
		
		return $httpCode;
    }
	
	
	//Sellers page load
    public function getSellersPageLoad(){
		$statuslist = DB::table('user_status')->orderBy('id', 'asc')->get();
		$shops = DB::table('Shops')->where('is_publish', '=', 1)->get();
		$AllCount = Seller::count();
		$ActiveCount = Seller::where('status', '=', 1)->count();
		$InactiveCount = Seller::where('status', '=', 2)->count();

		$datalist = DB::table('sellers')
			->join('user_status', 'sellers.status', '=', 'user_status.id')
			->join('Shops', 'user_status.id', '=', 'Shops.is_publish')
			->select('sellers.*', 'Shops.name as shopName', 'user_status.status as user_status')
			->where('sellers.status', 1)
			->orderBy('sellers.id','desc')
			->paginate(20);
		
        return view('admin.sellers', compact('AllCount', 'ActiveCount', 'InactiveCount', 'statuslist', 'datalist','shops'));
    }
	
	//Get data for Sellers Pagination
	public function getSellersTableData(Request $request){
		
		$status = $request->status;
		$search = $request->search;
		
		if($request->ajax()){

			if($search != ''){	
				$datalist = DB::table('sellers')
					->join('user_status', 'sellers.status', '=', 'user_status.id')
					->join('Shops', 'user_status.id', '=', 'Shops.is_publish')
					->select('sellers.*', 'Shops.name as shopName', 'user_status.status as user_status')
					->where(function ($query) use ($search){
						$query->where('sellers.name', 'like', '%'.$search.'%')
							->orWhere('sellers.email', 'like', '%'.$search.'%')
							->orWhere('sellers.mobile', 'like', '%'.$search.'%')
							->orWhere('sellers.address', 'like', '%'.$search.'%')
							->orWhere('Shops.name', 'like', '%'.$search.'%');
					})
					->where(function ($query) use ($status){
						$query->whereRaw("sellers.status = '".$status."' OR '".$status."' = '0'");
					})
					->orderBy('sellers.id','desc')
					->paginate(20);
			}else{
			$datalist = DB::table('sellers')
				->join('user_status', 'sellers.status', '=', 'user_status.id')
				->join('Shops', 'user_status.id', '=', 'Shops.is_publish')
				->select('sellers.*', 'Shops.name as shopName', 'user_status.status as user_status')
				->where(function ($query) use ($status){
					$query->whereRaw("sellers.status = '".$status."' OR '".$status."' = '0'");
				})
				->orderBy('sellers.id','desc')
				->paginate(20);
			}
			return view('admin.partials.sellers_table', compact('datalist'))->render();
		}
	} 
	
	//Save data for Sellers
	public function saveSellersData(Request $request){
		$res = array();
		
		$id = $request->input('RecordId');
		$validator = Validator::make($request->all(), [
			'name' => 'required|max:191',
			'email' => 'required|max:191|unique:sellers,email,' . $id,
			'password' => $id ? 'nullable|max:191' : 'required|max:191',
			'shop_name' => 'required',
			'mobile' => 'required',
			'address' => 'required',
			'city' => 'required',
			'state' => 'required',
			'pincode' => 'required',
		]);
	
		if ($validator->fails()) {
			return response()->json([
				'msgType' => 'error',
				'msg' => $validator->errors()->first(),
				'id' => ''
			]);
		}
	
		$data = [
			'name' => $request->input('name'),
			'email' => $request->input('email'),
			'shop' => $request->input('shop_name'),
			'mobile' => $request->input('mobile'),
			'address' => $request->input('address'),
			'district' => $request->input('city'),
			'state' => $request->input('state'),
			'pincode' => $request->input('pincode'),
			'status' => $request->input('status'),
			'addedBy' =>'admin',
		];
	
		// Only hash the password if provided
		if ($request->filled('password')) {
			$data['password'] = Hash::make($request->input('password'));
			$data['bactive'] = base64_encode($request->input('password'));
		}
	
		// Handle Image Upload
		if ($request->hasFile('image')) {
			$image = $request->file('image');
			$imageName = time() . '.' . $image->getClientOriginalExtension();
			$image->move(public_path('uploads/sellers/'), $imageName);
			$data['image'] = $imageName;
		}
	
		if (empty($id)) {
			$response = Seller::create($data);
			$res['id'] = $response->id ?? '';
		} else {
			$response = Seller::where('id', $id)->update($data);
			$res['id'] = $id;
		}
	
		$res['msgType'] = $response ? 'success' : 'error';
		$res['msg'] = $response ? __('Data Saved Successfully') : __('Data Save Failed');
	
		return response()->json($res);
	}
	
	
	//Get data for Sellers by id
	public function getSellerById(Request $request) {
		$id = $request->input('id'); // Use input() for better handling
	
		// Validate ID before querying
		if (!$id || !is_numeric($id)) {
			return response()->json(['error' => 'Invalid ID provided'], 400);
		}
	
		// Fetch seller data safely
		$data = DB::table('sellers')->where('id', $id)->first();
	
		if (!$data) {
			return response()->json(['error' => 'Seller not found'], 404);
		}
	
		// Decode `bactive` only if it exists
		if (!empty($data->bactive)) {
			$data->bactive = base64_decode($data->bactive);
		}
	
		// Format created_at date safely
		if (!empty($data->created_at)) {
			$data->created_at = date('d F, Y', strtotime($data->created_at));
		}
	
		return response()->json($data);
	}
	
	
	//Delete data for Sellers
	public function deleteSeller(Request $request){
		
		$res = array();

		$id = $request->id;

		if($id != ''){
			$response = Seller::where('id', $id)->delete();
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
	
	//Bulk Action for Sellers
	public function bulkActionSellers(Request $request){
		
		$res = array();

		$idsStr = $request->ids;
		$idsArray = explode(',', $idsStr);
		
		$BulkAction = $request->BulkAction;

		if($BulkAction == 'active'){
			$response = Seller::whereIn('id', $idsArray)->update(['status' => 1]);
			if($response){
				$res['msgType'] = 'success';
				$res['msg'] = __('Data Updated Successfully');
			}else{
				$res['msgType'] = 'error';
				$res['msg'] = __('Data update failed');
			}
			
		}elseif($BulkAction == 'inactive'){
			
			$response = Seller::whereIn('id', $idsArray)->update(['status' => 2]);
			if($response){
				$res['msgType'] = 'success';
				$res['msg'] = __('Data Updated Successfully');
			}else{
				$res['msgType'] = 'error';
				$res['msg'] = __('Data update failed');
			}
			
		}elseif($BulkAction == 'delete'){
			
			$response = Seller::whereIn('id', $idsArray)->delete();
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