<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Models\Tp_option;
use App\Models\Menu;
use App\Models\Menu_parent;
use App\Models\Mega_menu;
use App\Models\Menu_child;
use App\Models\Pro_category;
use App\Models\Attribute;
use App\Models\Tax;
use App\Models\Order;
use App\Models\Social_media;
use App\Models\Section_manage;
use Illuminate\Support\Facades\Auth;  
use App\Models\Offer_ad;
use App\Models\Pro_image;

//Page Variation
function PageVariation(){

	$data = array();
	$results = Tp_option::where('option_name', 'page_variation')->get();

	$id = '';
	foreach ($results as $row){
		$id = $row->id;
	}

	if($id != ''){
	
		$sData = json_decode($results);
		$dataObj = json_decode($sData[0]->option_value);
		
		$data['home_variation'] = $dataObj->home_variation;
		$data['category_variation'] = $dataObj->category_variation;
		$data['brand_variation'] = $dataObj->brand_variation;
		$data['seller_variation'] = $dataObj->seller_variation;
	}else{
		$data['home_variation'] = 'home_1';
		$data['category_variation'] = 'left_sidebar';
		$data['brand_variation'] = 'left_sidebar';
		$data['seller_variation'] = 'left_sidebar';
	}
		
	return $data;
}

//Get data for Language locale
function glan(){
	$lan = app()->getLocale();
	
	return $lan;
}
//Product related images List
function productAllImageList($id){
	$datalist = Pro_image::where('product_id', '=', $id)->orderBy('id', 'ASC')->get();
	return $datalist;
}

//Category List
function CategoryMenuList(){
	$datalist = Pro_category::where('is_publish', '=', 1)->orderBy('id', 'ASC')->get();
	$li_List = '';
	$Path = asset('uploads/category');
	$count = 1;
	foreach($datalist as $row){
		$id = $row->id;
		$slug = $row->slug;
		$thumbnail = '<img src="'.$Path.'/'.$row->thumbnail.'" />';
		
		if($count>8){
			$li_List .= '<li class="cat-list-hideshow"><a href="'.route('frontend.product-category', [$id, $slug]).'"><div class="cat-icon">'.$thumbnail.'</div>'.$row->name.'</a></li>';
		}else{
			$li_List .= '<li><a href="'.route('frontend.product-category', [$id, $slug]).'"><div class="cat-icon">'.$thumbnail.'</div>'.$row->name.'</a></li>';
		}
		
		$count++;
	}
	
	return $li_List;
}

//Category List for Mobile
function CategoryListForMobile(){
	
	$datalist = Pro_category::where('is_publish', '=', 1)->orderBy('name','ASC')->get();
	$li_List = '';
	foreach($datalist as $row){
		$id = $row->id;
		$slug = $row->slug;

		$li_List .= '<li><a href="'.route('frontend.product-category', [$id, $slug]).'">'.$row->name.'</a></li>';
	}
	
	return $li_List;
}

//Category List for Option
function CategoryListOption(){
	
	$datalist = Pro_category::where('is_publish', '=', 1)->orderBy('name','ASC')->get();
	$option_List = '';
	foreach($datalist as $row){
		$id = $row->id;
		$slug = $row->slug;

		$option_List .= '<option value="'.$row->id.'">'.$row->name.'</option>';
	}
	
	return $option_List;
}

//Menu List
function HeaderMenuList($MenuType){

	$sql = "SELECT b.id, b.menu_id, b.menu_type, b.child_menu_type, b.item_id, b.item_label, b.custom_url, 
	b.target_window, b.css_class, b.`column`, b.width_type, b.width, b.lan, b.sort_order
	FROM menus a
	INNER JOIN menu_parents b ON a.id = b.menu_id
	WHERE a.menu_position = 'header'
	AND a.status_id  = 1
	ORDER BY sort_order ASC;";
	$datalist = DB::select($sql);
	$MenuList = '';
	$MegaDropdownMenuList = '';
	$full_width = '';
	$hasChildrenMenu = '';
	$upDownClass = '';
	$target_window = '';
	foreach($datalist as $row){

		$menu_id = $row->menu_id;
		$menu_parent_id = $row->id;
		
		$item_id = $row->item_id;
		$custom_url = $row->custom_url;
		
		if($row->target_window == '_blank'){
			$target_window = ' target="_blank"';
		}else{
			$target_window = '';
		}
		
		
		//Menu list for Desktop
		if($MenuType == 'HeaderMenuListForDesktop'){
			
			if($row->child_menu_type == 'mega_menu'){
				$MegaDropdownMenuList = makeMegaMenu($menu_id, $menu_parent_id, $row->width_type, $row->width, $MenuType);
				$upDownClass = ' class="tp-updown"';
			}elseif($row->child_menu_type == 'dropdown'){
				$MegaDropdownMenuList = makeDropdownMenu($menu_id, $menu_parent_id, $MenuType);
				$upDownClass = ' class="tp-updown"';
			}else{
				$MegaDropdownMenuList = '';
				$upDownClass = '';
			}
			
			if($row->width_type == 'full_width'){
				$full_width = 'class="tp-static"';
			}else{
				$full_width = '';
			}
			
			if($row->menu_type == 'page'){
				$MenuList .= '<li '.$full_width.'><a'.$upDownClass.$target_window.' href="'.route('frontend.page', [$item_id, $custom_url]).'">'.$row->item_label.'</a>'.$MegaDropdownMenuList.'</li>';

			}elseif($row->menu_type == 'brand'){
				$MenuList .= '<li '.$full_width.'><a'.$upDownClass.$target_window.' href="'.route('frontend.brand', [$item_id, $custom_url]).'">'.$row->item_label.'</a>'.$MegaDropdownMenuList.'</li>';
		
			}elseif($row->menu_type == 'custom_link'){
				$MenuList .= '<li '.$full_width.'><a'.$upDownClass.$target_window.' href="'.$custom_url.'">'.$row->item_label.'</a>'.$MegaDropdownMenuList.'</li>';

			}elseif($row->menu_type == 'product'){
				$MenuList .= '<li '.$full_width.'><a'.$upDownClass.$target_window.' href="'.route('frontend.product', [$item_id, $custom_url]).'">'.$row->item_label.'</a>'.$MegaDropdownMenuList.'</li>';
		
			}elseif($row->menu_type == 'product_category'){
				$MenuList .= '<li '.$full_width.'><a'.$upDownClass.$target_window.' href="'.route('frontend.product-category', [$item_id, $custom_url]).'">'.$row->item_label.'</a>'.$MegaDropdownMenuList.'</li>';
			
			}elseif($row->menu_type == 'blog'){
				if($item_id == 0){
					$MenuList .= '<li '.$full_width.'><a'.$upDownClass.$target_window.' href="'.route('frontend.blog').'">'.$row->item_label.'</a>'.$MegaDropdownMenuList.'</li>';
				}else{
					$MenuList .= '<li '.$full_width.'><a'.$upDownClass.$target_window.' href="'.route('frontend.blog-category', [$item_id, $custom_url]).'">'.$row->item_label.'</a>'.$MegaDropdownMenuList.'</li>';
				}
			}
			
		//Menu list for Mobile
		}else{
			
			if($row->child_menu_type == 'mega_menu'){
				$MegaDropdownMenuList = makeMegaMenu($menu_id, $menu_parent_id, $row->width_type, $row->width, $MenuType);
				$hasChildrenMenu = 'class="has-children-menu"';
			}elseif($row->child_menu_type == 'dropdown'){
				$MegaDropdownMenuList = makeDropdownMenu($menu_id, $menu_parent_id, $MenuType);
				$hasChildrenMenu = 'class="has-children-menu"';
			}else{
				$MegaDropdownMenuList = '';
				$hasChildrenMenu = '';
			}
			
			if($row->menu_type == 'page'){
				$MenuList .= '<li '.$hasChildrenMenu.'><a'.$target_window.' href="'.route('frontend.page', [$item_id, $custom_url]).'">'.$row->item_label.'</a>'.$MegaDropdownMenuList.'</li>';

			}elseif($row->menu_type == 'brand'){
				$MenuList .= '<li '.$hasChildrenMenu.'><a'.$target_window.' href="'.route('frontend.brand', [$item_id, $custom_url]).'">'.$row->item_label.'</a>'.$MegaDropdownMenuList.'</li>';
		
			}elseif($row->menu_type == 'custom_link'){
				$MenuList .= '<li '.$hasChildrenMenu.'><a'.$target_window.' href="'.$row->custom_url.'">'.$row->item_label.'</a>'.$MegaDropdownMenuList.'</li>';

			}elseif($row->menu_type == 'product'){
				$MenuList .= '<li '.$hasChildrenMenu.'><a'.$target_window.' href="'.route('frontend.product', [$item_id, $custom_url]).'">'.$row->item_label.'</a>'.$MegaDropdownMenuList.'</li>';
		
			}elseif($row->menu_type == 'product_category'){
				$MenuList .= '<li '.$hasChildrenMenu.'><a'.$target_window.' href="'.route('frontend.product-category', [$item_id, $custom_url]).'">'.$row->item_label.'</a>'.$MegaDropdownMenuList.'</li>';
			
			}elseif($row->menu_type == 'blog'){
				if($item_id == 0){
					$MenuList .= '<li '.$hasChildrenMenu.'><a'.$target_window.' href="'.route('frontend.blog').'">'.$row->item_label.'</a>'.$MegaDropdownMenuList.'</li>';
				}else{
					$MenuList .= '<li '.$hasChildrenMenu.'><a'.$target_window.' href="'.route('frontend.blog-category', [$item_id, $custom_url]).'">'.$row->item_label.'</a>'.$MegaDropdownMenuList.'</li>';
				}
			}
		}
	}

	return $MenuList;
}

function makeMegaMenu($menu_id, $menu_parent_id, $width_type, $width, $MenuType){
	
	$sql = "SELECT a.id, a.mega_menu_title, a.is_title, a.is_image, a.image, a.sort_order, b.column, b.width_type, b.width, b.css_class
	FROM mega_menus a 
	INNER JOIN menu_parents b ON a.menu_parent_id = b.id
	WHERE a.menu_id = '".$menu_id."'
	AND a.menu_parent_id = '".$menu_parent_id."'
	ORDER BY a.sort_order ASC;";
	$datalist = DB::select($sql);
	
	$ul_List = '';
	$title = '';
	$imageOrMegaLiList = '';
	$is_title_for_mobile = 0;
	foreach($datalist as $row){
		$mega_menu_id = $row->id;
		
		if($row->is_title == 0){
			$is_title_for_mobile++;
		}
		
		//Menu list for Desktop
		if($MenuType == 'HeaderMenuListForDesktop'){
		
			if($row->is_title == 1){
				$title = '<li class="mega-title">'.$row->mega_menu_title.'</li>';
			}else{
				$title = '';
			}
			
			if($row->is_image == 1){
				if($row->image != ''){
					$Path = asset('public/media');
					$imageOrMegaLiList = '<img src="'.$Path.'/'.$row->image.'" />';
				}else{
					$imageOrMegaLiList = '';
				}
			}else{
				$imageOrMegaLiList = mega_liList($menu_id, $menu_parent_id, $mega_menu_id, $MenuType);
			}
			
			if($row->width_type == 'full_width'){
				$ul_List .= '<ul class="mega-col-'.$row->column.' '.$row->css_class.'">
							'.$title.$imageOrMegaLiList.'
						</ul>';
			}else{
				$ul_List .= '<ul class="megafixed-col-'.$row->column.' '.$row->css_class.'">
							'.$title.$imageOrMegaLiList.'
						</ul>';
			}
		
		//Menu list for Mobile
		}else{
			
			if($row->is_image == 1){
				$imageOrMegaLiList = '';
			}else{
				$imageOrMegaLiList = mega_liList($menu_id, $menu_parent_id, $mega_menu_id, $MenuType);
			}
			
			if($is_title_for_mobile>0){
				$ul_List .= $imageOrMegaLiList;
			}else{
				$ul_List .= '<li class="has-children-menu"><a href="#">'.$row->mega_menu_title.'</a>
							<ul class="dropdown">'.$imageOrMegaLiList.'</ul>
						</li>';
			}
		}
	}
	
	//Menu list for Desktop
	if($MenuType == 'HeaderMenuListForDesktop'){
		if($width_type == 'full_width'){
			$MenuList = '<div class="mega-menu mega-full">'.$ul_List.'</div>';
		}else{
			$MenuList = '<div class="mega-menu" style="width:'.$width.'px;">'.$ul_List.'</div>';
		}
	
	//Menu list for Mobile
	}else{
		$MenuList = '<ul class="dropdown">'.$ul_List.'</ul>';
	}
	
	return $MenuList;	
}

function mega_liList($menu_id, $menu_parent_id, $mega_menu_id, $MenuType){
	
	$datalist = Menu_child::where('menu_id', '=', $menu_id)
			->where('menu_parent_id', '=', $menu_parent_id)
			->where('mega_menu_id', '=', $mega_menu_id)
			->orderBy('sort_order','ASC')->get();

	$li_List = '';
	$target_window = '';
	foreach($datalist as $row){
		
		$item_id = $row->item_id;
		$custom_url = $row->custom_url;
		
		if($row->target_window == '_blank'){
			$target_window = ' target="_blank"';
		}else{
			$target_window = '';
		}
		
		if($row->menu_type == 'page'){
			$li_List .= '<li><a'.$target_window.' href="'.route('frontend.page', [$item_id, $custom_url]).'">'.$row->item_label.'</a></li>';

		}elseif($row->menu_type == 'brand'){
			$li_List .= '<li><a'.$target_window.' href="'.route('frontend.brand', [$item_id, $custom_url]).'">'.$row->item_label.'</a></li>';
			
		}elseif($row->menu_type == 'custom_link'){
			$li_List .= '<li><a'.$target_window.' href="'.$custom_url.'">'.$row->item_label.'</a></li>';

		}elseif($row->menu_type == 'product'){
			$li_List .= '<li><a'.$target_window.' href="'.route('frontend.product', [$item_id, $custom_url]).'">'.$row->item_label.'</a></li>';
			
		}elseif($row->menu_type == 'product_category'){
			$li_List .= '<li><a'.$target_window.' href="'.route('frontend.product-category', [$item_id, $custom_url]).'">'.$row->item_label.'</a></li>';
		
		}elseif($row->menu_type == 'blog'){
			if($item_id == 0){
				$li_List .= '<li><a'.$target_window.' href="'.route('frontend.blog').'">'.$row->item_label.'</a></li>';
			}else{
				$li_List .= '<li><a'.$target_window.' href="'.route('frontend.blog-category', [$item_id, $custom_url]).'">'.$row->item_label.'</a></li>';
			}
		}
	}

	return $li_List;
}

function makeDropdownMenu($menu_id, $menu_parent_id, $MenuType){

	$datalist = Menu_child::where('menu_id', '=', $menu_id)
			->where('menu_parent_id', '=', $menu_parent_id)
			->orderBy('sort_order','ASC')->get();

	$li_List = '';
	$target_window = '';
	foreach($datalist as $row){
		
		$item_id = $row->item_id;
		$custom_url = $row->custom_url;
		
		if($row->target_window == '_blank'){
			$target_window = ' target="_blank"';
		}else{
			$target_window = '';
		}
		
		if($row->menu_type == 'page'){
			$li_List .= '<li><a'.$target_window.' href="'.route('frontend.page', [$item_id, $custom_url]).'">'.$row->item_label.'</a></li>';

		}elseif($row->menu_type == 'brand'){
			$li_List .= '<li><a'.$target_window.' href="'.route('frontend.brand', [$item_id, $custom_url]).'">'.$row->item_label.'</a></li>';
			
		}elseif($row->menu_type == 'custom_link'){
			$li_List .= '<li><a'.$target_window.' href="'.$custom_url.'">'.$row->item_label.'</a></li>';

		}elseif($row->menu_type == 'product'){
			$li_List .= '<li><a'.$target_window.' href="'.route('frontend.product', [$item_id, $custom_url]).'">'.$row->item_label.'</a></li>';
			
		}elseif($row->menu_type == 'product_category'){
			$li_List .= '<li><a'.$target_window.' href="'.route('frontend.product-category', [$item_id, $custom_url]).'">'.$row->item_label.'</a></li>';
			
		}elseif($row->menu_type == 'blog'){
			if($item_id == 0){
				$li_List .= '<li><a'.$target_window.' href="'.route('frontend.blog').'">'.$row->item_label.'</a></li>';
			}else{
				$li_List .= '<li><a'.$target_window.' href="'.route('frontend.blog-category', [$item_id, $custom_url]).'">'.$row->item_label.'</a></li>';
			}
		}
	}
	
	//Menu list for Desktop
	if($MenuType == 'HeaderMenuListForDesktop'){
		$MenuList = '<ul class="submenu">'.$li_List.'</ul>';
	
	//Menu list for Mobile
	}else{
		$MenuList = '<ul class="dropdown">'.$li_List.'</ul>';
	}
	
	return $MenuList;
}

//Footer Menu List
function FooterMenuList($MenuType){
	$sql = "SELECT b.id, b.menu_id, b.menu_type, b.item_id, b.item_label, b.custom_url, b.target_window, b.sort_order
	FROM menus a
	INNER JOIN menu_parents b ON a.id = b.menu_id
	WHERE a.menu_position = '".$MenuType."'
	AND a.status_id  = 1
	ORDER BY sort_order ASC;";
	$datalist = DB::select($sql);
	$li_List = '';
	$target_window = '';
	foreach($datalist as $row){
		$item_id = $row->item_id;
		$custom_url = $row->custom_url;
		
		if($row->target_window == '_blank'){
			$target_window = ' target="_blank"';
		}else{
			$target_window = '';
		}
		
		if($row->menu_type == 'page'){
			$li_List .= '<li><a'.$target_window.' href="'.route('frontend.page', [$item_id, $custom_url]).'">'.$row->item_label.'</a></li>';

		}elseif($row->menu_type == 'brand'){
			$li_List .= '<li><a'.$target_window.' href="'.route('frontend.brand', [$item_id, $custom_url]).'">'.$row->item_label.'</a></li>';
			
		}elseif($row->menu_type == 'custom_link'){
			$li_List .= '<li><a'.$target_window.' href="'.$custom_url.'">'.$row->item_label.'</a></li>';

		}elseif($row->menu_type == 'product'){
			$li_List .= '<li><a'.$target_window.' href="'.route('frontend.product', [$item_id, $custom_url]).'">'.$row->item_label.'</a></li>';
			
		}elseif($row->menu_type == 'product_category'){
			$li_List .= '<li><a'.$target_window.' href="'.route('frontend.product-category', [$item_id, $custom_url]).'">'.$row->item_label.'</a></li>';
			
		}elseif($row->menu_type == 'blog'){
			if($item_id == 0){
				$li_List .= '<li><a'.$target_window.' href="'.route('frontend.blog').'">'.$row->item_label.'</a></li>';
			}else{
				$li_List .= '<li><a'.$target_window.' href="'.route('frontend.blog-category', [$item_id, $custom_url]).'">'.$row->item_label.'</a></li>';
			}
		}
	}

	return $li_List;
}

function gtext(){

	$data = array();

// Fetch general_settings
$general_settings = Tp_option::where('option_name', 'general_settings')->first();

if ($general_settings) {
    $general_settingsDataObj = json_decode($general_settings->option_value); // Correct decoding

    // Assign values if they exist
    $data['site_name'] = $general_settingsDataObj->site_name ?? 'Mart sutta';
    $data['site_title'] = $general_settingsDataObj->site_title ?? 'Laravel eCommerce Shopping Platform';
    $data['company'] = $general_settingsDataObj->company ?? '';
    $data['invoice_email'] = $general_settingsDataObj->email ?? '';
    $data['invoice_phone'] = $general_settingsDataObj->phone ?? '';
    $data['invoice_address'] = $general_settingsDataObj->address ?? '';
    $data['timezone'] = $general_settingsDataObj->timezone ?? '';
} else {
    // Default values if no settings exist
    $data['site_name'] = 'Mart sutta';
    $data['site_title'] = 'Laravel eCommerce Shopping Platform';
    $data['company'] = '';
    $data['invoice_email'] = '';
    $data['invoice_phone'] = '';
    $data['invoice_address'] = '';
    $data['timezone'] = '';
}

// Dump the data for debugging

	
	//theme_logo
	$theme_logo = Tp_option::where('option_name', 'theme_logo')->first(); // Use first() instead of get()

	if ($theme_logo) {
		$theme_logoObj = json_decode($theme_logo->option_value); // Correct decoding

		// Assign values safely
		$data['favicon'] = $theme_logoObj->favicon ?? '';
		$data['front_logo'] = $theme_logoObj->front_logo ?? '';
		$data['back_logo'] = $theme_logoObj->back_logo ?? '';
	} else {
		// Default empty values if no theme_logo found
		$data['favicon'] = '';
		$data['front_logo'] = '';
		$data['back_logo'] = '';
	}
	
	//theme_option_header
	$theme_option_header = Tp_option::where('option_name', 'theme_option_header')->first(); // Use first() instead of get()

	if ($theme_option_header) {
		$theme_option_headerObj = json_decode($theme_option_header->option_value); // Correct decoding
	
		// Assign values safely
		$data['address'] = $theme_option_headerObj->address ?? '';
		$data['phone'] = $theme_option_headerObj->phone ?? '';
		$data['is_publish'] = $theme_option_headerObj->is_publish ?? '';
	} else {
		// Default empty values if no theme_option_header found
		$data['address'] = '';
		$data['phone'] = '';
		$data['is_publish'] = '';
	}
	
	
	//theme_option_footer
	$theme_option_footer = Tp_option::where('option_name', 'theme_option_footer')->first(); // Use first() instead of get()

	if ($theme_option_footer) {
		$theme_option_footerObj = json_decode($theme_option_footer->option_value); // Correct decoding
	
		// Assign values safely using null coalescing (??) to prevent undefined errors
		$data['about_logo_footer'] = $theme_option_footerObj->about_logo ?? '';
		$data['about_desc_footer'] = $theme_option_footerObj->about_desc ?? '';
		$data['is_publish_about'] = $theme_option_footerObj->is_publish_about ?? '';
		$data['address_footer'] = $theme_option_footerObj->address ?? '';
		$data['email_footer'] = $theme_option_footerObj->email ?? '';
		$data['phone_footer'] = $theme_option_footerObj->phone ?? '';
		$data['is_publish_contact'] = $theme_option_footerObj->is_publish_contact ?? '';
		$data['copyright'] = $theme_option_footerObj->copyright ?? '';
		$data['is_publish_copyright'] = $theme_option_footerObj->is_publish_copyright ?? '';
		$data['payment_gateway_icon'] = $theme_option_footerObj->payment_gateway_icon ?? '';
		$data['is_publish_payment'] = $theme_option_footerObj->is_publish_payment ?? '';
	} else {
		// Set default values
		$data['about_logo_footer'] = '';
		$data['about_desc_footer'] = '';
		$data['is_publish_about'] = '';
		$data['address_footer'] = '';
		$data['email_footer'] = '';
		$data['phone_footer'] = '';
		$data['is_publish_contact'] = '';
		$data['copyright'] = '';
		$data['is_publish_copyright'] = '';
		$data['payment_gateway_icon'] = '';
		$data['is_publish_payment'] = '';
	}
	
	// Debugging output if needed
	// dd($data);
	
	
	
	//facebook
	$facebook = Tp_option::where('option_name', 'facebook')->first(); 

	if ($facebook) {
		$facebookObj = json_decode($facebook->option_value); 
	
		$data['fb_app_id'] = $facebookObj->fb_app_id ?? '';  
		$data['fb_publish'] = $facebookObj->is_publish ?? '';
	} else {
		$data['fb_app_id'] = '';
		$data['fb_publish'] = '';
	}
	
	
	//twitter
	$twitter = Tp_option::where('option_name', 'twitter')->first(); 

	if ($twitter) {
		$twitterObj = json_decode($twitter->option_value); 
	
		$data['twitter_id'] = $twitterObj->twitter_id ?? ''; 
		$data['twitter_publish'] = $twitterObj->is_publish ?? '';
	} else {
		$data['twitter_id'] = '';
		$data['twitter_publish'] = '';
	}
	
	
	//Theme Option SEO
	$theme_option_seo = Tp_option::where('option_name', 'theme_option_seo')->first(); // Use first() instead of get()

	if ($theme_option_seo) {
		$SEOObj = json_decode($theme_option_seo->option_value); // Decode option_value directly
	
		$data['og_title'] = $SEOObj->og_title ?? '';  
		$data['og_image'] = $SEOObj->og_image ?? '';
		$data['og_description'] = $SEOObj->og_description ?? '';
		$data['og_keywords'] = $SEOObj->og_keywords ?? '';
		$data['seo_publish'] = $SEOObj->is_publish ?? '';
	} else {
		$data['og_title'] = '';
		$data['og_image'] = '';
		$data['og_description'] = '';
		$data['og_keywords'] = '';
		$data['seo_publish'] = '';
	}
	
	
	//Theme Option Facebook Pixel
	$theme_option_facebook_pixel = Tp_option::where('option_name', 'facebook-pixel')->first(); // Use first() instead of get()

	if ($theme_option_facebook_pixel) {
		$fb_PixelObj = json_decode($theme_option_facebook_pixel->option_value); // Decode option_value directly
	
		$data['fb_pixel_id'] = $fb_PixelObj->fb_pixel_id ?? '';  
		$data['fb_pixel_publish'] = $fb_PixelObj->is_publish ?? '';
	} else {
		$data['fb_pixel_id'] = '';
		$data['fb_pixel_publish'] = '';
	}
	
	
	//Theme Option Google Analytics
	$theme_option_google_analytics = Tp_option::where('option_name', 'google_analytics')->first(); // Use first() instead of get()

	if ($theme_option_google_analytics) {
		$gaObj = json_decode($theme_option_google_analytics->option_value); // Decode option_value directly
	
		$data['tracking_id'] = $gaObj->tracking_id ?? '';  
		$data['ga_publish'] = $gaObj->is_publish ?? '';
	} else {
		$data['tracking_id'] = '';
		$data['ga_publish'] = '';
	}
	
	
	//Theme Option Google Tag Manager
	$theme_option_google_tag_manager = Tp_option::where('option_name', 'google_tag_manager')->first(); // Use first()

	if ($theme_option_google_tag_manager) {
		$gtmObj = json_decode($theme_option_google_tag_manager->option_value); // Decode option_value
	
		$data['google_tag_manager_id'] = $gtmObj->google_tag_manager_id ?? '';  
		$data['gtm_publish'] = $gtmObj->is_publish ?? '';
	} else {
		$data['google_tag_manager_id'] = '';
		$data['gtm_publish'] = '';
	}
	
	
	//Google Recaptcha
	$theme_option_google_recaptcha = Tp_option::where('option_name', 'google_recaptcha')->first(); // Use first() to get the first record

	if ($theme_option_google_recaptcha) {
		$grObj = json_decode($theme_option_google_recaptcha->option_value); // Decode the option_value field
	
		$data['sitekey'] = $grObj->sitekey ?? ''; // Use null coalescing to avoid undefined property errors
		$data['secretkey'] = $grObj->secretkey ?? '';
		$data['is_recaptcha'] = $grObj->is_recaptcha ?? '';
	} else {
		$data['sitekey'] = '';
		$data['secretkey'] = '';
		$data['is_recaptcha'] = '';
	}
	
	
	//Google Map
	$theme_option_google_map = Tp_option::where('option_name', 'google_map')->first(); // Use first() to get the first record

	if ($theme_option_google_map) {
		$gmObj = json_decode($theme_option_google_map->option_value); // Decode the option_value field
	
		$data['googlemap_apikey'] = $gmObj->googlemap_apikey ?? ''; // Use null coalescing to avoid undefined property errors
		$data['is_googlemap'] = $gmObj->is_googlemap ?? '';
	} else {
		$data['googlemap_apikey'] = '';
		$data['is_googlemap'] = '';
	}
	
	
	//Theme Color
	$theme_color = Tp_option::where('option_name', 'theme_color')->first(); // Use first() instead of get()

	if ($theme_color) {
		$tcObj = json_decode($theme_color->option_value); // Decode the option_value field
	
		$data['theme_color'] = $tcObj->theme_color ?? '#61a402';
		$data['green_color'] = $tcObj->green_color ?? '#65971e';
		$data['light_green_color'] = $tcObj->light_green_color ?? '#daeac5';
		$data['lightness_green_color'] = $tcObj->lightness_green_color ?? '#fdfff8';
		$data['gray_color'] = $tcObj->gray_color ?? '#8d949d';
		$data['dark_gray_color'] = $tcObj->dark_gray_color ?? '#595959';
		$data['light_gray_color'] = $tcObj->light_gray_color ?? '#e7e7e7';
		$data['black_color'] = $tcObj->black_color ?? '#232424';
		$data['white_color'] = $tcObj->white_color ?? '#ffffff';
	} else {
		// Default colors if no data is found
		$data['theme_color'] = '#61a402';
		$data['green_color'] = '#65971e';
		$data['light_green_color'] = '#daeac5';
		$data['lightness_green_color'] = '#fdfff8';
		$data['gray_color'] = '#8d949d';
		$data['dark_gray_color'] = '#595959';
		$data['light_gray_color'] = '#e7e7e7';
		$data['black_color'] = '#232424';
		$data['white_color'] = '#ffffff';
	}
	
	
	//Mail Settings
	$theme_option_mail_settings = Tp_option::where('option_name', 'mail_settings')->first(); // Use first() instead of get()

	if ($theme_option_mail_settings) {
		$msObj = json_decode($theme_option_mail_settings->option_value); // Decode the option_value field
	
		$data['ismail'] = $msObj->ismail ?? '';
		$data['from_name'] = $msObj->from_name ?? '';
		$data['from_mail'] = $msObj->from_mail ?? '';
		$data['to_name'] = $msObj->to_name ?? '';
		$data['to_mail'] = $msObj->to_mail ?? '';
		$data['mailer'] = $msObj->mailer ?? '';
		$data['smtp_host'] = $msObj->smtp_host ?? '';
		$data['smtp_port'] = $msObj->smtp_port ?? '';
		$data['smtp_security'] = $msObj->smtp_security ?? '';
		$data['smtp_username'] = $msObj->smtp_username ?? '';
		$data['smtp_password'] = $msObj->smtp_password ?? '';
	} else {
		// Default empty values if no data is found
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
	

	//Stripe
	$stripe_data = Tp_option::where('option_name', 'stripe')->first(); // Use first() to get the first record

if ($stripe_data) {
    $sObj = json_decode($stripe_data->option_value); // Decode the option_value

    $data['stripe_key'] = $sObj->stripe_key ?? '';
    $data['stripe_secret'] = $sObj->stripe_secret ?? '';
    $data['stripe_currency'] = $sObj->currency ?? '';
    $data['stripe_isenable'] = $sObj->isenable ?? '';
} else {
    // Default values if no data is found
    $data['stripe_key'] = '';
    $data['stripe_secret'] = '';
    $data['stripe_currency'] = '';
    $data['stripe_isenable'] = '';
}


	//Paypal
	$paypal_data = Tp_option::where('option_name', 'paypal')->first(); // Use first() to get the first record

if ($paypal_data) {
    $paypalObj = json_decode($paypal_data->option_value); // Decode the option_value

    $data['paypal_client_id'] = $paypalObj->paypal_client_id ?? '';
    $data['paypal_secret'] = $paypalObj->paypal_secret ?? '';
    $data['paypal_currency'] = $paypalObj->paypal_currency ?? 'USD'; // Default to 'USD' if not found
    $data['ismode_paypal'] = $paypalObj->ismode_paypal ?? '';
    $data['isenable_paypal'] = $paypalObj->isenable_paypal ?? '';
} else {
    // Default values if no data is found
    $data['paypal_client_id'] = '';
    $data['paypal_secret'] = '';
    $data['paypal_currency'] = 'USD'; // Default to 'USD'
    $data['ismode_paypal'] = '';
    $data['isenable_paypal'] = '';
}
	
	
	//Razorpay
	$razorpay_data = Tp_option::where('option_name', 'razorpay')->first(); // Use first() to get the first record

if ($razorpay_data) {
    $razorpayObj = json_decode($razorpay_data->option_value); // Decode the option_value

    // Assign values to $data with null coalescing to handle missing properties
    $data['razorpay_key_id'] = $razorpayObj->razorpay_key_id ?? '';
    $data['razorpay_key_secret'] = $razorpayObj->razorpay_key_secret ?? '';
    $data['razorpay_currency'] = $razorpayObj->razorpay_currency ?? '';
    $data['ismode_razorpay'] = $razorpayObj->ismode_razorpay ?? '';
    $data['isenable_razorpay'] = $razorpayObj->isenable_razorpay ?? '';
} else {
    // Default values if no data is found
    $data['razorpay_key_id'] = '';
    $data['razorpay_key_secret'] = '';
    $data['razorpay_currency'] = '';
    $data['ismode_razorpay'] = '';
    $data['isenable_razorpay'] = '';
}

	
	//Mollie
	$mollie_data = Tp_option::where('option_name', 'mollie')->first(); // Use first() to retrieve the first matching record

if ($mollie_data) {
    $mollieObj = json_decode($mollie_data->option_value); // Decode the option_value

    // Assign values to $data using null coalescing to handle missing properties
    $data['mollie_api_key'] = $mollieObj->mollie_api_key ?? '';
    $data['mollie_currency'] = $mollieObj->mollie_currency ?? '';
    $data['ismode_mollie'] = $mollieObj->ismode_mollie ?? '';
    $data['isenable_mollie'] = $mollieObj->isenable_mollie ?? '';
} else {
    // Default values if no data is found
    $data['mollie_api_key'] = '';
    $data['mollie_currency'] = '';
    $data['ismode_mollie'] = '';
    $data['isenable_mollie'] = '';
}

	
	//Cash on Delivery (COD)
	$cod_data = Tp_option::where('option_name', 'cash_on_delivery')->first(); // Use first() to retrieve the first matching record

if ($cod_data) {
    $codObj = json_decode($cod_data->option_value); // Decode the option_value once

    // Assign values to $data using null coalescing to handle missing properties
    $data['cod_description'] = $codObj->description ?? '';
    $data['cod_isenable'] = $codObj->isenable ?? '';
} else {
    // Default values if no data is found
    $data['cod_description'] = '';
    $data['cod_isenable'] = '';
}

	
	//Bank Transfer
	$bank_data = Tp_option::where('option_name', 'bank_transfer')->first(); // Use first() to retrieve the first matching record

if ($bank_data) {
    $btObj = json_decode($bank_data->option_value); // Decode the option_value once

    // Assign values to $data using null coalescing to handle missing properties
    $data['bank_description'] = $btObj->description ?? '';
    $data['bank_isenable'] = $btObj->isenable ?? '';
} else {
    // Default values if no data is found
    $data['bank_description'] = '';
    $data['bank_isenable'] = '';
}


	//MailChimp
	$mailchimp_data = Tp_option::where('option_name', 'mailchimp')->first(); // Use first() to get the first matching record

if ($mailchimp_data) {
    $mcObj = json_decode($mailchimp_data->option_value); // Decode the option_value once

    // Assign values to $data with null coalescing to handle missing or null values
    $data['mailchimp_api_key'] = $mcObj->mailchimp_api_key ?? '';
    $data['audience_id'] = $mcObj->audience_id ?? '';
    $data['is_mailchimp'] = $mcObj->is_mailchimp ?? '';
} else {
    // Default values if no data is found
    $data['mailchimp_api_key'] = '';
    $data['audience_id'] = '';
    $data['is_mailchimp'] = '';
}


	//Subscribe Popup
	$subscribe_popup_data = Tp_option::where('option_name', 'subscribe_popup')->first(); // Get first matching record

if ($subscribe_popup_data) {
    $spObj = json_decode($subscribe_popup_data->option_value); // Decode option_value once

    // Use null coalescing operator to provide default values for any missing properties
    $data['subscribe_title'] = $spObj->subscribe_title ?? '';
    $data['subscribe_popup_desc'] = $spObj->subscribe_popup_desc ?? '';
    $data['bg_image_popup'] = $spObj->bg_image_popup ?? '';
    $data['subscribe_background_image'] = $spObj->background_image ?? '';
    $data['is_subscribe_popup'] = $spObj->is_subscribe_popup ?? '';
    $data['is_subscribe_footer'] = $spObj->is_subscribe_footer ?? '';
} else {
    // Default values if no data found
    $data['subscribe_title'] = '';
    $data['subscribe_popup_desc'] = '';
    $data['bg_image_popup'] = '';
    $data['subscribe_background_image'] = '';
    $data['is_subscribe_popup'] = '';
    $data['is_subscribe_footer'] = '';
}

	
	//Whatsapp
	$whatsapp_data = Tp_option::where('option_name', 'whatsapp')->first(); // Get first matching record

if ($whatsapp_data) {
    $wsObj = json_decode($whatsapp_data->option_value); // Decode option_value once

    // Use null coalescing operator to provide default values for any missing properties
    $data['whatsapp_id'] = $wsObj->whatsapp_id ?? '';
    $data['whatsapp_text'] = $wsObj->whatsapp_text ?? '';
    $data['position'] = $wsObj->position ?? '';
    $data['is_whatsapp_publish'] = $wsObj->is_publish ?? '';
} else {
    // Default values if no data found
    $data['whatsapp_id'] = '';
    $data['whatsapp_text'] = '';
    $data['position'] = '';
    $data['is_whatsapp_publish'] = '';
}

	
	// Custom CSS
$custom_css_data = Tp_option::where('option_name', 'custom_css')->first(); // Get first matching record
$data['custom_css'] = $custom_css_data ? $custom_css_data->option_value : ''; // Use empty string if no data found

// Custom JS
$custom_js_data = Tp_option::where('option_name', 'custom_js')->first(); // Get first matching record
$data['custom_js'] = $custom_js_data ? $custom_js_data->option_value : ''; // Use empty string if no data found


	//Cookie Consent
 	// Cookie Consent
$theme_cookie_consent = Tp_option::where('option_name', 'cookie_consent')->first(); // Get the first matching record

if ($theme_cookie_consent) {
    $theme_cookie_consentObj = json_decode($theme_cookie_consent->option_value);

    $data['cookie_title'] = $theme_cookie_consentObj->title ?? '';
    $data['cookie_message'] = $theme_cookie_consentObj->message ?? '';
    $data['button_text'] = $theme_cookie_consentObj->button_text ?? '';
    $data['learn_more_url'] = $theme_cookie_consentObj->learn_more_url ?? '';
    $data['learn_more_text'] = $theme_cookie_consentObj->learn_more_text ?? '';
    $data['cookie_position'] = $theme_cookie_consentObj->position ?? '';
    $data['cookie_style'] = $theme_cookie_consentObj->style ?? '';
    $data['is_publish_cookie_consent'] = $theme_cookie_consentObj->is_publish ?? '';
} else {
    // Default values if no data found
    $data['cookie_title'] = '';
    $data['cookie_message'] = '';
    $data['button_text'] = '';
    $data['learn_more_url'] = '';
    $data['learn_more_text'] = '';
    $data['cookie_position'] = '';
    $data['cookie_style'] = '';
    $data['is_publish_cookie_consent'] = '';
}

	
	return $data;
}

//Blog Category List for Filter
function BlogCategoryListForFilter(){
	$sql = "SELECT b.id, b.slug, b.name,b.image, COUNT(a.id) TotalProduct
	FROM blogs a
	RIGHT JOIN blog_categories b ON a.category_id = b.id
	WHERE b.is_publish = 1
	GROUP BY b.id, b.slug, b.name
	ORDER BY b.name;";
	$datalist = DB::select($sql);

	return $datalist;
}
function BlogCategoryDeleteForFilter($cat_id) {
    $sql = "SELECT 
                b.id, 
                b.slug, 
                b.name, 
                b.image, 
                COUNT(a.id) AS TotalProduct
            FROM blog_categories b
            LEFT JOIN blogs a ON a.category_id = b.id
            WHERE b.is_publish = 1 AND b.id != ?
            GROUP BY b.id, b.slug, b.name, b.image
            ORDER BY b.name;";

    return DB::select($sql, [$cat_id]); 
}

//Category List for Filter
function CategoryListForFilter(){

	$sql = "SELECT b.id, b.slug, b.name, b.image, COUNT(a.id) TotalProduct
	FROM products a
	RIGHT JOIN pro_categories b ON a.cat_id = b.id
	WHERE b.is_publish = 1
	GROUP BY b.image, b.id, b.slug, b.name
	ORDER BY b.name;";
	$datalist = DB::select($sql);

	return $datalist;
}

//Brand List for Filter
function BrandListForFilter(){
	$sql = "SELECT b.id, b.name, b.image, COUNT(a.id) TotalProduct
	FROM products a
	RIGHT JOIN brands b ON a.brand_id = b.id
	WHERE b.is_publish = 1
	GROUP BY b.image, b.id, b.name
	ORDER BY b.name;";
	$datalist = DB::select($sql);

	return $datalist;
}

//Color List for Filter
function ColorListForFilter(){

	$datalist = Attribute::where('att_type', 'Color')->orderBy('id','asc')->get();
	$li_List = '';
	foreach($datalist as $row){
		$id = $row->id;
		$name = $row->name;
		$color = $row->color;

		$li_List .= '<li class="active_color" id="color_'.$id.'"><a data-color="'.$id.'" id="'.$name.'|'.$color.'" class="filter_by_color" href="javascript:void(0);" title="'.$name.'"><span style="background:'.$color.';"></span></a></li>';
	}
	
	return $li_List;
}

//Size List for Filter
function SizeListForFilter(){

	$datalist = Attribute::where('att_type', 'Size')->orderBy('id','asc')->get();

	$li_List = '';
	foreach($datalist as $row){
		$id = $row->id;
		$li_List .= '<li class="active_size" id="size_'.$id.'"><a data-size="'.$id.'" id="'.$row->name.'" class="filter_by_size" href="javascript:void(0);">'.$row->name.'</a></li>';
	}
	
	return $li_List;
}

//Social Media List
function SocialMediaList(){
	
	$datalist = Social_media::where('is_publish', '=', 1)->orderBy('id','ASC')->get();
	$li_List = '';
	foreach($datalist as $row){
		$id = $row->id;
		$url = $row->url;
		$target = $row->target == '' ? '' : "target=".$row->target;
		$social_icon = $row->social_icon;

		$li_List .= '<a href="'.$url.'" '.$target.'><i class="'.$social_icon.'"></i></a>';
	}
	
	return $li_List;
}

function vipc() {
    $row = Tp_option::where('option_name', 'vipc')->first();

    return [
        'bkey' => $row ? optional(json_decode($row->option_value))->resetkey ?? 0 : 0,
    ];
}

	
function getReviews($item_id) {
	
	$sql = "SELECT COUNT(id) TotalReview, SUM(IFNULL(rating, 0)) TotalRating, 
	(SUM(IFNULL(rating, 0))/COUNT(id))*20 ReviewPercentage
	FROM reviews WHERE item_id = $item_id;";
	$datalist = DB::select($sql);

	return $datalist;
}
	
function getReviewsBySeller($seller_id) {
	
	$sql = "SELECT COUNT(a.id) TotalReview, SUM(IFNULL(a.rating, 0)) TotalRating, 
	(SUM(IFNULL(a.rating, 0))/COUNT(a.id))*20 ReviewPercentage
	FROM reviews a
	INNER JOIN products b ON a.item_id = b.id
	WHERE b.user_id = $seller_id;";
	$datalist = DB::select($sql);

	return $datalist;
}

function OrderCount($status_id) {
	if($status_id == 0){
		$count = Order::count();
	}else{
		$count = Order::where('order_status_id', '=', $status_id)->count();
	}
	
	return $count;
}

function OrderCountForSeller($status_id) {
	
	$seller_id = Auth::user()->id;
	
	if($status_id == 0){
		$count = Order::where('seller_id', '=', $seller_id)->count();
	}else{
		$count = Order::where('order_status_id', '=', $status_id)->where('seller_id', '=', $seller_id)->count();
	}
	
	return $count;
}

function getTax() {
	
	$results = Tax::offset(0)->limit(1)->get();

	$datalist = array('id' => '', 'title' => 'VAT', 'percentage' => 0, 'is_publish' => 2);
	foreach ($results as $row){
		$datalist['id'] = $row->id;
		$datalist['title'] = $row->title;
		if($row->is_publish == 2){
			$datalist['percentage'] = 0;
		}else{
			$datalist['percentage'] = $row->percentage;
		}
		$datalist['is_publish'] = $row->is_publish;
	}
	return $datalist;
}

function str_slug($str) {

	$str_slug = Str::slug($str, "-");
	
	return $str_slug;
}

function str_url($string) {
	$string = (string) $string;

	if ( 0 === strlen($string) ) {
		return '';
	}
	
	$str_slug = Str::slug($string, "+");
	
	return $str_slug;
}

function str_limit($str) {
	
	$str_limit = Str::limit($str, 25, '...');
	
	return $str_limit;
}

function sub_str($str, $start=0, $end=1) {
	
	$string = Str::substr($str, $start, $end);

	return $string;
}

function comma_remove($string) {

	$replaced = Str::remove(',', $string);

	return $replaced;
}

function esc($string){
	$string = (string) $string;

	if ( 0 === strlen($string) ) {
		return '';
	}
	
	$string = htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
	
	return $string;
}

function NumberFormat($number){

 	$currency = Tp_option::where('option_name', 'currency')->get();
	
	$currency_id = '';
	foreach ($currency as $row){
		$currency_id = $row->id;
	}
	
	$thousands_separator = ",";
	$decimal_separator = ".";
	$decimal_digit = 2;
	
	if($currency_id != ''){
		$currencyData = json_decode($currency);
		$currencyObj = json_decode($currencyData[0]->option_value);
		
		$ThouSep = $currencyObj->thousands_separator;
		if($ThouSep == 'comma'){
			$thousands_separator = ",";
		}elseif($ThouSep == 'point'){
			$thousands_separator = ".";
		}else{
			$thousands_separator = " ";
		}
		
		$DecimalSep = $currencyObj->decimal_separator;
		if($DecimalSep == 'comma'){
			$decimal_separator = ",";
		}elseif($DecimalSep == 'point'){
			$decimal_separator = ".";
		}else{
			$decimal_separator = " ";
		}
		
		$decimal_digit = $currencyObj->decimal_digit;
	}

	$numFormat = number_format($number , $decimal_digit , $decimal_separator , $thousands_separator);
	
	return $numFormat;
}

function gSellerSettings(){

	$datalist = Tp_option::where('option_name', 'seller_settings')->get();
	$id = '';
	$option_value = '';
	foreach ($datalist as $row){
		$id = $row->id;
		$option_value = json_decode($row->option_value);
	}

	$data = array();
	if($id != ''){
		$data['fee_withdrawal'] = $option_value->fee_withdrawal;
		$data['product_auto_publish'] = $option_value->product_auto_publish;
		$data['seller_auto_active'] = $option_value->seller_auto_active;
	}else{
		$data['fee_withdrawal'] = 0;
		$data['product_auto_publish'] = 0;
		$data['seller_auto_active'] = 0;
	}
	
	return $data;
}

function gMenuUpdate($item_id, $menu_type, $item_label, $slug) {

	$data = array(
		'item_label' => $item_label,
		'custom_url' => $slug
	);
	
	Menu_parent::where('item_id', '=', $item_id)->where('menu_type', '=', $menu_type)->update($data);
	Menu_child::where('item_id', '=', $item_id)->where('menu_type', '=', $menu_type)->update($data);
}
function bottombanner() {

	$data =  Offer_ad::where('is_publish', '=', 1)->where('offer_ad_type', '=', 'bottom')->orderBy('id', 'desc')->first();
	return $data;
}

function FooterSection(){
	
	$PageVariation = PageVariation();
	$HomeVariation = $PageVariation['home_variation'];
	
	//Home Page Section 15
	$section15 = Section_manage::where('manage_type', '=', $HomeVariation)->where('section', '=', 'section_15')->where('is_publish', '=', 1)->first();
	if($section15 ==''){
		$section15_array =  array();
		$section15_array['title'] = '';
		$section15_array['desc'] = '';
		$section15_array['image'] = '';
		$section15_array['is_publish'] = 2;
		$section15 = json_decode(json_encode($section15_array));
	}
	
	return $section15;
}


if (!function_exists('PageVariation')) {

}
