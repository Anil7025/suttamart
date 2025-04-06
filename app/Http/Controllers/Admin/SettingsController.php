<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Tp_option;

class SettingsController extends Controller
{
    public function getGeneralPageLoad(){
		
		$datalist = Tp_option::where('option_name', 'general_settings')->get();
		$id = '';
		$option_value = '';
		foreach ($datalist as $row){
			$id = $row->id;
			$option_value = json_decode($row->option_value);
		}

		$data = array();
		if($id != ''){
			$data['site_name'] = $option_value->site_name;
			$data['site_title'] = $option_value->site_title;
			$data['company'] = $option_value->company;
			$data['email'] = $option_value->email;
			$data['phone'] = $option_value->phone;
			$data['address'] = $option_value->address;
		}else{
			$data['site_name'] = '';
			$data['site_title'] = '';
			$data['company'] = '';
			$data['email'] = '';
			$data['phone'] = '';
			$data['address'] = '';
		}

		$datalist = $data;

        return view('admin.general', compact('datalist'));
    }
    //load Payment Methods page
    public function loadPaymentMethodsPage(){
		
		//Paypal
		$paypal_data = Tp_option::where('option_name', 'paypal')->get();
		
		$paypal_id = '';
		foreach ($paypal_data as $row){
			$paypal_id = $row->id;
		}
		
		$paypal_data_list = array();
		if($paypal_id != ''){
			$paypalData = json_decode($paypal_data);
			$paypalObj = json_decode($paypalData[0]->option_value);
			$paypal_data_list['paypal_client_id'] = $paypalObj->paypal_client_id;
			$paypal_data_list['paypal_secret'] = $paypalObj->paypal_secret;
			$paypal_data_list['paypal_currency'] = $paypalObj->paypal_currency;
			$paypal_data_list['ismode_paypal'] = $paypalObj->ismode_paypal;
			$paypal_data_list['isenable_paypal'] = $paypalObj->isenable_paypal;
		}else{
			$paypal_data_list['paypal_client_id'] = '';
			$paypal_data_list['paypal_secret'] = '';
			$paypal_data_list['paypal_currency'] = '';
			$paypal_data_list['ismode_paypal'] = '';
			$paypal_data_list['isenable_paypal'] = '';
		}

		//Razorpay
		$razorpay_data = Tp_option::where('option_name', 'razorpay')->get();
		
		$razorpay_id = '';
		foreach ($razorpay_data as $row){
			$razorpay_id = $row->id;
		}
		
		$razorpay_data_list = array();
		if($razorpay_id != ''){
			$razorpayData = json_decode($razorpay_data);
			$razorpayObj = json_decode($razorpayData[0]->option_value);
			$razorpay_data_list['razorpay_key_id'] = $razorpayObj->razorpay_key_id;
			$razorpay_data_list['razorpay_key_secret'] = $razorpayObj->razorpay_key_secret;
			$razorpay_data_list['razorpay_currency'] = $razorpayObj->razorpay_currency;
			$razorpay_data_list['ismode_razorpay'] = $razorpayObj->ismode_razorpay;
			$razorpay_data_list['isenable_razorpay'] = $razorpayObj->isenable_razorpay;
		}else{
			$razorpay_data_list['razorpay_key_id'] = '';
			$razorpay_data_list['razorpay_key_secret'] = '';
			$razorpay_data_list['razorpay_currency'] = '';
			$razorpay_data_list['ismode_razorpay'] = '';
			$razorpay_data_list['isenable_razorpay'] = '';
		}

		

		//Cash on Delivery (COD)
		$cod_data = Tp_option::where('option_name', 'cash_on_delivery')->get();
		
		$cod_id = '';
		foreach ($cod_data as $row){
			$cod_id = $row->id;
		}

		$cod_data_list = array();
		if($cod_id != ''){
			$codData = json_decode($cod_data);
			$codObj = json_decode($codData[0]->option_value);
			$cod_data_list['description'] = $codObj->description;
			$cod_data_list['isenable'] = $codObj->isenable;
		}else{
			$cod_data_list['description'] = '';
			$cod_data_list['isenable'] = '';
		}
		
		
        return view('admin.payment-methods', compact('paypal_data_list', 'razorpay_data_list', 'cod_data_list'));
    }
	
	

	//Save data for Paypal
    public function PaypalSettingsUpdate(Request $request){
		$res = array();
		
		$paypal_client_id = $request->input('paypal_client_id');
		$paypal_secret = $request->input('paypal_secret');
		$paypal_currency = $request->input('paypal_currency');
		$is_mode_paypal = $request->input('ismode_paypal');
		$is_enable_paypal = $request->input('isenable_paypal');
		
		if ($is_enable_paypal == 'true' || $is_enable_paypal == 'on') {
			$isenable_paypal = 1;
		}else {
			$isenable_paypal = 0;
		}
		
		if ($is_mode_paypal == 'true' || $is_mode_paypal == 'on') {
			$ismode_paypal = 1; //sandbox
		}else {
			$ismode_paypal = 0; //live
		}
		
		$validator_array = array(
			'paypal_client_id' => $request->input('paypal_client_id'),
			'paypal_secret' => $request->input('paypal_secret'),
			'paypal_currency' => $request->input('paypal_currency')
		);

		$validator = Validator::make($validator_array, [
			'paypal_client_id' => 'required',
			'paypal_secret' => 'required',
			'paypal_currency' => 'required'
		]);

		$errors = $validator->errors();

		if($errors->has('paypal_client_id')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('paypal_client_id');
			return response()->json($res);
		}
		
		if($errors->has('paypal_secret')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('paypal_secret');
			return response()->json($res);
		}
		if($errors->has('paypal_currency')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('paypal_currency');
			return response()->json($res);
		}

		$option_value = array(
			'paypal_client_id' => $paypal_client_id,
			'paypal_secret' => $paypal_secret,
			'paypal_currency' => $paypal_currency,
			'ismode_paypal' => $ismode_paypal,
			'isenable_paypal' => $isenable_paypal
		);
		
		$data = array(
			'option_name' => 'paypal',
			'option_value' => json_encode($option_value)
		);

		$gData = Tp_option::where('option_name', 'paypal')->get();
		$id = '';
		foreach ($gData as $row){
			$id = $row['id'];
		}
		
		if($id == ''){
			$response = Tp_option::create($data);
			if($response){
				$res['msgType'] = 'success';
				$res['msg'] = __('New Data Added Successfully');
			}else{
				$res['msgType'] = 'error';
				$res['msg'] = __('Data insert failed');
			}
		}else{
			$response = Tp_option::where('id', $id)->update($data);
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

	//Save data for Razorpay
    public function RazorpaySettingsUpdate(Request $request){
		$res = array();
		
		$razorpay_key_id = $request->input('razorpay_key_id');
		$razorpay_key_secret = $request->input('razorpay_key_secret');
		$razorpay_currency = $request->input('razorpay_currency');
		$is_mode_razorpay = $request->input('ismode_razorpay');
		$is_enable_razorpay = $request->input('isenable_razorpay');
		
		if ($is_enable_razorpay == 'true' || $is_enable_razorpay == 'on') {
			$isenable_razorpay = 1;
		}else {
			$isenable_razorpay = 0;
		}
		
		if ($is_mode_razorpay == 'true' || $is_mode_razorpay == 'on') {
			$ismode_razorpay = 1; //sandbox
		}else {
			$ismode_razorpay = 0; //live
		}
		
		$validator_array = array(
			'razorpay_key_id' => $request->input('razorpay_key_id'),
			'razorpay_key_secret' => $request->input('razorpay_key_secret'),
			'razorpay_currency' => $request->input('razorpay_currency')
		);

		$validator = Validator::make($validator_array, [
			'razorpay_key_id' => 'required',
			'razorpay_key_secret' => 'required',
			'razorpay_currency' => 'required'
		]);

		$errors = $validator->errors();

		if($errors->has('razorpay_key_id')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('razorpay_key_id');
			return response()->json($res);
		}
		
		if($errors->has('razorpay_key_secret')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('razorpay_key_secret');
			return response()->json($res);
		}
		
		if($errors->has('razorpay_currency')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('razorpay_currency');
			return response()->json($res);
		}

		$option_value = array(
			'razorpay_key_id' => $razorpay_key_id,
			'razorpay_key_secret' => $razorpay_key_secret,
			'razorpay_currency' => $razorpay_currency,
			'ismode_razorpay' => $ismode_razorpay,
			'isenable_razorpay' => $isenable_razorpay
		);
		
		$data = array(
			'option_name' => 'razorpay',
			'option_value' => json_encode($option_value)
		);

		$gData = Tp_option::where('option_name', 'razorpay')->get();
		$id = '';
		foreach ($gData as $row){
			$id = $row['id'];
		}
		
		if($id == ''){
			$response = Tp_option::create($data);
			if($response){
				$res['msgType'] = 'success';
				$res['msg'] = __('New Data Added Successfully');
			}else{
				$res['msgType'] = 'error';
				$res['msg'] = __('Data insert failed');
			}
		}else{
			$response = Tp_option::where('id', $id)->update($data);
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
		
	
		
	//Save data for COD
    public function CODSettingsUpdate(Request $request){
		$res = array();
		
		$description = $request->input('description');
		$is_enable = $request->input('isenable_cod');
		
		if ($is_enable == 'true' || $is_enable == 'on') {
			$isenable = 1;
		}else {
			$isenable = 0;
		}
		
		$option_value = array(
			'description' => $description,
			'isenable' => $isenable
		);
		
		$data = array(
			'option_name' => 'cash_on_delivery',
			'option_value' => json_encode($option_value)
		);

		$gData = Tp_option::where('option_name', 'cash_on_delivery')->get();
		$id = '';
		foreach ($gData as $row){
			$id = $row['id'];
		}
		
		if($id == ''){
			$response = Tp_option::create($data);
			if($response){
				$res['msgType'] = 'success';
				$res['msg'] = __('New Data Added Successfully');
			}else{
				$res['msgType'] = 'error';
				$res['msg'] = __('Data insert failed');
			}
		}else{
			$response = Tp_option::where('id', $id)->update($data);
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
	
	
	
    //load Mail Settings page
    public function loadMailSettingsPage(){
		
		$datalist = Tp_option::where('option_name', 'mail_settings')->get();
		$id = '';
		$option_value = '';
		foreach ($datalist as $row){
			$id = $row->id;
			$option_value = json_decode($row->option_value);
		}

		$data = array();
		if($id != ''){
			$data['ismail'] = $option_value->ismail;
			$data['from_name'] = $option_value->from_name;
			$data['from_mail'] = $option_value->from_mail;
			$data['to_name'] = $option_value->to_name;
			$data['to_mail'] = $option_value->to_mail;
			$data['mailer'] = $option_value->mailer;
			$data['smtp_host'] = $option_value->smtp_host;
			$data['smtp_port'] = $option_value->smtp_port;
			$data['smtp_security'] = $option_value->smtp_security;
			$data['smtp_username'] = $option_value->smtp_username;
			$data['smtp_password'] = $option_value->smtp_password;
		}else{
			$data['ismail'] = '';
			$data['from_name'] = '';
			$data['from_mail'] = '';
			$data['to_name'] = '';
			$data['to_mail'] = '';
			$data['mailer'] = '';
			$data['smtp_host'] = '';
			$data['smtp_port'] = '';
			$data['smtp_security'] = '';
			$data['smtp_username'] = '';
			$data['smtp_password'] = '';
		}
		
		$datalist = $data;
		
        return view('admin.mail-settings', compact('datalist'));
    }

	//Save data for Mail Settings
    public function saveMailSettings(Request $request){
		$res = array();
		
		$from_name = $request->input('from_name');
		$from_mail = $request->input('from_mail');
		$to_name = $request->input('to_name');
		$to_mail = $request->input('to_mail');
		$mailer = $request->input('mailer');
		
		$smtp_host = $request->input('smtp_host');
		$smtp_port = $request->input('smtp_port');
		$smtp_security = $request->input('smtp_security');
		$smtp_username = $request->input('smtp_username');
		$smtp_password = $request->input('smtp_password');
		
		$is_mail = $request->input('ismail');
		if ($is_mail == 'true' || $is_mail == 'on') {
			$ismail = 1;
		}else {
			$ismail = 0;
		}
		
		//Is SMTP
		if($mailer == 'smtp'){
			$validator_array = array(
				'from_name' => $request->input('from_name'),
				'from_mail' => $request->input('from_mail'),
				'to_name' => $request->input('to_name'),
				'to_mail' => $request->input('to_mail'),
				'mailer' => $request->input('mailer'),
				'smtp_host' => $request->input('smtp_host'),
				'smtp_port' => $request->input('smtp_port'),
				'smtp_security' => $request->input('smtp_security'),
				'smtp_username' => $request->input('smtp_username'),
				'smtp_password' => $request->input('smtp_password')
			);

			$validator = Validator::make($validator_array, [
				'from_name' => 'required',
				'from_mail' => 'required',
				'to_name' => 'required',
				'to_mail' => 'required',
				'mailer' => 'required',
				'smtp_host' => 'required',
				'smtp_port' => 'required',
				'smtp_security' => 'required',
				'smtp_username' => 'required',
				'smtp_password' => 'required'
			]);
		}else{
			$validator_array = array(
				'from_name' => $request->input('from_name'),
				'from_mail' => $request->input('from_mail'),
				'to_name' => $request->input('to_name'),
				'to_mail' => $request->input('to_mail'),
				'mailer' => $request->input('mailer')
			);

			$validator = Validator::make($validator_array, [
				'from_name' => 'required',
				'from_mail' => 'required',
				'to_name' => 'required',
				'to_mail' => 'required',
				'mailer' => 'required'
			]);
		}
		
		$errors = $validator->errors();

		if($errors->has('from_name')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('from_name');
			return response()->json($res);
		}
		if($errors->has('from_mail')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('from_mail');
			return response()->json($res);
		}
		if($errors->has('to_name')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('to_name');
			return response()->json($res);
		}
		if($errors->has('to_mail')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('to_mail');
			return response()->json($res);
		}
		if($errors->has('mailer')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('mailer');
			return response()->json($res);
		}
		
		//IS SMTP
		if($mailer == 'smtp'){
			
			if($errors->has('smtp_host')){
				$res['msgType'] = 'error';
				$res['msg'] = $errors->first('smtp_host');
				return response()->json($res);
			}
			if($errors->has('smtp_port')){
				$res['msgType'] = 'error';
				$res['msg'] = $errors->first('smtp_port');
				return response()->json($res);
			}
			if($errors->has('smtp_security')){
				$res['msgType'] = 'error';
				$res['msg'] = $errors->first('smtp_security');
				return response()->json($res);
			}
			if($errors->has('smtp_username')){
				$res['msgType'] = 'error';
				$res['msg'] = $errors->first('smtp_username');
				return response()->json($res);
			}
			if($errors->has('smtp_password')){
				$res['msgType'] = 'error';
				$res['msg'] = $errors->first('smtp_password');
				return response()->json($res);
			}
		}
		
		$option_value = array(
			'ismail' => $ismail,
			'from_name' => $from_name,
			'from_mail' => $from_mail,
			'to_name' => $to_name,
			'to_mail' => $to_mail,
			'mailer' => $mailer,
			'smtp_host' => $smtp_host,
			'smtp_port' => $smtp_port,
			'smtp_security' => $smtp_security,
			'smtp_username' => $smtp_username,
			'smtp_password' => $smtp_password
		);
		
		$data = array(
			'option_name' => 'mail_settings',
			'option_value' => json_encode($option_value)
		);

		$gData = Tp_option::where('option_name', 'mail_settings')->get();
		$id = '';
		foreach ($gData as $row){
			$id = $row['id'];
		}
		
		if($id == ''){
			$response = Tp_option::create($data);
			if($response){
				$res['msgType'] = 'success';
				$res['msg'] = __('New Data Added Successfully');
			}else{
				$res['msgType'] = 'error';
				$res['msg'] = __('Data insert failed');
			}
		}else{
			$response = Tp_option::where('id', $id)->update($data);
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
}
