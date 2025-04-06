<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Page;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    public function getAllPageData(){
		
		$statuslist = DB::table('dp__statuses')->orderBy('id', 'asc')->get();
		$AllCount = Page::count();
		$PublishedCount = Page::where('is_publish', '=', 1)->count();
		$DraftCount = Page::where('is_publish', '=', 2)->count();

		$datalist = DB::table('pages')
			->join('dp__statuses', 'pages.is_publish', '=', 'dp__statuses.id')
			->select('pages.*', 'dp__statuses.status')
			->orderBy('pages.id','desc')
			->paginate(20);
		
        return view('admin.page', compact('AllCount', 'PublishedCount', 'DraftCount', 'datalist', 'statuslist'));
    }
	
	//Get data for Page Pagination
	public function getPagePaginationData(Request $request){

		$search = $request->search;
		$post_status = $request->post_status;
		
		if($request->ajax()){
			if($search != ''){
				$datalist = DB::table('pages')
					->join('dp__statuses', 'pages.is_publish', '=', 'dp__statuses.id')
					->select('pages.*', 'dp__statuses.status')
					->where(function ($query) use ($search){
						$query->where('title', 'like', '%'.$search.'%')
							->orWhere('slug', 'like', '%'.$search.'%');
					})
					->orderBy('pages.id','desc')
					->paginate(20);
			}else{
				$datalist = DB::table('pages')
					->join('dp__statuses', 'pages.is_publish', '=', 'dp__statuses.id')
					->select('pages.*', 'dp__statuses.status')
					->where(function ($query) use ($post_status){
						$query->whereRaw("pages.is_publish = '".$post_status."' OR '".$post_status."' = '0'");
					})
					->orderBy('pages.id','desc')
					->paginate(20);
			}

			return view('admin.partials.page_table', compact('datalist'))->render();
		}
	}
	
    public function savePageData(Request $request)
    {
        $id = $request->input('RecordId');
        $title = e($request->input('title'));
        $slug = $request->input('slug');
        $sortcontent = $request->input('sortcontent');
        $description = $request->input('content');
        $is_publish = $request->input('is_publish');
        $image = $request->input('image');

        // Validation
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'sortcontent' => 'required',
            'content' => 'required',
            'slug' => 'required|max:191|unique:pages,slug' . ($id ? ",$id" : ''),
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validate image file
        ]);

        if ($validator->fails()) {
            return response()->json([
                'id' => '',
                'msgType' => 'error',
                'msg' => $validator->errors()->first(),
            ]);
        }

        // Handle Image Upload
        $image_path = '';
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image_path = $image->storeAs('media/pages', $imageName, 'public');
        }

        // Prepare Data for Insertion/Update
        $data = [
            'title' => $title,
            'slug' => $slug,
            'content' => $sortcontent,
            'description' => $description,
            'is_publish' => $is_publish,
            'image' => $image_path,
            'og_title' => $title,
            'og_description' => $sortcontent,
            'og_keywords' => $title,
        ];

        // Insert or Update Record
        if (!$id) {
            $response = Page::create($data);
            $message = $response ? 'New Data Added Successfully' : 'Data insert failed';
            $status = $response ? 'success' : 'error';
        } else {
            $response = Page::where('id', $id)->update($data);
            $message = $response ? 'Data Updated Successfully' : 'Data update failed';
            $status = $response ? 'success' : 'error';

            // Update Parent and Child Menu
            if ($response) {
                gMenuUpdate($id, 'page', $title, $slug);
            }
        }

        return response()->json([
            'id' => $response ? ($id ?? $response->id) : '',
            'msgType' => $status,
            'msg' => __($message),
        ]);
    }
	//has Page Title Slug
    public function hasPageTitleSlug(Request $request){
		$res = array();
		
		$slug = str_slug($request->slug);
        $count = Page::where('slug', 'like', '%'.$slug.'%') ->count();
		if($count == 0){
			$res['slug'] = $slug;
		}else{
			$incr = $count+1;
			$res['slug'] = $slug.'-'.$incr;
		}
		
		return response()->json($res);
	}
	
	//Get data for Page by id
    public function getPageById(Request $request){

		$id = $request->id;
		
		$data = Page::where('id', $id)->first();
		
		return response()->json($data);
	}
	
	//Delete data for Page
	public function deletePage(Request $request){
		$res = array();

		$id = $request->id;

		if($id != ''){
			$response = Page::where('id', $id)->delete();
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
	
	//Bulk Action for Page
	public function bulkActionPage(Request $request){
		
		$res = array();

		$idsStr = $request->ids;
		$idsArray = explode(',', $idsStr);
		
		$BulkAction = $request->BulkAction;

		if($BulkAction == 'publish'){
			$response = Page::whereIn('id', $idsArray)->update(['is_publish' => 1]);
			if($response){
				$res['msgType'] = 'success';
				$res['msg'] = __('Data Updated Successfully');
			}else{
				$res['msgType'] = 'error';
				$res['msg'] = __('Data update failed');
			}
			
		}elseif($BulkAction == 'draft'){
			
			$response = Page::whereIn('id', $idsArray)->update(['is_publish' => 2]);
			if($response){
				$res['msgType'] = 'success';
				$res['msg'] = __('Data Updated Successfully');
			}else{
				$res['msgType'] = 'error';
				$res['msg'] = __('Data update failed');
			}
			
		}elseif($BulkAction == 'delete'){
			$response = Page::whereIn('id', $idsArray)->delete();
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
