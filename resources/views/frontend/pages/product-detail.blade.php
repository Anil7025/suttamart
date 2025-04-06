@extends('frontend.layouts.master')

@section('title', 'Mart Sutta Product Page')

@section('content')
<div class="page-header breadcrumb-wrap">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{url('/')}}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
            <span></span><a href="{{url('/product')}}" rel="nofollow"> Product </a><span></span>{{ $data->title }}
        </div>
    </div>
</div>
<div class="container mb-30">
    <div class="row">
        <div class="col-xl-10 col-lg-12 m-auto">
            <div class="product-detail accordion-detail">
                <div class="row mb-50 mt-30">
                    <div class="col-md-6 col-sm-12 col-xs-12 mb-md-0 mb-sm-5">
                        <div class="detail-gallery">
                            <span class="zoom-icon"><i class="fi-rs-search"></i></span>
                            <!-- MAIN SLIDES -->
                            <div class="product-image-slider">
                                @if(count($pro_images)>0)
						        @foreach ($pro_images as $key => $row)
                                <figure class="border-radius-10">
                                    <img src="{{ asset('uploads/product-images/'.$row->thumbnail)}}" alt="{{$key}}" />
                                </figure>
                                @endforeach
                                @else
                                <figure class="border-radius-10">
                                    <img src="{{ asset('uploads/products/'.$data->image)}}" alt="{{$data->title}}" />
                                </figure>
                                @endif
                            </div>
                            <!-- THUMBNAILS -->
                            <div class="slider-nav-thumbnails">
                                @if(count($pro_images)>0)
						        @foreach ($pro_images as $key => $row)
                                <div><img src="{{ asset('uploads/product-images/'.$row->thumbnail)}}" alt="{{$key}}" /></div>
                                @endforeach
                                @else
                                <div><img src="{{ asset('uploads/products/'.$data->image)}}" alt="{{$data->title}}" /></div>
                                @endif
                            </div>
                        </div>
                        <!-- End Gallery -->
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="detail-info pr-30 pl-30">
                            <span class="stock-status out-stock"> {{$data->brandname}} </span>
                            <h2 class="title-detail">{{ ucfirst($data->title) }}</h2>
                            <div class="short-desc mb-30 mt-20">
                                <p class="font-lg">{{ucfirst($data->short_desc)}}</p>
                            </div>
                            <div class="product-detail-rating">
                                <div class="product-rate-cover text-end">
                                    @if($data->is_stock == 1)
                                        @if($data->stock_status_id == 1)
                                        <div class="pr_extra"><strong>{{ __('Availability') }}: </strong><span class="stock-status stock-status">{{ $data->stock_qty }} {{ __('In Stock') }}</span></div>
                                        @else
                                        <div class="pr_extra"><strong>{{ __('Availability') }}: </strong><span class="stock-status out-stock">{{ __('Out Of Stock') }}</span></div>
                                        @endif
                                    @endif
                                </div>
                                <div class="pr_pincode">
                                    <div class="product-rate d-inline-block">
                                        <div class="product-rating" style="width: 90%"></div>
                                    </div>
                                    <span class="font-small ml-5 text-muted"> ({{$total_reviews ?? '0'}} reviews)</span>
                                </div>
                            </div>
                            <div class="clearfix product-price-cover">
                                @if(($data->is_discount == 1) && ($data->old_price !=''))
                                @php 
                                    $discount = number_format((($data->old_price - $data->sale_price)*100)/$data->old_price);
                                @endphp
                                <div class="product-price primary-color float-left">
                                    <span class="current-price text-brand">₹ {{ $data->sale_price }}</span>
                                    <span>
                                        <span class="save-price font-md color3 ml-15">{{$discount}}% Off</span>
                                        <span class="old-price font-md ml-15">₹ {{$data->old_price}}</span>
                                    </span>
                                </div>
                                @endif
                            </div>
                            
                            <div class="attr-detail attr-size mb-30">
                                <strong class="mr-10">Size  </strong>
                                @if($data->variation_size != '')
                                <div class="list-filter size-filter font-small">
                                    {{ $data->variation_size }}
                                </div>
                                @endif
                            </div>
                            <label for="pincode">{{ __('Pincode') }}</label>
                            <div class="detail-pincode border radius pr_pincode mb-20">
                                <input name="pincode" id="pincode" class="qty-val" type="number" min="1" max="999999"  value="1">
                            </div>
                            <div class="detail-extralink mb-50">
                                <div class="detail-qty border radius">
                                    <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                    <input type="text" name="quantity" class="qty-val" value="1" min="1">
                                    <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                </div>
                                <div class="product-extra-link2">
                                    <button type="button" class="button button-add-to-cart cart product_addtocart" data-id="{{ $data->id }}" data-stockqty="{{ $data->is_stock == 1 ? $data->stock_qty : 999 }}" href="javascript:void(0);"><i class="fi-rs-shopping-cart"></i>Add to cart</button>
                                    <a aria-label="Add To Wishlist" class="action-btn hover-up cart wishlist addtowishlist" href="javascript:void(0);"><i class="fi-rs-heart"></i></a>
                                    <a aria-label="Compare" class="hover-up cart product_buy_now" data-id="{{ $data->id }}" data-stockqty="{{ $data->is_stock == 1 ? $data->stock_qty : 999 }}" href="javascript:void(0);"></i>{{ __('Buy Now') }}</a>
                                </div>
                            </div>
                            <div class="font-xs">
                                <ul class="mr-50 float-start">
                                    <li class="mb-5">Type: <span class="text-brand">Sutta Mart</span></li>
                                    <li class="mb-5">MFG:<span class="text-brand"> {{ date('d F Y', strtotime($data->created_at)) }}</span></li>
                                </ul>
                                <ul class="float-start">
                                    @if($data->is_stock == 1)
							        @if($data->sku != '')
                                    <li class="mb-5">SKU: <a href="#">{{ $data->sku }}</a></li>
                                    @endif
						            @endif
                                    <li class="mb-5">Category: <a href="{{ url('product-category/'.$data->id.'/'.$data->cat_slug) }}" rel="tag">{{ $data->cat_name }}</a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- Detail Info -->
                    </div>
                </div>
                <div class="product-info mb-50">
                    <div class="tab-style3">
                        <ul class="nav nav-tabs text-uppercase">
                            <li class="nav-item">
                                <a class="nav-link active" id="Description-tab" data-bs-toggle="tab" href="#Description">Description</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="Reviews-tab" data-bs-toggle="tab" href="#Reviews">Reviews ({{$total_reviews ?? '0'}})</a>
                            </li>
                        </ul>
                        <div class="tab-content shop_info_tab entry-main-content">
                            <div class="tab-pane fade show active" id="Description">
                                <div class="">
                                    <p>{{strip_tags($data->description)}}</p>
                                   
                                </div>
                            </div>
                            <div class="tab-pane fade" id="Reviews">
                                <!--Comments-->
                                <div class="comments-area">
                                    <div class="row">
                                        @include('frontend.pages.products-reviews-grid')
                                        
                                        <div class="col-lg-4">
                                        </div>
                                    </div>
                                </div>
                                <!--comment form-->
                                
                                <div class="comment-form">
                                    <h4 class="mb-15">Add a review</h4>
                                    <div class="product-rate d-inline-block mb-30"></div>
                                    <div class="row">
                                        <div class="col-lg-8 col-md-12">
                                            @php $userId = Auth::check() ? Auth::user()->id : null; @endphp
                                            <form class="form-contact comment_form" id="commentForm" method="post">
                                                @csrf
                                                @if(isset(Auth::user()->name))
                                                <input type="hidden" name="item_id" value="{{ $data->id }}">
                                                <input type="hidden" name="user_id" value="{{Auth::user()->id ?? '0'}}">
                                            
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <textarea class="form-control w-100" name="comment" id="comment" cols="30" rows="5" placeholder="Write Comment"></textarea>
                                                        </div>
                                                    </div>
                                            
                                                    <!-- Star Rating -->
                                                    <div class="col-12">
                                                        <div class="form-group starRating">
                                                            <div class="mb-3">
                                                                <label for="rating" class="form-label">{{ __('Your rating of this product') }}</label>
                                                                <select id="rating" name="rating" class=" form-control">
                                                                    <option value="5">5 Star</option>
                                                                    <option value="4">4 Star</option>
                                                                    <option value="3">3 Star</option>
                                                                    <option value="2">2 Star</option>
                                                                    <option value="1">1 Star</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                            
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <button type="submit" class="button button-contactForm">Submit Review</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                @else
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <textarea class="form-control w-100" name="comment" id="comment" cols="30" rows="5" placeholder="Write Comment"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <a type="submit" href="{{ route('login') }}" class="button button-contactForm">Submit Review</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            </form>
                                        </div>
                                        <div class="col-lg-4 col-md-8">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-60">
                    <div class="col-12">
                        <h2 class="section-title style-1 mb-30">Related products</h2>
                    </div>
                    <div class="col-12">
                        <div class="row related-products">
                            <div class="col-lg-12 col-md-12 wow animate__animated animate__fadeIn" data-wow-delay=".4s">
                                <div class="carausel-4-columns-cover arrow-center position-relative">
                                    <div class="slider-arrow slider-arrow-2 carausel-3-columns-arrow" id="carausel-3-columns-arrows"></div>
                                        <div class="carausel-4-columns carausel-arrow-center" id="carausel-3-columns">
                                            @if(count($related_products)>0)
                                            @foreach ($related_products as $row)
                                            @php 
                                                if(($row->is_discount == 1) && ($row->old_price !='')){
                                                    $discount = number_format((($row->old_price - $row->sale_price)*100)/$row->old_price);
                                                }
                                            @endphp
                                            <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                                                <div class="product-cart-wrap hover-up">
                                                    <div class="product-img-action-wrap">
                                                        <div class="product-img product-img-zoom">
                                                            <a href="{{url('product/'.$row->id.'/'.$row->slug)}}" tabindex="0">
                                                                <img class="default-img" src="{{ asset('uploads/products/'.$row->image) }}" alt="{{ $row->title }}" />
                                                                <img class="hover-img" src="{{ asset('uploads/products/image2/'.$row->image2) }}" alt="{{ $row->title }}" />
                                                            </a>
                                                        </div>
                                                        <div class="product-badges product-badges-position product-badges-mrg">
                                                            <span class="hot">{{$discount}} Off</span>
                                                        </div>
                                                    </div>
                                                    <div class="product-content-wrap">
                                                        <h2><a href="{{url('product/'.$row->id.'/'.$row->slug)}}" tabindex="0"> {{ strip_tags(html_entity_decode(substr($row->title, 0, 55), ENT_QUOTES)) }}</a></h2>
                                                        <div class="rating-result" title="90%">
                                                            <span> </span>
                                                        </div>
                                                        <div class="product-card-bottom">
                                                            <div class="product-price">
                                                                <span>₹ {{ $row->sale_price }} </span>
                                                                <span class="old-price">₹ {{ $row->old_price }}</span>
                                                            </div>
                                                            <div class="add-cart">
                                                                <a aria-label="Add To Wishlist" class="action-btn" href="{{ url('product-shop-wishlist/'.$row->id.'/'.$row->slug) }}"><i class="fi-rs-heart"></i></a>
                                                                <a class="add addtocart" data-id="{{ $row->id }}" href="javascript:void(0);"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>                                            
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                            @else
                                            @foreach ($category_products as $row)
                                            <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                                                <div class="product-cart-wrap hover-up">
                                                    <div class="product-img-action-wrap">
                                                        <div class="product-img product-img-zoom">
                                                            <a href="{{url('product-category/'.$row->id.'/'.$row->slug)}}" tabindex="0">
                                                                <img class="default-img" src="{{ asset('uploads/products/'.$row->image) }}" alt="{{ $row->title }}" />
                                                                <img class="hover-img" src="{{ asset('uploads/products/image2/'.$row->image2) }}" alt="{{ $row->title }}" />
                                                            </a>
                                                        </div>
                                                        <div class="product-badges product-badges-position product-badges-mrg">
                                                            <span class="hot">{{$discount}} Off</span>
                                                        </div>
                                                    </div>
                                                    <div class="product-content-wrap">
                                                        <h2><a href="{{url('product-category/'.$row->id.'/'.$row->slug)}}" tabindex="0"> {{ strip_tags(html_entity_decode(substr($row->title, 0, 55), ENT_QUOTES)) }}</a></h2>
                                                        <div class="rating-result" title="90%">
                                                            <span> </span>
                                                        </div>
                                                        <div class="product-card-bottom">
                                                            <div class="product-price">
                                                                <span>₹ {{ $row->sale_price }} </span>
                                                                <span class="old-price">₹ {{ $row->old_price }}</span>
                                                            </div>
                                                            <div class="add-cart">
                                                                <a aria-label="Add To Wishlist" class="action-btn" href="{{ url('product-shop-wishlist/'.$row->id.'/'.$row->slug) }}"><i class="fi-rs-heart"></i></a>
                                                                <a class="add addtocart" data-id="{{ $row->id }}" href="javascript:void(0);"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>                                            
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div> 
                            </div>   
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
 	var item_id = "{{ $data->id }}";
	var is_stock = "{{ $data->is_stock }}";
	var is_stock_status = "{{ $data->stock_status_id }}";
	
var TEXT = [];
	TEXT['Please enter quantity.'] = "{{ __('Please enter quantity.') }}";
	TEXT['The value must be less than or equal to'] = "{{ __('The value must be less than or equal to') }} {{ $data->is_stock == 1 ? $data->stock_qty : '' }}";	
	TEXT['This product out of stock.'] = "{{ __('This product out of stock.') }}";	

 
</script>
<script src="{{ asset('frontend/jspages/product.js') }}"></script>

@endpush