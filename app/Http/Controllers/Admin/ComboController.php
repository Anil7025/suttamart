<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pro_category;
use App\Models\Brand;

class ComboController extends Controller
{
	//Get data for Timezone List combo
    public function getTimezoneList(){
		
		$Data = DB::table('timezones')->orderBy('timezone_name', 'asc')->get();
		
		return $Data;
	}
	
	//Get data for User Status List combo
    public function getUserStatusList(){
		
		$Data = DB::table('user_status')->orderBy('id', 'asc')->get();
		
		return $Data;
	}
	
	//Get data for User Roles List combo
    public function getUserRolesList(){
		
		$Data = DB::table('admins')->orderBy('id', 'asc')->get();
		
		return $Data;
	}
	
	//Get data for status List combo
    public function getStatusList(){
		
		$Data = DB::table('dp__statuses')->orderBy('id', 'asc')->get();
		
		return $Data;
	}
	
	//Get data for Category List combo
    public function getCategoryList(Request $request){
		$Data = Pro_category::select('id', 'name')
			->where('is_publish', '=', 1)
			->orderBy('name','asc')
			->get();
		
		return $Data;
	}
	
	//Get data for Brand List combo
    public function getBrandList(Request $request){
		$lan = $request->lan;

		$Data = Brand::select('id', 'name')
			->where('is_publish', '=', 1)
			->orderBy('name','asc')
			->get();

		return $Data;
	}
}