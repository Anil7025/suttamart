@extends('frontend.layouts.master')

@section('title', 'Mart Sutta Home Page')

@section('content')
    <section class="home-slider position-relative mb-30">
        <div class="container">
            <div class="home-slide-cover mt-30">
                <div class="hero-slider-1 style-4 dot-style-1 dot-style-1-position-1">
                    @if (!empty($sliders) && count($sliders) > 0)
                    @foreach($sliders as $slider)
                    <div class="single-hero-slider single-animation-wrap" style="background-image: url({{ asset('uploads/sliders/' .$slider->image) }});">
                        <div class="slider-content">
                            <h1 class="display-2 mb-40">
                                {{ ucfirst($slider->title) ?? "Default Title" }}  
                            </h1>
                            <p class="mb-65">
                                {{ ucfirst($slider->description) ?? "Default Description" }}
                            </p>
                            {{-- <form class="form-subcriber d-flex">
                                <input type="email" placeholder="Your email address" />
                                <button class="btn" type="submit">Subscribe</button>
                            </form> --}}
                        </div>
                    </div>
                    @endforeach
                    @else
                    <p class="text-center">No Slider available.</p>
                     @endif
                </div>
                <div class="slider-arrow hero-slider-1-arrow"></div>
            </div>
        </div>
    </section>
    <!--End hero slider-->
    <section class="featured section-padding">
        <div class="container">
            <div class="row">
                <div class="section-title wow animate__animated animate__fadeIn" data-wow-delay=".2s">
                    <h3></h3>
                    <a class="show-all" href="{{url('provide/condition')}}">
                        All Conditions
                        <i class="fi-rs-angle-right"></i>
                    </a>
                </div>
                @if (!empty($conditions) && count($conditions) > 0)
                @php $i = 0; @endphp
                @foreach($conditions as $row)
                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 mb-md-4 mb-xl-0">
                    <div class="banner-left-icon d-flex align-items-center wow animate__animated animate__fadeInUp" data-wow-delay=".{{$i}}s">
                        <div class="banner-icon">
                            <img src="{{ asset('uploads/conditions/'.$row->icon)}}" alt="" />
                        </div>
                        <div class="banner-text">
                            <h3 class="icon-box-title">{{ ucfirst($row->title)}}</h3>
                            <p>{{ ucfirst($row->sort_description)}}</p>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                    <p class="text-center">No conditions available.</p>
                @endif
            </div>
        </div>
    </section>
    <section class="popular-categories section-padding">
        <div class="container wow animate__animated animate__fadeIn">
            <div class="section-title">
                <div class="title">
                    <h3>Product Categories</h3>
                </div>
                <div class="slider-arrow slider-arrow-2 flex-right carausel-10-columns-arrow" id="carausel-10-columns-arrows"></div>
            </div>
            <div class="carausel-10-columns-cover position-relative">
                <div class="carausel-10-columns" id="carausel-10-columns">
                    @if (!empty($pro_categores) && count($pro_categores) > 0)
                    @php $number = 1; @endphp
                    @foreach($pro_categores as $category)
                    <div class="card-2 bg-9 wow animate__animated animate__fadeInUp" data-wow-delay=".{{$number}}s">
                        <figure class="img-hover-scale overflow-hidden">
                            <a href="{{url('product-category/'.$category->id.'/'.$category->slug)}}"><img src="{{ asset('uploads/category/' . $category->image) }}" alt="category Image">
                            </a>
                        </figure>
                        <h6><a href="{{url('product-category/'.$category->id.'/'.$category->slug)}}">{{ucfirst($category->name)}}</a></h6>
                        <span>{{$category->product_count}} Products</span>
                    </div>
                    @endforeach
                    @else
                    <p class="text-center">No category available.</p>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!--End category slider-->
    <section class="banners mb-25">
        <div class="container">
            <div class="row">
                @if (!empty($offer_ads) && count($offer_ads) > 0)
                @php $number = 0; @endphp
                @foreach($offer_ads as $offer)
                <div class="col-lg-4 col-md-6">
                    <div class="banner-img wow animate__animated animate__fadeInUp" data-wow-delay=".{{$number}}s">
                        <img src="{{ asset('uploads/offerimages/'.$offer->image)}}" alt="" />
                        <div class="banner-text">
                            <h4>
                               {{ucfirst($offer->title)}} 
                            </h4>
                            <p class="mb-20">{{ucfirst($offer->description)}} </p>
                            @if($offer->url=='#')
                            <a href="{{url($offer->url)}}" class="btn btn-xs">Shop Now <i class="fi-rs-arrow-small-right"></i></a>
                            @else
                            <a href="{{url('product-offer/'.$offer->url)}}" class="btn btn-xs">Shop Now <i class="fi-rs-arrow-small-right"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <p class="text-center">No offer available.</p>
                @endif
            </div>
        </div>
    </section>
    <!--End banners-->
    <section class="product-tabs section-padding position-relative">
        <div class="container">
            <div class="section-title style-2 wow animate__animated animate__fadeIn">
                <h3>Mart Sutta Products</h3>
            </div>
            <div class="row product-grid-4">
                @if (!empty($products) && count($products) > 0)
                @php $i = 1; @endphp
                @foreach($products as $product)
                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                    <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".{{$i}}s">
                        <div class="product-img-action-wrap">
                            <div class="product-img product-img-zoom">
                                <a href="{{url('product/'.$product->id.'/'.$product->slug)}}">
                                    <img class="default-img" src="{{ asset('uploads/products/'.$product->image)}}" alt="" />
                                    <img class="hover-img" src="{{ asset('uploads/products/image2/'.$product->image2)}}" alt="" />
                                </a>
                            </div>
                        </div>
                        <div class="product-content-wrap">
                            <div class="product-category">
                                <a href="{{url('product-category/'.$product->id.'/'.$product->category_slug)}}">{{$product->category_name}}</a>
                            </div>
                            <h2><a href="{{url('product/'.$product->id.'/'.$product->slug)}}">{{ strip_tags(html_entity_decode(substr($product->title, 0, 55), ENT_QUOTES)) }}
                            </a></h2>
                            <div class="product-rate-cover">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width: 90%"></div>
                                </div>
                                <span class="font-small ml-5 text-muted"> ({{$product->TotalReview ?? ''}})</span>
                            </div>
                            <div>
                                <div class="product-card-bottom">
                                    <span class="font-small text-muted">By {{$product->brand_name}}</span>
                                    <div class="add-cart">
                                        <a aria-label="view product" class="action-btn viewquick" href="{{ url('product/'.$product->id.'/'.$product->slug) }}">
                                            <i class="fi-rs-eye"></i>
                                        </a> 
                                        <a aria-label="Add To Wishlist addtowishlist" class="action-btn" data-id="{{ $product->id }}" href="javascript:void(0);"><i class="fi-rs-heart"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-card-bottom">
                                <div class="product-price">
                                    <span>₹ {{$product->sale_price}}</span>
                                    <span class="old-price">₹ {{$product->old_price}}</span>
                                </div>
                                <div class="add-cart">
                                    <a class="add addtocart" data-id="{{ $product->id }}" href="javascript:void(0);"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <p class="text-center">No Popular Products available.</p>
                @endif
            </div>
        </div>
    </section>
    <!--Products Tabs-->
    <section class="section-padding pb-5">
        <div class="container">
            <div class="section-title wow animate__animated animate__fadeIn">
                <h3 class="">Popular Product Best Sells</h3>
            </div>
            <div class="row">
                @if (!empty($sidebar_ads) && count($sidebar_ads) > 0)
                    @php $i = 2; @endphp
                    @foreach($sidebar_ads as $sidebar)
                    <div class="col-lg-3 d-none d-lg-flex wow animate__animated animate__fadeIn" data-wow-delay=".{{$i}}s">
                        <div class="banner-img stylee">
                            <img class="banner-sidebar" src="{{asset('uploads/offerimages/' .$sidebar->image)}}">
                            <div class="banner-text">
                                <h2 class="mb-100">{{ucfirst($sidebar->title)}}</h2>
                                <a href="{{url('product-offer/'.$sidebar->url)}}" class="btn btn-xs">Shop Now <i class="fi-rs-arrow-small-right"></i></a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <p class="text-center">No Popular Products available.</p>
                    @endif
                    <div class="col-lg-9 col-md-12 wow animate__animated animate__fadeIn" data-wow-delay=".4s">
                        <div class="tab-content" id="myTabContent-1">
                            <div class="tab-pane fade show active">
                                <div class="carausel-4-columns-cover arrow-center position-relative">
                                    <div class="slider-arrow slider-arrow-2 carausel-4-columns-arrow" id="carausel-4-columns-arrows"></div>
                                    <div class="carausel-4-columns carausel-arrow-center" id="carausel-4-columns">
                                        @if (!empty($feature_products) && count($feature_products) > 0)
                                        @php $i = 2; @endphp
                                        @foreach($feature_products as $data)
                                        <div class="product-cart-wrap">
                                            <div class="product-img-action-wrap">
                                                <div class="product-img product-img-zoom">
                                                    <a href="{{url('product/'.$data->id.'/'.$data->slug)}}">
                                                        <img class="default-img" src="{{ asset('uploads/products/'.$data->image)}}" alt="" />
                                                        <img class="hover-img" src="{{ asset('uploads/products/image2/'.$data->image2)}}" alt="" />
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="product-content-wrap">
                                                <div class="product-category">
                                                    <a href="{{url('product-category/'.$data->id.'/'.$data->category_slug)}}">{{$data->category_name}}</a>
                                                </div>
                                                <h2><a href="{{url('product/'.$data->id.'/'.$data->slug)}}">{{html_entity_decode($data->title, ENT_QUOTES)}}</a></h2>
                                                <div class="product-card-bottom">
                                                    <div class="product-price">
                                                        <span>₹ {{$data->sale_price}}</span>
                                                        <span class="old-price">₹ {{$data->old_price}}</span>
                                                    </div>
                                                    <div class="add-cart mt-10">
                                                        <a aria-label="view product" class="action-btn viewquick" href="{{ url('product/'.$data->id.'/'.$data->slug) }}">
                                                            <i class="fi-rs-eye"></i>
                                                        </a>
                                                        <a aria-label="Add To Wishlist" class="action-btn" href="{{ url('product-shop-wishlist/'.$data->id.'/'.$data->slug) }}"><i class="fi-rs-heart"></i></a>
                                                    </div>
                                                </div>
                                                
                                                <div class="sold mt-15 mb-15">
                                                    <div class="progress mb-5">
                                                        <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <a data-id="{{ $data->id }}" href="javascript:void(0);" class="btn w-100 hover-up addtocart"><i class="fi-rs-shopping-cart mr-5"></i>Add To Cart</a>
                                            </div>
                                        </div>                              
                                        @endforeach
                                        @else
                                        <p class="text-center">No Popular Products available.</p>
                                        @endif
                                        <!--End product Wrap-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--End tab-content-->
                    </div>
                <!--End Col-lg-9-->
            </div>
        </div>
    </section>
    
    <section class="section-padding pb-5">
        <div class="container">
            <div class="section-title wow animate__animated animate__fadeIn">
                <h3 class="">Best deals Of The Day</h3>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 wow animate__animated animate__fadeIn" data-wow-delay=".4s">
                    <div class="carausel-4-columns-cover arrow-center position-relative">
                        <div class="slider-arrow slider-arrow-2 carausel-3-columns-arrow" id="carausel-3-columns-arrows"></div>
                        <div class="carausel-4-columns carausel-arrow-center" id="carausel-3-columns">
                            @if (!empty($popular_products) && count($popular_products) > 0)
                                @foreach($popular_products as $row)
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href="{{ url('product/'.$row->id.'/'.$row->slug) }}">
                                                    <img class="default-img" src="{{ asset('uploads/products/'.$row->image) }}" alt="{{ $row->title }}" />
                                                    <img class="hover-img" src="{{ asset('uploads/products/image2/'.$row->image2) }}" alt="{{ $row->title }}" />
                                                </a>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href="{{ url('product-category/'.$row->id.'/'.$row->category_slug) }}">
                                                    {{ $row->category_name }}
                                                </a>
                                            </div>
                                            <h2>
                                                <a href="{{ url('product/'.$row->id.'/'.$row->slug) }}">
                                                    {{ strip_tags(html_entity_decode($row->title, ENT_QUOTES)) }}
                                                </a>
                                            </h2>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>₹ {{ $row->sale_price }}</span>
                                                    <span class="old-price">₹ {{ $row->old_price }}</span>
                                                </div>
                                                <div class="add-cart mt-10">
                                                    <a href="{{ url('product/'.$row->id.'/'.$row->slug) }}" aria-label="Quick view" class="action-btn viewquick small hover-up open-modal-btn">
                                                        <i class="fi-rs-eye"></i>
                                                    </a>
                                                    <a aria-label="Add To Wishlist" class="action-btn" 
                                                        href="{{ url('product-shop-wishlist/'.$row->id.'/'.$row->slug) }}">
                                                        <i class="fi-rs-heart"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="sold mt-15 mb-15">
                                                <div class="progress mb-5">
                                                    <div class="progress-bar" role="progressbar" style="width: 50%" 
                                                            aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </div>
                                            <a data-id="{{ $row->id }}" href="javascript:void(0);" class="btn w-100 hover-up addtocart">
                                                <i class="fi-rs-shopping-cart mr-5"></i>Add To Cart
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-center">No Trending Products available.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!--End 4 columns-->
    <section class="popular-categories section-padding">
        <div class="container">
            <div class="section-title">
                <div class="title">
                    <h3>Brands </h3>
                    <span class="show-all" >
                        We Deal In
                    </span>
                </div>
                <div class="slider-arrow slider-arrow-2 flex-right carausel-8-columns-arrow" id="carausel-8-columns-arrows"></div>
            </div>
            <div class="carausel-8-columns-cover position-relative">
                <div class="carausel-8-columns" id="carausel-8-columns">
                    @if (!empty($brands) && count($brands) > 0)
                    @php $i = 2; @endphp
                    @foreach($brands as $brand)
                    <div class="card-1 wow animate__animated animate__fadeIn" data-wow-delay=".{{$i}}s">
                        <figure class="img-hover-scale overflow-hidden">
                            <img class="brandImg" src="{{ asset('uploads/brands/'.$brand->thumbnail)}}" alt="" />
                        </figure>
                    </div>
                    @endforeach
                    @else
                    <p class="text-center">No Brands  available.</p>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!--End category slider-->
    <!--End Happy Client-->
    <div class="container">
        <div class="section-title wow animate__animated animate__fadeIn" data-wow-delay=".2s">
            <h3 class="">What do our users say?</h3>
            <a class="show-all" href="{{ url('client') }}">
                All Client <i class="fi-rs-angle-right"></i>
            </a>
        </div>
    </div>
    <section class="popular-categories section-padding testmonialsection">
        <div class="container mb-10">
            @if (!empty($testimonials) && count($testimonials) > 0)
                <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
                    
                    <!-- Indicators -->
                    <div class="carousel-indicators">
                        @foreach($testimonials as $index => $row)
                            <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></button>
                        @endforeach
                    </div>
            
                    <!-- Testimonial Items -->
                    <div class="carousel-inner">
                        @foreach($testimonials as $index => $row)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <div class="testimonial text-center">
                                    <img src="{{ asset('uploads/testimonials/' . $row->image) }}" alt="User" class="img-fluid rounded-circle mb-3" width="100">
                                    <p class="tesmonialText">"{{ ucfirst(substr($row->description, 0, 100)) }}..."</p>
                                    <h5>- {{ ucfirst($row->name) }}</h5>
                                    <p class="text-muted tesmonialText2">- {{ ucfirst($row->designation) }} -</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
            
                    <!-- Controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            @else
                <p class="text-center">No testimonials available.</p>
            @endif
        </div> 
    </section>
        
     <!--Start Brands-->
    <section class="popular-categories section-padding">
        <div class="container">
            <div class="section-title wow animate__animated animate__fadeIn" data-wow-delay="0">
                <h3 class="">Blog</h3>
                <a class="show-all" href="{{url('blog')}}">
                    All Blog
                    <i class="fi-rs-angle-right"></i>
                </a>
            </div>
            <div class="loop-grid pr-30">
                <div class="row">
                    @if (!empty($blogs) && count($blogs) > 0)
                    @php $i =1;  @endphp
                    @foreach($blogs as $row)
                    <article class="col-xl-4 col-lg-6 col-md-6 text-center hover-up mb-30 wow animate__animated animate__fadeInUp" data-wow-delay=".{{$i}}s">
                        <div class="post-thumb">
                            <a href="{{url('blogs/'.$row->id.'/'.$row->slug)}}">
                                <img class="border-radius-15 postBlogImg" src="{{ asset('uploads/blogs/' . $row->image) }}" alt="" />
                            </a>
                            <div class="entry-meta">
                                <a class="entry-meta meta-2" href="{{url('blogs/'.$row->id.'/'.$row->slug)}}"><i class="fi-rs-link"></i></a>
                            </div>
                        </div>
                        <div class="entry-meta font-xs color-grey mt-10 pb-10">
                            <div>
                                <span class="post-on has-dot mr-50">By {{$row->user_name}}</span>
                                <span class="hit-count has-dot">{{ date('d F Y', strtotime($row->created_at)) }}</span>
                            </div>
                        </div>
                        <div class="entry-content-2">
                            <h4 class="post-title mb-15">
                                <a href="{{url('blogs/'.$row->id.'/'.$row->slug)}}">{{$row->title}}</a>
                            </h4>
                            
                        </div>
                    </article>
                    @endforeach
                    @else
                    <p class="text-center">No Blog available.</p>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!--End Brands-->
@endsection
@push('scripts')
<script type="text/javascript">
     $(document).ready(function () {
        $(".quick-view-btn").click(function (e) {
            e.preventDefault();
            var modalId = $(this).attr("data-bs-target");
            $(modalId).modal("show");
        });
    });
</script>
<script src="{{asset('frontend/jspages/cart.js')}}"></script>
@endpush