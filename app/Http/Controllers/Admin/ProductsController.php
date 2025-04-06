<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\Pro_category;
use App\Models\Brand;
use App\Models\Tax;
use App\Models\Attribute;
use App\Models\Pro_image;
use App\Models\Related_product;

class ProductsController extends Controller
{
    //Products page load
    public function getProductsPageLoad() {
		
		$AllCount = Product::count();
		$PublishedCount = Product::where('is_publish', '=', 1)->count();
		$DraftCount = Product::where('is_publish', '=', 2)->count();
		
		$brandlist = Brand::where('is_publish', 1)->orderBy('name','asc')->get();
		$categorylist = Pro_category::where('is_publish', 1)->orderBy('name','asc')->get();

		$storeList = DB::table('shops')
			->where('shops.is_publish', '=', 1)
			->orderBy('shops.name','asc')
			->get();
			
		$datalist = DB::table('products')
			->join('dp__statuses', 'products.is_publish', '=', 'dp__statuses.id')
			->join('pro_categories', 'products.cat_id', '=', 'pro_categories.id')
			->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
			->join('Shops', 'products.shop_id', '=', 'Shops.id')
			->select('products.*', 'pro_categories.name as category_name', 'brands.name as brand_name','Shops.name as shop_name', 'dp__statuses.status')
			->orderBy('products.id','desc')
			->paginate(20);

        return view('admin.products', compact('AllCount', 'PublishedCount', 'DraftCount', 'categorylist', 'brandlist', 'storeList', 'datalist'));		
	}
	
	//Get data for Products Pagination
	public function getProductsTableData(Request $request){

		$search = $request->search;
		$status = $request->status;
		$category_id = $request->category_id;
		$brand_id = $request->brand_id;
		$shop_id = $request->store_id;

		if($request->ajax()){

			if($search != ''){
				$datalist = DB::table('products')
					->join('dp__statuses', 'products.is_publish', '=', 'dp__statuses.id')
					->join('pro_categories', 'products.cat_id', '=', 'pro_categories.id')
					->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
					->join('Shops', 'products.shop_id', '=', 'Shops.id')
					->select('products.*', 'pro_categories.name as category_name', 'brands.name as brand_name', 'dp__statuses.status','Shops.name as shop_name')
					->where(function ($query) use ($search){
						$query->where('products.title', 'like', '%'.$search.'%')
							->orWhere('pro_categories.name', 'like', '%'.$search.'%')
							->orWhere('brands.name', 'like', '%'.$search.'%')
							->orWhere('Shops.name', 'like', '%'.$search.'%')
							->orWhere('cost_price', 'like', '%'.$search.'%');
					})
					
					->where(function ($query) use ($status){
						$query->whereRaw("products.is_publish = '".$status."' OR '".$status."' = '0'");
					})
					->where(function ($query) use ($category_id){
						$query->whereRaw("products.cat_id = '".$category_id."' OR '".$category_id."' = '0'");
					})
					->where(function ($query) use ($brand_id){
						$query->whereRaw("products.brand_id = '".$brand_id."' OR '".$brand_id."' = 'all'");
					})
					->where(function ($query) use ($shop_id){
						$query->whereRaw("products.shop_id = '".$shop_id."' OR '".$shop_id."' = '0'");
					})
					->orderBy('products.id','desc')
					->paginate(20);
			}else{

				$datalist = DB::table('products')
					->join('dp__statuses', 'products.is_publish', '=', 'dp__statuses.id')
					->join('pro_categories', 'products.cat_id', '=', 'pro_categories.id')
					->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
					->join('Shops', 'products.shop_id', '=', 'Shops.id')
					->select('products.*', 'pro_categories.name as category_name', 'brands.name as brand_name', 'dp__statuses.status', 'Shops.name as shop_name')
					->join('users', 'products.shop_id', '=', 'users.id')
					->where(function ($query) use ($status){
						$query->whereRaw("products.is_publish = '".$status."' OR '".$status."' = '0'");
					})
					->where(function ($query) use ($category_id){
						$query->whereRaw("products.cat_id = '".$category_id."' OR '".$category_id."' = '0'");
					})
					->where(function ($query) use ($brand_id){
						$query->whereRaw("products.brand_id = '".$brand_id."' OR '".$brand_id."' = 'all'");
					})
					->where(function ($query) use ($shop_id){
						$query->whereRaw("products.shop_id = '".$shop_id."' OR '".$shop_id."' = '0'");
					})
					
					->orderBy('products.id','desc')
					->paginate(20);
			}

			return view('admin.partials.products_table', compact('datalist'))->render();
		}
	}

	//Save data for Products
    public function saveProductsData(Request $request){
		$res = array();

		$id = $request->input('RecordId');
		$title = esc($request->input('title'));
		$slug = esc(str_slug($request->input('slug')));
		$cat_id = $request->input('categoryid');
		$brand_id = $request->input('brandid');
		$shop_id = $request->input('storeid');
		
		$validator_array = array(
			'product_name' => $request->input('title'),
			'slug' => $slug,
			'category' => $request->input('categoryid'),
			'brand' => $request->input('brandid'),
			'shop' => $request->input('storeid')
		);
		
		$rId = $id == '' ? '' : ','.$id;
		$validator = Validator::make($validator_array, [
			'product_name' => 'required',
			'slug' => 'required|max:191|unique:products,slug' . $rId,
			'category' => 'required',
			'brand' => 'required',
			'shop' => 'required'
		]);

		$errors = $validator->errors();

		if($errors->has('product_name')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('product_name');
			return response()->json($res);
		}
		
		if($errors->has('slug')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('slug');
			return response()->json($res);
		}

		if($errors->has('category')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('category');
			return response()->json($res);
		}
		
		if($errors->has('brand')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('brand');
			return response()->json($res);
		}
		
		if($errors->has('shop')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('shop');
			return response()->json($res);
		}

		$data = array(
			'title' => $title,
			'slug' => $slug,
			'cat_id' => $cat_id,
			'category_ids' => $cat_id,
			'brand_id' => $brand_id,
			'shop_id' => $shop_id,
			'is_publish' => 2
		);

		
		if($id ==''){
			$response = Product::create($data)->id;
			if($response){
				$res['id'] = $response;
				$res['msgType'] = 'success';
				$res['msg'] = __('New Data Added Successfully');
			}else{
				$res['id'] = '';
				$res['msgType'] = 'error';
				$res['msg'] = __('Data insert failed');
			}
		}else{
			$response = Product::where('id', $id)->update($data);
			if($response){

				$res['id'] = $id;
				$res['msgType'] = 'success';
				$res['msg'] = __('Data Updated Successfully');
			}else{
				$res['id'] = '';
				$res['msgType'] = 'error';
				$res['msg'] = __('Data update failed');
			}
		}
		
		return response()->json($res);
    }
	
	//Delete data for Products
	public function deleteProducts(Request $request){
		
		$res = array();

		$id = $request->id;

		if($id != ''){
			Pro_image::where('product_id', $id)->delete();
			Related_product::where('product_id', $id)->delete();
			$response = Product::where('id', $id)->delete();
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
	
	//Bulk Action for Products
	public function bulkActionProducts(Request $request){
		
		$res = array();

		$idsStr = $request->ids;
		$idsArray = explode(',', $idsStr);
		
		$BulkAction = $request->BulkAction;

		if($BulkAction == 'publish'){
			$response = Product::whereIn('id', $idsArray)->update(['is_publish' => 1]);
			if($response){
				$res['msgType'] = 'success';
				$res['msg'] = __('Data Updated Successfully');
			}else{
				$res['msgType'] = 'error';
				$res['msg'] = __('Data update failed');
			}
			
		}elseif($BulkAction == 'draft'){
			
			$response = Product::whereIn('id', $idsArray)->update(['is_publish' => 2]);
			if($response){
				$res['msgType'] = 'success';
				$res['msg'] = __('Data Updated Successfully');
			}else{
				$res['msgType'] = 'error';
				$res['msg'] = __('Data update failed');
			}
			
		}elseif($BulkAction == 'delete'){
			
			Pro_image::whereIn('product_id', $idsArray)->delete();
			Related_product::whereIn('product_id', $idsArray)->delete();
			
			$response = Product::whereIn('id', $idsArray)->delete();
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
	
	//has Product Slug
    public function hasProductSlug(Request $request){
		$res = array();
		
		$slug = str_slug($request->slug);
        $count = Product::where('slug', $slug) ->count();
		if($count == 0){
			$res['slug'] = $slug;
		}else{
			$incr = $count+1;
			$res['slug'] = $slug.'-'.$incr;
		}
		
		return response()->json($res);
	}
	
    //get Product
    public function getProductPageData($id){
		
		$datalist = Product::where('id', $id)->first();
		
		$statuslist = DB::table('dp__statuses')->orderBy('id', 'asc')->get();
		
		$brandlist = Brand::where('is_publish', '=', 1)->orderBy('name','asc')->get();
		$categorylist = Pro_category::where('is_publish', '=', 1)->orderBy('name','asc')->get();
		
		$taxlist = Tax::orderBy('title','asc')->get();
		$unitlist = Attribute::orderBy('name','asc')->get();
		
		$storeList = DB::table('shops')
			->select('shops.id', 'shops.name')
			->where('shops.is_publish', '=', 1)
			->orderBy('shops.name','asc')
			->get();
			
        return view('admin.product', compact('datalist', 'statuslist',  'brandlist', 'categorylist', 'taxlist', 'storeList', 'unitlist'));
    }
	
	//Update data for Products
    public function updateProductsData(Request $request){
		$res = array();
		$id = $request->input('RecordId');
		$title = esc($request->input('title'));
		$slug = esc(str_slug($request->input('slug')));
		$short_desc = $request->input('short_desc');
		$description = $request->input('description');
		$tax_id = $request->input('tax_id');
		$collection_id = $request->input('collection_id');
		$is_featured = $request->input('is_featured');
		$is_publish = $request->input('is_publish');
		$storeid = $request->input('storeid');
		$variation_size = $request->input('variation_size');
		$sale_price = $request->input('sale_price');
		
		$validator_array = array(
			'product_name' => $request->input('title'),
			'slug' => $slug,
			'image' => $request->input('image'),
			'imagess' => $request->input('image2'),
			'status' => $request->input('is_publish'),
			'storeid' => $request->input('storeid'),
			'sale_price' => $request->input('sale_price'),
			
		);
		
		$rId = $id == '' ? '' : ','.$id;
		$validator = Validator::make($validator_array, [
			'product_name' => 'required',
			'slug' => 'required|max:191|unique:products,slug' . $rId,
			'status' => 'required',
			'storeid' => 'required',
			'sale_price' => 'required',
			'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // Image validation (optional)
        	'imagess' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // Image validation (optional)
		]);

		$errors = $validator->errors();

		if($errors->has('product_name')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('product_name');
			return response()->json($res);
		}
		
		if($errors->has('slug')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('slug');
			return response()->json($res);
		}
		
		if($errors->has('image')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('image');
			return response()->json($res);
		}
		
		if($errors->has('imagess')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('imagess');
			return response()->json($res);
		}

		if($errors->has('status')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('status');
			return response()->json($res);
		}
		
		if($errors->has('storeid')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('storeid');
			return response()->json($res);
		}
		
		if($errors->has('sale_price')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('sale_price');
			return response()->json($res);
		}
		$imageName ='';
			// Handle Image Upload
			if ($request->hasFile('image')) {
				$image = $request->file('image');
				
				$imageName = time() . '.' . $image->getClientOriginalExtension();
				$imagePath = 'uploads/products/' . $imageName;
				
				// Move the image to the public folder
				$image->move(public_path('uploads/products/'), $imageName);
			}
			$imageNames ='';
			// Handle Image Upload
			if ($request->hasFile('imagess')) {
				$image2 = $request->file('imagess');
				
				$imageNamess = time() . '.' . $image2->getClientOriginalExtension();
				$imagePath2 = 'uploads/products/image2/' . $imageNamess;
				
				// Move the image to the public folder
				$image2->move(public_path('uploads/products/image2/'), $imageNamess);
			}
			
		$data = array(
			'title' => $title,
			'slug' => $slug,
			'image' => $imageName,
			'image2' => $imageNamess,
			'short_desc' => $short_desc,
			'description' => $description,
			'tax_id' => $tax_id,
			'collection_id' => $collection_id,
			'is_featured' => $is_featured,
			'is_publish' => $is_publish,
			'shop_id' => $storeid,
			'variation_size' => $variation_size,
			'sale_price' => $sale_price,
			'user_fullName' => 'admin',
		);
		
		$response = Product::where('id', $id)->update($data);
		if($response){
			
			//Update Parent and Child Menu
			gMenuUpdate($id, 'product', $title, $slug);
			$res['id'] = $id;
			$res['msgType'] = 'success';
			$res['msg'] = __('Data Updated Successfully');
		}else{
			$res['msgType'] = 'error';
			$res['msg'] = __('Data update failed');
		}
		
		return response()->json($res);
    }
	
    //get Price
    public function getPricePageData($id){
		
		$datalist = Product::where('id', $id)->first();

        return view('admin.price', compact('datalist'));
    }
	
	//Save data for Price
    public function savePriceData(Request $request){
		$res = array();

		$id = $request->input('RecordId');
		$cost_price = $request->input('cost_price');
		$sale_price = $request->input('sale_price');
		$old_price = $request->input('old_price');
		$start_date = date("Y-m-d");
		$end_date = $request->input('end_date');
		$is_discount = $request->input('is_discount');

		$validator_array = array(
			'sale_price' => $sale_price
		);
		
		$validator = Validator::make($validator_array, [
			'sale_price' => 'required'
		]);

		$errors = $validator->errors();
		
		if($errors->has('sale_price')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('sale_price');
			return response()->json($res);
		}
		
		if($end_date == ''){
			$data = array(
				'cost_price' => $cost_price,
				'sale_price' => $sale_price,
				'old_price' => $old_price,
				'start_date' => NULL,
				'end_date' => NULL,
				'is_discount' => $is_discount
			);
		}else{
			$data = array(
				'cost_price' => $cost_price,
				'sale_price' => $sale_price,
				'old_price' => $old_price,
				'start_date' => $start_date,
				'end_date' => $end_date,
				'is_discount' => $is_discount
			);
		}
		
		$response = Product::where('id', $id)->update($data);
		if($response){
			$res['id'] = $id;
			$res['msgType'] = 'success';
			$res['msg'] = __('Data Updated Successfully');
		}else{
			$res['msgType'] = 'error';
			$res['msg'] = __('Data update failed');
		}
		
		return response()->json($res);
    }
	
    //get Inventory
    public function getInventoryPageData($id){
		
		$datalist = Product::where('id', $id)->first();

        return view('admin.inventory', compact('datalist'));
    }
	
	//Save data for Inventory
    public function saveInventoryData(Request $request){
		$res = array();

		$id = $request->input('RecordId');
		$is_stock = $request->input('is_stock');
		$stock_status_id = $request->input('stock_status_id');
		$sku = $request->input('sku');
		$stock_qty = $request->input('stock_qty');

		$data = array(
			'is_stock' => $is_stock,
			'stock_status_id' => $stock_status_id,
			'sku' => $sku,
			'stock_qty' => $stock_qty
		);
		
		$response = Product::where('id', $id)->update($data);
		if($response){
			$res['id'] = $id;
			$res['msgType'] = 'success';
			$res['msg'] = __('Data Updated Successfully');
		}else{
			$res['msgType'] = 'error';
			$res['msg'] = __('Data update failed');
		}
		
		return response()->json($res);
    }
	
    //get Product Images
    public function getProductImagesPageData($id){
		
		$datalist = Product::where('id', $id)->first();
		$imagelist = Pro_image::where('product_id', $id)->orderBy('id','desc')->paginate(15);
		
        return view('admin.product-images', compact('datalist', 'imagelist'));
    }
	
	//Get data for Product Images Pagination
	public function getProductImagesTableData(Request $request)
{
    $id = $request->id;

    if ($request->ajax()) {
        $imagelist = Pro_image::where('product_id', $id)
            ->orderBy('id', 'desc')
            ->paginate(15);

        return response()->json([
            'html' => view('admin.partials.product_images_list', compact('imagelist'))->render(),
            'pagination' => (string) $imagelist->links()
        ]);
    }
}

	

public function saveProductImagesData(Request $request) {
    $res = array();
    $product_id = $request->input('product_id');

    // Debugging: Log product_id to check if it's being received
    if (!$product_id) {
        return response()->json([
            'msgType' => 'error',
            'msg' => __('Product ID is missing!')
        ]);
    }

    // Validate images
    $validator = Validator::make($request->all(), [
        'images' => 'required|array', // Ensure images is an array
        'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // Validate each image
    ]);

    if ($validator->fails()) {
        return response()->json([
            'msgType' => 'error',
            'msg' => $validator->errors()->first()
        ]);
    }

    $imagePaths = [];

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $index => $image) {
            // Use a unique filename to prevent overwriting
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $imagePath = 'uploads/product-images/' . $imageName;
            
            // Move the image to public folder
            $image->move(public_path('uploads/product-images/'), $imageName);

            // Store file name in the array
            $imagePaths[] = $imageName;

            // Save image info in the database
            Pro_image::create([
                'product_id' => $product_id,
                'thumbnail' => $imageName,
                'large_image' => $imageName
            ]);
        }
    }

    return response()->json([
        'id' => $product_id,
        'msgType' => 'success',
        'msg' => __('Images uploaded successfully!'),
        'images' => $imagePaths
    ]);
}
	
	//Delete data for Product Images
	public function deleteProductImages(Request $request)
	{
		$res = [];
		$request->validate(['id' => 'required|integer']);

		$image = Pro_image::find($request->id);

		if ($image) {
			$imagePath = public_path('uploads/product-images/' . $image->image);
			if (file_exists($imagePath)) {
				unlink($imagePath);
			}
			$image->delete();

			return response()->json([
				'msgType' => 'success',
				'msg' => __('Image deleted successfully!')
			]);
		}

		return response()->json([
			'msgType' => 'error',
			'msg' => __('Image not found!')
		]);
	}


    //get Variations
    public function getVariationsPageData($id){
		
		$datalist = Product::where('id', $id)->first();
		$sizelist = Attribute::where('att_type', 'Size')->orderBy('id','asc')->get();
		$colorlist = Attribute::where('att_type', 'Color')->orderBy('id','asc')->get();
		
        return view('admin.variations', compact('datalist', 'sizelist', 'colorlist'));
    }
	
	//Save data for Variations
    public function saveVariationsData(Request $request){
		$res = array();

		$id = $request->input('RecordId');
		$sizes = $request->input('variation_size');
		$colors = $request->input('variation_color');

		$variation_size = NULL;
		$i = 0;
		if($sizes !=''){
			foreach ($sizes as $key => $size) {
				if($i++){
					$variation_size .= ',';
				}
				$variation_size .= $size;
			}
		}
		
		$variation_color = NULL;
		$f = 0;
		if($colors !=''){
			foreach ($colors as $key => $color) {
				if($f++){
					$variation_color .= ',';
				}
				$variation_color .= $color;
			}
		}
		$data = array(
			'variation_size' => $variation_size,
			'variation_color' => $variation_color
		);
		
		$response = Product::where('id', $id)->update($data);
		if($response){
			$res['msgType'] = 'success';
			$res['msg'] = __('Data Updated Successfully');
		}else{
			$res['msgType'] = 'error';
			$res['msg'] = __('Data update failed');
		}
		
		return response()->json($res);
    }
	
    //get Product SEO
    public function getProductSEOPageData($id){
		
		$datalist = Product::where('id', $id)->first();
		
        return view('admin.product-seo', compact('datalist'));
	}
	
	//Save data for Product SEO
    public function saveProductSEOData(Request $request){
		$res = array();

		$id = $request->input('RecordId');
		$og_title = $request->input('og_title');
		$og_description = $request->input('og_description');
		$og_keywords = $request->input('og_keywords');

		$data = array(
			'og_title' => $og_title,
			'og_description' => $og_description,
			'og_keywords' => $og_keywords
		);
		
		$response = Product::where('id', $id)->update($data);
		if($response){
			$res['msgType'] = 'success';
			$res['msg'] = __('Data Updated Successfully');
		}else{
			$res['msgType'] = 'error';
			$res['msg'] = __('Data update failed');
		}
		
		return response()->json($res);
    }
	
    //get Related Products
    public function getRelatedProductsPageData($id){
		
		$datalist = Product::where('id', $id)->first();
		
		$productlist = DB::table('products')
			->join('dp__statuses', 'products.is_publish', '=', 'dp__statuses.id')
			->select('products.id', 'products.title', 'products.image', 'products.image2', 'products.cost_price', 'products.sale_price', 'products.is_stock', 'products.is_publish', 'dp__statuses.status')
			->whereNotIn('products.id', [$id])
			->where('products.is_publish', 1)
			->orderBy('products.id','desc')
			->paginate(20);
			
		$relateddatalist = DB::table('products')
			->join('dp__statuses', 'products.is_publish', '=', 'dp__statuses.id')
			->join('related_products', 'products.id', '=', 'related_products.related_item_id')
			->select('related_products.id', 'products.title', 'products.image', 'products.image2', 'products.is_publish', 'dp__statuses.status')
			->where('related_products.product_id', $id)
			->where('products.is_publish', 1)
			->orderBy('related_products.id','desc')
			->paginate(20);
			
        return view('admin.related-products', compact('datalist', 'productlist', 'relateddatalist'));
    }
	
	//Get data for Products Pagination Related Products
	public function getProductListForRelatedTableData(Request $request){

		$search = $request->search;
		$id = $request->product_id;
		
		if($request->ajax()){

			if($search != ''){
				$productlist = DB::table('products')
					->join('dp__statuses', 'products.is_publish', '=', 'dp__statuses.id')
					->select('products.id', 'products.title', 'products.image', 'products.image2', 'products.cost_price', 'products.sale_price', 'products.is_stock', 'products.is_publish', 'dp__statuses.status',)
					->where(function ($query) use ($search){
						$query->where('title', 'like', '%'.$search.'%')
							->orWhere('cost_price', 'like', '%'.$search.'%');
					})
					->whereNotIn('products.id', [$id])
					->where('products.is_publish', 1)
					->orderBy('products.id','desc')
					->paginate(20);
			}else{
				$productlist = DB::table('products')
					->join('dp__statuses', 'products.is_publish', '=', 'dp__statuses.id')
					->select('products.id', 'products.title', 'products.image', 'products.image2', 'products.cost_price', 'products.sale_price', 'products.is_stock', 'products.is_publish', 'dp__statuses.status')
					->whereNotIn('products.id', [$id])
					->where('products.is_publish', 1)
					->orderBy('products.id','desc')
					->paginate(20);
			}

			return view('admin.partials.products_list_for_related_product', compact('productlist'))->render();
		}
	}
	
	//Get data for Related Products Pagination
	public function getRelatedProductTableData(Request $request){

		$search = $request->search;
		$id = $request->product_id;
		
		if($request->ajax()){

			if($search != ''){
				$relateddatalist = DB::table('products')
					->join('dp__statuses', 'products.is_publish', '=', 'dp__statuses.id')
					->join('related_products', 'products.id', '=', 'related_products.related_item_id')
					->select('related_products.id', 'products.title', 'products.image', 'products.image2', 'products.is_publish', 'dp__statuses.status')
					->where(function ($query) use ($search){
						$query->where('title', 'like', '%'.$search.'%');
					})
					->where('related_products.product_id', $id)
					->where('products.is_publish', 1)
					->orderBy('related_products.id','desc')
					->paginate(20);
			}else{
				$relateddatalist = DB::table('products')
					->join('dp__statuses', 'products.is_publish', '=', 'dp__statuses.id')
					->join('related_products', 'products.id', '=', 'related_products.related_item_id')
					->select('related_products.id', 'products.title', 'products.image', 'products.image2', 'products.is_publish', 'dp__statuses.status')
					->where('related_products.product_id', $id)
					->where('products.is_publish', 1)
					->orderBy('related_products.id','desc')
					->paginate(20);
			}

			return view('admin.partials.related_products_table', compact('relateddatalist'))->render();
		}
	}
	
	//Save data for Related Products
    public function saveRelatedProductsData(Request $request){
		$res = array();

		$product_id = $request->input('product_id');
		$related_item_id = $request->input('related_item_id');

		$data = array(
			'product_id' => $product_id,
			'related_item_id' => $related_item_id
		);
		
		$response = Related_product::create($data);
		if($response){
			$res['id'] = $product_id;
			$res['msgType'] = 'success';
			$res['msg'] = __('New Data Added Successfully');
		}else{
			$res['msgType'] = 'error';
			$res['msg'] = __('Data insert failed');
		}
		
		return response()->json($res);
    }
	
	//Delete data for Related Product
	public function deleteRelatedProduct(Request $request){
		$res = array();

		$id = $request->id;

		$response = Related_product::where('id', $id)->delete();
		if($response){
			$res['msgType'] = 'success';
			$res['msg'] = __('Data Removed Successfully');
		}else{
			$res['msgType'] = 'error';
			$res['msg'] = __('Data remove failed');
		}
		
		return response()->json($res);
	}	
}
