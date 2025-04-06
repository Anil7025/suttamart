<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Offer_ad;

class Offer_adsController extends Controller
{
    //Offer Ads page load
    public function getOfferAdsPageLoad() {
		
		$statuslist = DB::table('dp__statuses')->orderBy('id', 'asc')->get();
		
		$datalist = DB::table('offer_ads')
			->join('dp__statuses', 'offer_ads.is_publish', '=', 'dp__statuses.id')
			->select('offer_ads.id', 'offer_ads.offer_ad_type', 'offer_ads.title', 'offer_ads.url', 'offer_ads.image', 'offer_ads.description', 'offer_ads.is_publish', 'dp__statuses.status')
			->orderBy('offer_ads.id','desc')
			->paginate(10);

        return view('admin.offer-ads', compact( 'statuslist', 'datalist'));
    }

	//Get data for Offer Ads Pagination
	public function getOfferAdsTableData(Request $request)
    {
        $search = $request->search;

        if ($request->ajax()) {
            // Start Query
            $datalist = DB::table('offer_ads')
                ->join('dp__statuses', 'offer_ads.is_publish', '=', 'dp__statuses.id')
                ->select(
                    'offer_ads.id', 
                    'offer_ads.offer_ad_type',  
                    'offer_ads.title', 
                    'offer_ads.url', 
                    'offer_ads.image', 
                    'offer_ads.description', 
                    'offer_ads.is_publish', 
                    'dp__statuses.status'
                )
                ->orderBy('offer_ads.id', 'desc');

            // Apply Search Filter if needed
            if (!empty($search)) {
                $datalist->where(function ($query) use ($search) {
                    $query->where('offer_ads.title', 'like', '%' . $search . '%')
                        ->orWhere('offer_ads.url', 'like', '%' . $search . '%');
                });
            }

            // Paginate Data
            $datalist = $datalist->paginate(10);

            // Render View
            return view('admin.partials.offer_ads_table', compact('datalist'))->render();
        }
    }

	
	//Save data for Offer Ads
    public function saveOfferAdsData(Request $request){
		$res = array();
		
		$id = $request->input('RecordId');
		$title = $request->input('title');
        $description = $request->input('description');
		$offer_ad_type = $request->input('offer_ad_type');
		$url = $request->input('url');
		$image = $request->input('image');
		$is_publish = $request->input('is_publish');
		
		$validator_array = array(
			'image' => $request->input('image'),
			'is_publish' => $request->input('is_publish')
		);
		
		$validator = Validator::make($validator_array, [
			'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
			'is_publish' => 'required'
		]);

		$errors = $validator->errors();

		if($errors->has('image')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('image');
			return response()->json($res);
		}
		
		if($errors->has('is_publish')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('is_publish');
			return response()->json($res);
		}
		
		$imageName ='';
			// Handle Image Upload
			if ($request->hasFile('image')) {
				$image = $request->file('image');
				
				$imageName = time() . '.' . $image->getClientOriginalExtension();
				$imagePath = 'uploads/offerimages/' . $imageName;
				
				// Move the image to the public folder
				$image->move(public_path('uploads/offerimages/'), $imageName);
			}
			$existingRecord = Offer_ad::where('title', $title)->first();

			if (!$id && $existingRecord) {
				return response()->json(['msgTypes' => 'error', 'msg' => __('offer ads image with this title already exists')]);
			}
		$data = array(
			'offer_ad_type' => $offer_ad_type,
			'title' => $title,
			'url' => $url,
			'image' => $imageName ?: ($existingRecord->image ?? null),
			'description' => $description,
			'is_publish' => $is_publish
		);

		if($id ==''){
			$response = Offer_ad::create($data);
			if($response){
				$res['msgType'] = 'success';
				$res['msg'] = __('New Data Added Successfully');
			}else{
				$res['msgType'] = 'error';
				$res['msg'] = __('Data insert failed');
			}
		}else{
			$response = Offer_ad::where('id', $id)->update($data);
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
	
	//Get data for Offer Ads by id
    public function getOfferAdsById(Request $request){

		$id = $request->id;
		
		$data = Offer_ad::where('id', $id)->first();
		
		return response()->json($data);
	}
	
	//Delete data for Offer Ads
	public function deleteOfferAds(Request $request){
		
		$res = array();

		$id = $request->id;

		if($id != ''){
			$response = Offer_ad::where('id', $id)->delete();
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
	
	//Bulk Action for Offer Ads
	public function bulkActionOfferAds(Request $request){
		
		$res = array();

		$idsStr = $request->ids;
		$idsArray = explode(',', $idsStr);
		
		$BulkAction = $request->BulkAction;

		if($BulkAction == 'publish'){
			$response = Offer_ad::whereIn('id', $idsArray)->update(['is_publish' => 1]);
			if($response){
				$res['msgType'] = 'success';
				$res['msg'] = __('Data Updated Successfully');
			}else{
				$res['msgType'] = 'error';
				$res['msg'] = __('Data update failed');
			}
			
		}elseif($BulkAction == 'draft'){
			
			$response = Offer_ad::whereIn('id', $idsArray)->update(['is_publish' => 2]);
			if($response){
				$res['msgType'] = 'success';
				$res['msg'] = __('Data Updated Successfully');
			}else{
				$res['msgType'] = 'error';
				$res['msg'] = __('Data update failed');
			}
			
		}elseif($BulkAction == 'delete'){
			$response = Offer_ad::whereIn('id', $idsArray)->delete();
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
