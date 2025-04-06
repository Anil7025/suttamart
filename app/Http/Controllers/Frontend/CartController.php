<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product; 
use App\Models\User;
use App\Models\Pro_category;
use App\Models\Brand;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
	public function AddToCart(Request $request) {
		$id = $request->id;
		$qty = $request->qty ?? 1;

		if (!$id) {
			return response()->json(['msgType' => 'error', 'msg' => __('Invalid Product ID')]);
		}

		// Get product details
		$product = Product::find($id);
		if (!$product) {
			return response()->json(['msgType' => 'error', 'msg' => __('Product not found')]);
		}

		$category = Pro_category::find($product->cat_id);
		$brand = Brand::find($product->brand_id);

		// Retrieve existing cart from session
		$cart = session()->get('shopping_cart', []);

		// Check if product already exists in cart
		if (isset($cart[$id])) {
			// If already in cart, do not increment on duplicate request
			$cart[$id]['qty'] = max($cart[$id]['qty'], $qty);
		} else {
			// Otherwise, add to cart
			$cart[$id] = [
				"id" => $product->id,
				"name" => $product->title,
				"qty" => $qty,
				"price" => $product->sale_price,
				"weight" => 0,
				"image" => $product->image,
				"image2" => $product->image2,
				"unit" => $product->variation_size,
				"cat_name" => $category ? $category->name : '',
				"cat_image" => $category ? $category->image : '',
				"brand_name" => $brand ? $brand->name : '',
				"brand_logo" => $brand ? $brand->thumbnail : '',
			];
		}

		// Save cart back to session
		session()->put('shopping_cart', $cart);
		session()->save(); // Ensure session writes before next request

		//✅ Prevent multiple log entries
		if (!session()->has('cart_logged')) {
			Log::info('Updated Cart Session:', session()->get('shopping_cart'));
			session()->put('cart_logged', true);
		}

		return response()->json([
			'msgType' => 'success',
			'msg' => __('Product added to cart successfully'),
			'cart' => $cart,
		]);
	}

	//Add to Cart
	public function ViewCart(){
		$gtext = gtext();
		$gtax = getTax();
		$taxRate = $gtax['percentage'];
		$Path = asset('uploads/products');

		$ShoppingCartData = session()->get('shopping_cart');
		$count = 0;
		$Total_Price = 0;
		$Sub_Total = 0;
		$tax = 0;
		$total = 0;
		$items = '';
		if(session()->get('shopping_cart')){
			foreach ($ShoppingCartData as $row) {
				$count += $row['qty'];
				$Total_Price += $row['price']*$row['qty'];
				$Sub_Total += $row['price']*$row['qty'];
				
				$price = '<span id="product-quatity">'.$row['qty'].'</span> x ₹'.$row['price']; 
				
				$items .= ' <li>
								<div class="shopping-cart-img">
									<a href="javascript:void(0);"> <img src="'.$Path.'/'.$row['image'].'" alt="'.$row['name'].'" /></a>
								</div>
								<div class="shopping-cart-title">
									<h4><a href="'.route('frontend.product', [$row['id'], str_slug($row['name'])]).'">'.substr($row['name'], 0, 16).'..</a></h4>
									<h4><span>'.$price.'</span></h4>
								</div>
								<div class="shopping-cart-delete">
									<a data-id="'.$row['id'].'" id="removetocart_'.$row['id'].'" onclick="onRemoveToCart('.$row['id'].')" href="javascript:void(0);" class="item-remove"><i class="fi-rs-cross-small"></i></a>
								</div>
							</li>';
			}
		}
		
		$TotalPrice = NumberFormat($Total_Price);
		$SubTotal = NumberFormat($Sub_Total);
		
		$TaxCal = ($Total_Price*$taxRate)/100;
		$tax = NumberFormat($TaxCal);
		
		$total = $Sub_Total+$TaxCal;
		$GrandTotal = NumberFormat($total);
		$discount = 0;
		
		$datalist = array();
		$datalist['items'] = $items;
		$datalist['total_qty'] = $count;
		$datalist['sub_total'] = '₹'.$SubTotal;
		$datalist['tax'] = '₹'.$tax;
		$datalist['price_total'] = '₹'.$TotalPrice;
		$datalist['total'] = '₹'.$GrandTotal;

		return response()->json($datalist);
	}
	
	//Remove to Cart
	public function RemoveToCart($rowid){
		$res = array();

		$cart = session()->get('shopping_cart');
		if(isset($cart[$rowid])){
			unset($cart[$rowid]);
			session()->put('shopping_cart', $cart);
		}

		$res['msgType'] = 'success';
		$res['msg'] = __('Data Removed Successfully');
		
		return response()->json($res);
	}
	
    //get Cart
    public function getCart(){
        return view('frontend.pages.cart');
    }
	
    //get Cart
    public function getViewCartData(){
		$gtext = gtext();
		$gtax = getTax();
		$taxRate = $gtax['percentage'];
		
		$ShoppingCartData = session()->get('shopping_cart');
		$count = 0;
		$Total_Price = 0;
		$Sub_Total = 0;
		$tax = 0;
		$total = 0;
		
		if(session()->get('shopping_cart')){
			foreach ($ShoppingCartData as $row) {
				$count += $row['qty'];
				$Total_Price += $row['price']*$row['qty'];
				$Sub_Total += $row['price']*$row['qty'];
			}
		}
		
		$TotalPrice = NumberFormat($Total_Price);
		$SubTotal = NumberFormat($Sub_Total);
		
		$TaxCal = ($Total_Price*$taxRate)/100;
		$tax = NumberFormat($TaxCal);
		
		$total = $SubTotal+$TaxCal;
		$GrandTotal = NumberFormat($total);
		$discount = 0;
		
		$datalist = array();
		$datalist['total_qty'] = $count;
		if($gtext['currency_position'] == 'left'){
			$datalist['sub_total'] = $gtext['currency_icon'].$SubTotal;
			$datalist['tax'] = $gtext['currency_icon'].$tax;
			$datalist['price_total'] = $gtext['currency_icon'].$TotalPrice;
			$datalist['total'] = $gtext['currency_icon'].$GrandTotal;
			$datalist['discount'] = $gtext['currency_icon'].$discount;
		}else{
			$datalist['sub_total'] = $SubTotal.$gtext['currency_icon'];
			$datalist['tax'] = $tax.$gtext['currency_icon'];
			$datalist['price_total'] = $TotalPrice.$gtext['currency_icon'];
			$datalist['total'] = $GrandTotal.$gtext['currency_icon'];
			$datalist['discount'] = $discount.$gtext['currency_icon'];
		}

		return response()->json($datalist);
    }
	
	//Add to Wishlist
	public function addToWishlist($id){

		$res = array();
		$datalist = Product::where('id', $id)->first();
		$category = Pro_category::find($datalist->cat_id);
		$brand = Brand::find($datalist->brand_id);
		$user = User::where('id', $datalist['user_id'])->first();
		
		$quantity = 1;
		$cart = session()->get('shopping_wishlist', []);
		
		if(isset($cart[$id])){
			$cart[$id]['qty'] = $quantity;
		}else{
			$cart[$id] = [
				"id" => $datalist['id'],
				"name" => $datalist['title'],
				"qty" => $quantity,
				"price" => $datalist['sale_price'],
				"weight" => 0,
				"image" => $datalist['image'],
				"image2" => $datalist['image2'],
				"unit" => $datalist['variation_size'],
				"cat_name" => $category ? $category['name'] : '',
				"cat_image" => $category ? $category['image'] : '',
				"brand_name" => $brand ? $brand['name'] : '',
				"brand_logo" => $brand ? $brand['thumbnail'] : '',
			];
		}

		session()->put('shopping_wishlist', $cart);

		$res['msgType'] = 'success';
		$res['msg'] = __('New Data Added Successfully');
		
		return response()->json($res);
	}
	
    //get Wishlist
    public function getWishlist(){
		return view('frontend.wishlist');
	}
	
	//Remove to Wishlist
	public function RemoveToWishlist($rowid){
		$res = array();
		
		$cart = session()->get('shopping_wishlist');
		if(isset($cart[$rowid])){
			unset($cart[$rowid]);
			session()->put('shopping_wishlist', $cart);
		}

		$res['msgType'] = 'success';
		$res['msg'] = __('Data Removed Successfully');
		
		return response()->json($res);
	}
	
	//Count to Wishlist
	public function countWishlist(){

		$ShoppingWishlistData = session()->get('shopping_wishlist');
		$count = 0;
		if(session()->get('shopping_wishlist')){
			foreach ($ShoppingWishlistData as $row) {
				$count++;
			}
		}
		
		return response()->json($count);
	}
}
