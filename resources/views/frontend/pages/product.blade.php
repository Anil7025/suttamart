@extends('frontend.layouts.master')

@section('title', 'Mart Sutta Product Page')

@section('content')
<div class="page-header breadcrumb-wrap">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{url('/')}}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
            <span></span> Pages <span></span>Product List
        </div>
    </div>
</div>
<div class="container mb-30" style="transform: none;">
    <div class="row flex-row-reverse" style="transform: none;">
        <div class="col-lg-4-5">
            <div class="shop-product-fillter">
                <div class="totall-product">
                    <p>We found <strong class="text-brand">29</strong> items for you!</p>
                </div>
                <div class="sort-by-product-area">
                    <div class="sort-by-cover mr-10">
                        <div class="sort-by-product-wrap">
                            <div class="sort-by">
                                <span><i class="fi-rs-apps"></i>Show:</span>
                            </div>
                            <div class="sort-by-dropdown-wrap">
                                <span> 50 <i class="fi-rs-angle-small-down"></i></span>
                            </div>
                        </div>
                        <div class="sort-by-dropdown">
                            <ul>
                                <li><a class="active" href="#">50</a></li>
                                <li><a href="#">100</a></li>
                                <li><a href="#">150</a></li>
                                <li><a href="#">200</a></li>
                                <li><a href="#">All</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="sort-by-cover">
                        <div class="sort-by-product-wrap">
                            <div class="sort-by">
                                <span><i class="fi-rs-apps-sort"></i>Sort by:</span>
                            </div>
                            <div class="sort-by-dropdown-wrap">
                                <span> Featured <i class="fi-rs-angle-small-down"></i></span>
                            </div>
                        </div>
                        <div class="sort-by-dropdown">
                            <ul>
                                <li><a class="active" href="#">Featured</a></li>
                                <li><a href="#">Price: Low to High</a></li>
                                <li><a href="#">Price: High to Low</a></li>
                                <li><a href="#">Release Date</a></li>
                                <li><a href="#">Avg. Rating</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row product-grid">
                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                    <div class="product-cart-wrap mb-30">
                        <div class="product-img-action-wrap">
                            <div class="product-img product-img-zoom">
                                <a href="shop-product-right">
                                    <img class="default-img" src="{{ asset('frontend/images/shop/product-1-1.jpg')}}" alt="">
                                    <img class="hover-img" src="{{ asset('frontend/images/shop/product-1-2.jpg')}}" alt="">
                                </a>
                            </div>
                            <div class="product-action-1">
                                <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist"><i class="fi-rs-heart"></i></a>
                                <a aria-label="Compare" class="action-btn" href="shop-compare"><i class="fi-rs-shuffle"></i></a>
                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                            </div>
                            <div class="product-badges product-badges-position product-badges-mrg">
                                <span class="hot">Hot</span>
                            </div>
                        </div>
                        <div class="product-content-wrap">
                            <div class="product-category">
                                <a href="shop-grid-right">Snack</a>
                            </div>
                            <h2><a href="shop-product-right">Seeds of Change Organic Quinoe</a></h2>
                            <div class="product-rate-cover">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width: 90%"></div>
                                </div>
                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                            </div>
                            <div>
                                <span class="font-small text-muted">By <a href="vendor-details-1">NestFood</a></span>
                            </div>
                            <div class="product-card-bottom">
                                <div class="product-price">
                                    <span>$28.85</span>
                                    <span class="old-price">$32.8</span>
                                </div>
                                <div class="add-cart">
                                    <a class="add" href="shop-cart"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end product card-->
                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                    <div class="product-cart-wrap mb-30">
                        <div class="product-img-action-wrap">
                            <div class="product-img product-img-zoom">
                                <a href="shop-product-right">
                                    <img class="default-img" src="{{ asset('frontend/images/shop/product-2-1.jpg')}}" alt="">
                                    <img class="hover-img" src="{{ asset('frontend/images/shop/product-2-2.jpg')}}" alt="">
                                </a>
                            </div>
                            <div class="product-action-1">
                                <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist"><i class="fi-rs-heart"></i></a>
                                <a aria-label="Compare" class="action-btn" href="shop-compare"><i class="fi-rs-shuffle"></i></a>
                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                            </div>
                            <div class="product-badges product-badges-position product-badges-mrg">
                                <span class="sale">Sale</span>
                            </div>
                        </div>
                        <div class="product-content-wrap">
                            <div class="product-category">
                                <a href="shop-grid-right">Hodo Foods</a>
                            </div>
                            <h2><a href="shop-product-right">All Natural Italian-Style Chicken Meatballs</a></h2>
                            <div class="product-rate-cover">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width: 80%"></div>
                                </div>
                                <span class="font-small ml-5 text-muted"> (3.5)</span>
                            </div>
                            <div>
                                <span class="font-small text-muted">By <a href="vendor-details-1">Stouffer</a></span>
                            </div>
                            <div class="product-card-bottom">
                                <div class="product-price">
                                    <span>$52.85</span>
                                    <span class="old-price">$55.8</span>
                                </div>
                                <div class="add-cart">
                                    <a class="add" href="shop-cart"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end product card-->
                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                    <div class="product-cart-wrap mb-30">
                        <div class="product-img-action-wrap">
                            <div class="product-img product-img-zoom">
                                <a href="shop-product-right">
                                    <img class="default-img" src="{{ asset('frontend/images/shop/product-3-1.jpg')}}" alt="">
                                    <img class="hover-img" src="{{ asset('frontend/images/shop/product-3-2.jpg')}}" alt="">
                                </a>
                            </div>
                            <div class="product-action-1">
                                <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist"><i class="fi-rs-heart"></i></a>
                                <a aria-label="Compare" class="action-btn" href="shop-compare"><i class="fi-rs-shuffle"></i></a>
                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                            </div>
                            <div class="product-badges product-badges-position product-badges-mrg">
                                <span class="new">New</span>
                            </div>
                        </div>
                        <div class="product-content-wrap">
                            <div class="product-category">
                                <a href="shop-grid-right">Snack</a>
                            </div>
                            <h2><a href="shop-product-right">Angie’s Boomchickapop Sweet &amp; Salty</a></h2>
                            <div class="product-rate-cover">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width: 85%"></div>
                                </div>
                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                            </div>
                            <div>
                                <span class="font-small text-muted">By <a href="vendor-details-1">StarKist</a></span>
                            </div>
                            <div class="product-card-bottom">
                                <div class="product-price">
                                    <span>$48.85</span>
                                    <span class="old-price">$52.8</span>
                                </div>
                                <div class="add-cart">
                                    <a class="add" href="shop-cart"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end product card-->
                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                    <div class="product-cart-wrap mb-30">
                        <div class="product-img-action-wrap">
                            <div class="product-img product-img-zoom">
                                <a href="shop-product-right">
                                    <img class="default-img" src="{{ asset('frontend/images/shop/product-4-1.jpg')}}" alt="">
                                    <img class="hover-img" src="{{ asset('frontend/images/shop/product-4-2.jpg')}}" alt="">
                                </a>
                            </div>
                            <div class="product-action-1">
                                <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist"><i class="fi-rs-heart"></i></a>
                                <a aria-label="Compare" class="action-btn" href="shop-compare"><i class="fi-rs-shuffle"></i></a>
                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                            </div>
                        </div>
                        <div class="product-content-wrap">
                            <div class="product-category">
                                <a href="shop-grid-right">Vegetables</a>
                            </div>
                            <h2><a href="shop-product-right">Foster Farms Takeout Crispy Classic</a></h2>
                            <div class="product-rate-cover">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width: 90%"></div>
                                </div>
                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                            </div>
                            <div>
                                <span class="font-small text-muted">By <a href="vendor-details-1">NestFood</a></span>
                            </div>
                            <div class="product-card-bottom">
                                <div class="product-price">
                                    <span>$17.85</span>
                                    <span class="old-price">$19.8</span>
                                </div>
                                <div class="add-cart">
                                    <a class="add" href="shop-cart"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end product card-->
                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                    <div class="product-cart-wrap mb-30">
                        <div class="product-img-action-wrap">
                            <div class="product-img product-img-zoom">
                                <a href="shop-product-right">
                                    <img class="default-img" src="{{ asset('frontend/images/shop/product-5-1.jpg')}}" alt="">
                                    <img class="hover-img" src="{{ asset('frontend/images/shop/product-5-2.jpg')}}" alt="">
                                </a>
                            </div>
                            <div class="product-action-1">
                                <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist"><i class="fi-rs-heart"></i></a>
                                <a aria-label="Compare" class="action-btn" href="shop-compare"><i class="fi-rs-shuffle"></i></a>
                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                            </div>
                            <div class="product-badges product-badges-position product-badges-mrg">
                                <span class="best">-14%</span>
                            </div>
                        </div>
                        <div class="product-content-wrap">
                            <div class="product-category">
                                <a href="shop-grid-right">Pet Foods</a>
                            </div>
                            <h2><a href="shop-product-right">Blue Diamond Almonds Lightly</a></h2>
                            <div class="product-rate-cover">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width: 90%"></div>
                                </div>
                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                            </div>
                            <div>
                                <span class="font-small text-muted">By <a href="vendor-details-1">NestFood</a></span>
                            </div>
                            <div class="product-card-bottom">
                                <div class="product-price">
                                    <span>$23.85</span>
                                    <span class="old-price">$25.8</span>
                                </div>
                                <div class="add-cart">
                                    <a class="add" href="shop-cart"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end product card-->
                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                    <div class="product-cart-wrap mb-30">
                        <div class="product-img-action-wrap">
                            <div class="product-img product-img-zoom">
                                <a href="shop-product-right">
                                    <img class="default-img" src="{{ asset('frontend/images/shop/product-6-1.jpg')}}" alt="">
                                    <img class="hover-img" src="{{ asset('frontend/images/shop/product-6-2.jpg')}}" alt="">
                                </a>
                            </div>
                            <div class="product-action-1">
                                <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist"><i class="fi-rs-heart"></i></a>
                                <a aria-label="Compare" class="action-btn" href="shop-compare"><i class="fi-rs-shuffle"></i></a>
                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                            </div>
                        </div>
                        <div class="product-content-wrap">
                            <div class="product-category">
                                <a href="shop-grid-right">Hodo Foods</a>
                            </div>
                            <h2><a href="shop-product-right">Chobani Complete Vanilla Greek</a></h2>
                            <div class="product-rate-cover">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width: 90%"></div>
                                </div>
                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                            </div>
                            <div>
                                <span class="font-small text-muted">By <a href="vendor-details-1">NestFood</a></span>
                            </div>
                            <div class="product-card-bottom">
                                <div class="product-price">
                                    <span>$54.85</span>
                                    <span class="old-price">$55.8</span>
                                </div>
                                <div class="add-cart">
                                    <a class="add" href="shop-cart"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end product card-->
                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                    <div class="product-cart-wrap mb-30">
                        <div class="product-img-action-wrap">
                            <div class="product-img product-img-zoom">
                                <a href="shop-product-right">
                                    <img class="default-img" src="{{ asset('frontend/images/shop/product-7-1.jpg')}}" alt="">
                                    <img class="hover-img" src="{{ asset('frontend/images/shop/product-7-2.jpg')}}" alt="">
                                </a>
                            </div>
                            <div class="product-action-1">
                                <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist"><i class="fi-rs-heart"></i></a>
                                <a aria-label="Compare" class="action-btn" href="shop-compare"><i class="fi-rs-shuffle"></i></a>
                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                            </div>
                        </div>
                        <div class="product-content-wrap">
                            <div class="product-category">
                                <a href="shop-grid-right">Meats</a>
                            </div>
                            <h2><a href="shop-product-right">Canada Dry Ginger Ale – 2 L Bottle</a></h2>
                            <div class="product-rate-cover">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width: 90%"></div>
                                </div>
                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                            </div>
                            <div>
                                <span class="font-small text-muted">By <a href="vendor-details-1">NestFood</a></span>
                            </div>
                            <div class="product-card-bottom">
                                <div class="product-price">
                                    <span>$32.85</span>
                                    <span class="old-price">$33.8</span>
                                </div>
                                <div class="add-cart">
                                    <a class="add" href="shop-cart"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end product card-->
                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                    <div class="product-cart-wrap mb-30">
                        <div class="product-img-action-wrap">
                            <div class="product-img product-img-zoom">
                                <a href="shop-product-right">
                                    <img class="default-img" src="{{ asset('frontend/images/shop/product-8-1.jpg')}}" alt="">
                                    <img class="hover-img" src="{{ asset('frontend/images/shop/product-8-2.jpg')}}" alt="">
                                </a>
                            </div>
                            <div class="product-action-1">
                                <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist"><i class="fi-rs-heart"></i></a>
                                <a aria-label="Compare" class="action-btn" href="shop-compare"><i class="fi-rs-shuffle"></i></a>
                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                            </div>
                            <div class="product-badges product-badges-position product-badges-mrg">
                                <span class="sale">Sale</span>
                            </div>
                        </div>
                        <div class="product-content-wrap">
                            <div class="product-category">
                                <a href="shop-grid-right">Snack</a>
                            </div>
                            <h2><a href="shop-product-right">Encore Seafoods Stuffed Alaskan</a></h2>
                            <div class="product-rate-cover">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width: 90%"></div>
                                </div>
                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                            </div>
                            <div>
                                <span class="font-small text-muted">By <a href="vendor-details-1">NestFood</a></span>
                            </div>
                            <div class="product-card-bottom">
                                <div class="product-price">
                                    <span>$35.85</span>
                                    <span class="old-price">$37.8</span>
                                </div>
                                <div class="add-cart">
                                    <a class="add" href="shop-cart"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end product card-->
                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                    <div class="product-cart-wrap mb-30">
                        <div class="product-img-action-wrap">
                            <div class="product-img product-img-zoom">
                                <a href="shop-product-right">
                                    <img class="default-img" src="{{ asset('frontend/images/shop/product-9-1.jpg')}}" alt="">
                                    <img class="hover-img" src="{{ asset('frontend/images/shop/product-9-2.jpg')}}" alt="">
                                </a>
                            </div>
                            <div class="product-action-1">
                                <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist"><i class="fi-rs-heart"></i></a>
                                <a aria-label="Compare" class="action-btn" href="shop-compare"><i class="fi-rs-shuffle"></i></a>
                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                            </div>
                            <div class="product-badges product-badges-position product-badges-mrg">
                                <span class="hot">Hot</span>
                            </div>
                        </div>
                        <div class="product-content-wrap">
                            <div class="product-category">
                                <a href="shop-grid-right">Coffes</a>
                            </div>
                            <h2><a href="shop-product-right">Gorton’s Beer Battered Fish Fillets</a></h2>
                            <div class="product-rate-cover">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width: 90%"></div>
                                </div>
                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                            </div>
                            <div>
                                <span class="font-small text-muted">By <a href="vendor-details-1">Old El Paso</a></span>
                            </div>
                            <div class="product-card-bottom">
                                <div class="product-price">
                                    <span>$23.85</span>
                                    <span class="old-price">$25.8</span>
                                </div>
                                <div class="add-cart">
                                    <a class="add" href="shop-cart"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end product card-->
                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 d-none d-xl-block">
                    <div class="product-cart-wrap mb-30">
                        <div class="product-img-action-wrap">
                            <div class="product-img product-img-zoom">
                                <a href="shop-product-right">
                                    <img class="default-img" src="{{ asset('frontend/images/shop/product-10-1.jpg')}}" alt="">
                                    <img class="hover-img" src="{{ asset('frontend/images/shop/product-10-2.jpg')}}" alt="">
                                </a>
                            </div>
                            <div class="product-action-1">
                                <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist"><i class="fi-rs-heart"></i></a>
                                <a aria-label="Compare" class="action-btn" href="shop-compare"><i class="fi-rs-shuffle"></i></a>
                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                            </div>
                        </div>
                        <div class="product-content-wrap">
                            <div class="product-category">
                                <a href="shop-grid-right">Cream</a>
                            </div>
                            <h2><a href="shop-product-right">Haagen-Dazs Caramel Cone Ice Cream</a></h2>
                            <div class="product-rate-cover">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width: 50%"></div>
                                </div>
                                <span class="font-small ml-5 text-muted"> (2.0)</span>
                            </div>
                            <div>
                                <span class="font-small text-muted">By <a href="vendor-details-1">Tyson</a></span>
                            </div>
                            <div class="product-card-bottom">
                                <div class="product-price">
                                    <span>$22.85</span>
                                    <span class="old-price">$24.8</span>
                                </div>
                                <div class="add-cart">
                                    <a class="add" href="shop-cart"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end product card-->
                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                    <div class="product-cart-wrap mb-30">
                        <div class="product-img-action-wrap">
                            <div class="product-img product-img-zoom">
                                <a href="shop-product-right">
                                    <img class="default-img" src="{{ asset('frontend/images/shop/product-1-1.jpg')}}" alt="">
                                    <img class="hover-img" src="{{ asset('frontend/images/shop/product-1-2.jpg')}}" alt="">
                                </a>
                            </div>
                            <div class="product-action-1">
                                <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist"><i class="fi-rs-heart"></i></a>
                                <a aria-label="Compare" class="action-btn" href="shop-compare"><i class="fi-rs-shuffle"></i></a>
                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                            </div>
                            <div class="product-badges product-badges-position product-badges-mrg">
                                <span class="hot">Hot</span>
                            </div>
                        </div>
                        <div class="product-content-wrap">
                            <div class="product-category">
                                <a href="shop-grid-right">Snack</a>
                            </div>
                            <h2><a href="shop-product-right">Seeds of Change Organic Quinoe</a></h2>
                            <div class="product-rate-cover">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width: 90%"></div>
                                </div>
                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                            </div>
                            <div>
                                <span class="font-small text-muted">By <a href="vendor-details-1">NestFood</a></span>
                            </div>
                            <div class="product-card-bottom">
                                <div class="product-price">
                                    <span>$28.85</span>
                                    <span class="old-price">$32.8</span>
                                </div>
                                <div class="add-cart">
                                    <a class="add" href="shop-cart"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end product card-->
                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                    <div class="product-cart-wrap mb-30">
                        <div class="product-img-action-wrap">
                            <div class="product-img product-img-zoom">
                                <a href="shop-product-right">
                                    <img class="default-img" src="{{ asset('frontend/images/shop/product-2-1.jpg')}}" alt="">
                                    <img class="hover-img" src="{{ asset('frontend/images/shop/product-2-2.jpg')}}" alt="">
                                </a>
                            </div>
                            <div class="product-action-1">
                                <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist"><i class="fi-rs-heart"></i></a>
                                <a aria-label="Compare" class="action-btn" href="shop-compare"><i class="fi-rs-shuffle"></i></a>
                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                            </div>
                            <div class="product-badges product-badges-position product-badges-mrg">
                                <span class="sale">Sale</span>
                            </div>
                        </div>
                        <div class="product-content-wrap">
                            <div class="product-category">
                                <a href="shop-grid-right">Hodo Foods</a>
                            </div>
                            <h2><a href="shop-product-right">All Natural Italian-Style Chicken Meatballs</a></h2>
                            <div class="product-rate-cover">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width: 80%"></div>
                                </div>
                                <span class="font-small ml-5 text-muted"> (3.5)</span>
                            </div>
                            <div>
                                <span class="font-small text-muted">By <a href="vendor-details-1">Stouffer</a></span>
                            </div>
                            <div class="product-card-bottom">
                                <div class="product-price">
                                    <span>$52.85</span>
                                    <span class="old-price">$55.8</span>
                                </div>
                                <div class="add-cart">
                                    <a class="add" href="shop-cart"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end product card-->
                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                    <div class="product-cart-wrap mb-30">
                        <div class="product-img-action-wrap">
                            <div class="product-img product-img-zoom">
                                <a href="shop-product-right">
                                    <img class="default-img" src="{{ asset('frontend/images/shop/product-3-1.jpg')}}" alt="">
                                    <img class="hover-img" src="{{ asset('frontend/images/shop/product-3-2.jpg')}}" alt="">
                                </a>
                            </div>
                            <div class="product-action-1">
                                <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist"><i class="fi-rs-heart"></i></a>
                                <a aria-label="Compare" class="action-btn" href="shop-compare"><i class="fi-rs-shuffle"></i></a>
                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                            </div>
                            <div class="product-badges product-badges-position product-badges-mrg">
                                <span class="new">New</span>
                            </div>
                        </div>
                        <div class="product-content-wrap">
                            <div class="product-category">
                                <a href="shop-grid-right">Snack</a>
                            </div>
                            <h2><a href="shop-product-right">Angie’s Boomchickapop Sweet &amp; Salty</a></h2>
                            <div class="product-rate-cover">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width: 85%"></div>
                                </div>
                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                            </div>
                            <div>
                                <span class="font-small text-muted">By <a href="vendor-details-1">StarKist</a></span>
                            </div>
                            <div class="product-card-bottom">
                                <div class="product-price">
                                    <span>$48.85</span>
                                    <span class="old-price">$52.8</span>
                                </div>
                                <div class="add-cart">
                                    <a class="add" href="shop-cart"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end product card-->
                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                    <div class="product-cart-wrap mb-30">
                        <div class="product-img-action-wrap">
                            <div class="product-img product-img-zoom">
                                <a href="shop-product-right">
                                    <img class="default-img" src="{{ asset('frontend/images/shop/product-4-1.jpg')}}" alt="">
                                    <img class="hover-img" src="{{ asset('frontend/images/shop/product-4-2.jpg')}}" alt="">
                                </a>
                            </div>
                            <div class="product-action-1">
                                <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist"><i class="fi-rs-heart"></i></a>
                                <a aria-label="Compare" class="action-btn" href="shop-compare"><i class="fi-rs-shuffle"></i></a>
                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                            </div>
                        </div>
                        <div class="product-content-wrap">
                            <div class="product-category">
                                <a href="shop-grid-right">Vegetables</a>
                            </div>
                            <h2><a href="shop-product-right">Foster Farms Takeout Crispy Classic</a></h2>
                            <div class="product-rate-cover">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width: 90%"></div>
                                </div>
                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                            </div>
                            <div>
                                <span class="font-small text-muted">By <a href="vendor-details-1">NestFood</a></span>
                            </div>
                            <div class="product-card-bottom">
                                <div class="product-price">
                                    <span>$17.85</span>
                                    <span class="old-price">$19.8</span>
                                </div>
                                <div class="add-cart">
                                    <a class="add" href="shop-cart"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end product card-->
                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                    <div class="product-cart-wrap mb-30">
                        <div class="product-img-action-wrap">
                            <div class="product-img product-img-zoom">
                                <a href="shop-product-right">
                                    <img class="default-img" src="{{ asset('frontend/images/shop/product-5-1.jpg')}}" alt="">
                                    <img class="hover-img" src="{{ asset('frontend/images/shop/product-5-2.jpg')}}" alt="">
                                </a>
                            </div>
                            <div class="product-action-1">
                                <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist"><i class="fi-rs-heart"></i></a>
                                <a aria-label="Compare" class="action-btn" href="shop-compare"><i class="fi-rs-shuffle"></i></a>
                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                            </div>
                            <div class="product-badges product-badges-position product-badges-mrg">
                                <span class="best">-14%</span>
                            </div>
                        </div>
                        <div class="product-content-wrap">
                            <div class="product-category">
                                <a href="shop-grid-right">Pet Foods</a>
                            </div>
                            <h2><a href="shop-product-right">Blue Diamond Almonds Lightly</a></h2>
                            <div class="product-rate-cover">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width: 90%"></div>
                                </div>
                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                            </div>
                            <div>
                                <span class="font-small text-muted">By <a href="vendor-details-1">NestFood</a></span>
                            </div>
                            <div class="product-card-bottom">
                                <div class="product-price">
                                    <span>$23.85</span>
                                    <span class="old-price">$25.8</span>
                                </div>
                                <div class="add-cart">
                                    <a class="add" href="shop-cart"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end product card-->
                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                    <div class="product-cart-wrap mb-30">
                        <div class="product-img-action-wrap">
                            <div class="product-img product-img-zoom">
                                <a href="shop-product-right">
                                    <img class="default-img" src="{{ asset('frontend/images/shop/product-6-1.jpg')}}" alt="">
                                    <img class="hover-img" src="{{ asset('frontend/images/shop/product-6-2.jpg')}}" alt="">
                                </a>
                            </div>
                            <div class="product-action-1">
                                <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist"><i class="fi-rs-heart"></i></a>
                                <a aria-label="Compare" class="action-btn" href="shop-compare"><i class="fi-rs-shuffle"></i></a>
                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                            </div>
                        </div>
                        <div class="product-content-wrap">
                            <div class="product-category">
                                <a href="shop-grid-right">Hodo Foods</a>
                            </div>
                            <h2><a href="shop-product-right">Chobani Complete Vanilla Greek</a></h2>
                            <div class="product-rate-cover">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width: 90%"></div>
                                </div>
                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                            </div>
                            <div>
                                <span class="font-small text-muted">By <a href="vendor-details-1">NestFood</a></span>
                            </div>
                            <div class="product-card-bottom">
                                <div class="product-price">
                                    <span>$54.85</span>
                                    <span class="old-price">$55.8</span>
                                </div>
                                <div class="add-cart">
                                    <a class="add" href="shop-cart"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end product card-->
                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                    <div class="product-cart-wrap mb-30">
                        <div class="product-img-action-wrap">
                            <div class="product-img product-img-zoom">
                                <a href="shop-product-right">
                                    <img class="default-img" src="{{ asset('frontend/images/shop/product-7-1.jpg')}}" alt="">
                                    <img class="hover-img" src="{{ asset('frontend/images/shop/product-7-2.jpg')}}" alt="">
                                </a>
                            </div>
                            <div class="product-action-1">
                                <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist"><i class="fi-rs-heart"></i></a>
                                <a aria-label="Compare" class="action-btn" href="shop-compare"><i class="fi-rs-shuffle"></i></a>
                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                            </div>
                        </div>
                        <div class="product-content-wrap">
                            <div class="product-category">
                                <a href="shop-grid-right">Meats</a>
                            </div>
                            <h2><a href="shop-product-right">Canada Dry Ginger Ale – 2 L Bottle</a></h2>
                            <div class="product-rate-cover">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width: 90%"></div>
                                </div>
                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                            </div>
                            <div>
                                <span class="font-small text-muted">By <a href="vendor-details-1">NestFood</a></span>
                            </div>
                            <div class="product-card-bottom">
                                <div class="product-price">
                                    <span>$32.85</span>
                                    <span class="old-price">$33.8</span>
                                </div>
                                <div class="add-cart">
                                    <a class="add" href="shop-cart"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end product card-->
                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                    <div class="product-cart-wrap mb-30">
                        <div class="product-img-action-wrap">
                            <div class="product-img product-img-zoom">
                                <a href="shop-product-right">
                                    <img class="default-img" src="{{ asset('frontend/images/shop/product-8-1.jpg')}}" alt="">
                                    <img class="hover-img" src="{{ asset('frontend/images/shop/product-8-2.jpg')}}" alt="">
                                </a>
                            </div>
                            <div class="product-action-1">
                                <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist"><i class="fi-rs-heart"></i></a>
                                <a aria-label="Compare" class="action-btn" href="shop-compare"><i class="fi-rs-shuffle"></i></a>
                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                            </div>
                            <div class="product-badges product-badges-position product-badges-mrg">
                                <span class="sale">Sale</span>
                            </div>
                        </div>
                        <div class="product-content-wrap">
                            <div class="product-category">
                                <a href="shop-grid-right">Snack</a>
                            </div>
                            <h2><a href="shop-product-right">Encore Seafoods Stuffed Alaskan</a></h2>
                            <div class="product-rate-cover">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width: 90%"></div>
                                </div>
                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                            </div>
                            <div>
                                <span class="font-small text-muted">By <a href="vendor-details-1">NestFood</a></span>
                            </div>
                            <div class="product-card-bottom">
                                <div class="product-price">
                                    <span>$35.85</span>
                                    <span class="old-price">$37.8</span>
                                </div>
                                <div class="add-cart">
                                    <a class="add" href="shop-cart"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end product card-->
                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                    <div class="product-cart-wrap mb-30">
                        <div class="product-img-action-wrap">
                            <div class="product-img product-img-zoom">
                                <a href="shop-product-right">
                                    <img class="default-img" src="{{ asset('frontend/images/shop/product-9-1.jpg')}}" alt="">
                                    <img class="hover-img" src="{{ asset('frontend/images/shop/product-9-2.jpg')}}" alt="">
                                </a>
                            </div>
                            <div class="product-action-1">
                                <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist"><i class="fi-rs-heart"></i></a>
                                <a aria-label="Compare" class="action-btn" href="shop-compare"><i class="fi-rs-shuffle"></i></a>
                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                            </div>
                            <div class="product-badges product-badges-position product-badges-mrg">
                                <span class="hot">Hot</span>
                            </div>
                        </div>
                        <div class="product-content-wrap">
                            <div class="product-category">
                                <a href="shop-grid-right">Coffes</a>
                            </div>
                            <h2><a href="shop-product-right">Gorton’s Beer Battered Fish Fillets</a></h2>
                            <div class="product-rate-cover">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width: 90%"></div>
                                </div>
                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                            </div>
                            <div>
                                <span class="font-small text-muted">By <a href="vendor-details-1">Old El Paso</a></span>
                            </div>
                            <div class="product-card-bottom">
                                <div class="product-price">
                                    <span>$23.85</span>
                                    <span class="old-price">$25.8</span>
                                </div>
                                <div class="add-cart">
                                    <a class="add" href="shop-cart"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end product card-->
                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 d-none d-xl-block">
                    <div class="product-cart-wrap">
                        <div class="product-img-action-wrap">
                            <div class="product-img product-img-zoom">
                                <a href="shop-product-right">
                                    <img class="default-img" src="{{ asset('frontend/images/shop/product-10-1.jpg')}}" alt="">
                                    <img class="hover-img" src="{{ asset('frontend/images/shop/product-10-2.jpg')}}" alt="">
                                </a>
                            </div>
                            <div class="product-action-1">
                                <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist"><i class="fi-rs-heart"></i></a>
                                <a aria-label="Compare" class="action-btn" href="shop-compare"><i class="fi-rs-shuffle"></i></a>
                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                            </div>
                        </div>
                        <div class="product-content-wrap">
                            <div class="product-category">
                                <a href="shop-grid-right">Cream</a>
                            </div>
                            <h2><a href="shop-product-right">Haagen-Dazs Caramel Cone Ice Cream</a></h2>
                            <div class="product-rate-cover">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width: 50%"></div>
                                </div>
                                <span class="font-small ml-5 text-muted"> (2.0)</span>
                            </div>
                            <div>
                                <span class="font-small text-muted">By <a href="vendor-details-1">Tyson</a></span>
                            </div>
                            <div class="product-card-bottom">
                                <div class="product-price">
                                    <span>$22.85</span>
                                    <span class="old-price">$24.8</span>
                                </div>
                                <div class="add-cart">
                                    <a class="add" href="shop-cart"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end product card-->
            </div>
            <!--product grid-->
            <div class="pagination-area mt-20 mb-20">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-start">
                        <li class="page-item">
                            <a class="page-link" href="#"><i class="fi-rs-arrow-small-left"></i></a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item active"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link dot" href="#">...</a></li>
                        <li class="page-item"><a class="page-link" href="#">6</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#"><i class="fi-rs-arrow-small-right"></i></a>
                        </li>
                    </ul>
                </nav>
            </div>
            <section class="section-padding pb-5">
                <div class="section-title">
                    <h3 class="">Deals Of The Day</h3>
                    <a class="show-all" href="shop-grid-right">
                        All Deals
                        <i class="fi-rs-angle-right"></i>
                    </a>
                </div>
                <div class="row">
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="product-cart-wrap style-2">
                            <div class="product-img-action-wrap">
                                <div class="product-img">
                                    <a href="shop-product-right">
                                        <img src="{{ asset('frontend/images/banner/banner-5.png')}}" alt="">
                                    </a>
                                </div>
                            </div>
                            <div class="product-content-wrap">
                                <div class="deals-countdown-wrap">
                                    <div class="deals-countdown" data-countdown="2025/03/25 00:00:00"><span class="countdown-section"><span class="countdown-amount hover-up">37</span><span class="countdown-period"> days </span></span><span class="countdown-section"><span class="countdown-amount hover-up">01</span><span class="countdown-period"> hours </span></span><span class="countdown-section"><span class="countdown-amount hover-up">43</span><span class="countdown-period"> mins </span></span><span class="countdown-section"><span class="countdown-amount hover-up">37</span><span class="countdown-period"> sec </span></span></div>
                                </div>
                                <div class="deals-content">
                                    <h2><a href="shop-product-right">Seeds of Change Organic Quinoa, Brown</a></h2>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                    <div>
                                        <span class="font-small text-muted">By <a href="vendor-details-1">NestFood</a></span>
                                    </div>
                                    <div class="product-card-bottom">
                                        <div class="product-price">
                                            <span>$32.85</span>
                                            <span class="old-price">$33.8</span>
                                        </div>
                                        <div class="add-cart">
                                            <a class="add" href="shop-cart"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="product-cart-wrap style-2">
                            <div class="product-img-action-wrap">
                                <div class="product-img">
                                    <a href="shop-product-right">
                                        <img src="{{ asset('frontend/images/banner/banner-6.png')}}" alt="">
                                    </a>
                                </div>
                            </div>
                            <div class="product-content-wrap">
                                <div class="deals-countdown-wrap">
                                    <div class="deals-countdown" data-countdown="2026/04/25 00:00:00"><span class="countdown-section"><span class="countdown-amount hover-up">433</span><span class="countdown-period"> days </span></span><span class="countdown-section"><span class="countdown-amount hover-up">01</span><span class="countdown-period"> hours </span></span><span class="countdown-section"><span class="countdown-amount hover-up">43</span><span class="countdown-period"> mins </span></span><span class="countdown-section"><span class="countdown-amount hover-up">37</span><span class="countdown-period"> sec </span></span></div>
                                </div>
                                <div class="deals-content">
                                    <h2><a href="shop-product-right">Perdue Simply Smart Organics Gluten</a></h2>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                    <div>
                                        <span class="font-small text-muted">By <a href="vendor-details-1">Old El Paso</a></span>
                                    </div>
                                    <div class="product-card-bottom">
                                        <div class="product-price">
                                            <span>$24.85</span>
                                            <span class="old-price">$26.8</span>
                                        </div>
                                        <div class="add-cart">
                                            <a class="add" href="shop-cart"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 d-none d-lg-block">
                        <div class="product-cart-wrap style-2">
                            <div class="product-img-action-wrap">
                                <div class="product-img">
                                    <a href="shop-product-right">
                                        <img src="{{ asset('frontend/images/banner/banner-7.png')}}" alt="">
                                    </a>
                                </div>
                            </div>
                            <div class="product-content-wrap">
                                <div class="deals-countdown-wrap">
                                    <div class="deals-countdown" data-countdown="2027/03/25 00:00:00"><span class="countdown-section"><span class="countdown-amount hover-up">767</span><span class="countdown-period"> days </span></span><span class="countdown-section"><span class="countdown-amount hover-up">01</span><span class="countdown-period"> hours </span></span><span class="countdown-section"><span class="countdown-amount hover-up">43</span><span class="countdown-period"> mins </span></span><span class="countdown-section"><span class="countdown-amount hover-up">37</span><span class="countdown-period"> sec </span></span></div>
                                </div>
                                <div class="deals-content">
                                    <h2><a href="shop-product-right">Signature Wood-Fired Mushroom</a></h2>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 80%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (3.0)</span>
                                    </div>
                                    <div>
                                        <span class="font-small text-muted">By <a href="vendor-details-1">Progresso</a></span>
                                    </div>
                                    <div class="product-card-bottom">
                                        <div class="product-price">
                                            <span>$12.85</span>
                                            <span class="old-price">$13.8</span>
                                        </div>
                                        <div class="add-cart">
                                            <a class="add" href="shop-cart"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 d-none d-xl-block">
                        <div class="product-cart-wrap style-2">
                            <div class="product-img-action-wrap">
                                <div class="product-img">
                                    <a href="shop-product-right">
                                        <img src="{{ asset('frontend/images/banner/banner-8.png')}}" alt="">
                                    </a>
                                </div>
                            </div>
                            <div class="product-content-wrap">
                                <div class="deals-countdown-wrap">
                                    <div class="deals-countdown" data-countdown="2025/02/25 00:00:00"><span class="countdown-section"><span class="countdown-amount hover-up">09</span><span class="countdown-period"> days </span></span><span class="countdown-section"><span class="countdown-amount hover-up">01</span><span class="countdown-period"> hours </span></span><span class="countdown-section"><span class="countdown-amount hover-up">43</span><span class="countdown-period"> mins </span></span><span class="countdown-section"><span class="countdown-amount hover-up">37</span><span class="countdown-period"> sec </span></span></div>
                                </div>
                                <div class="deals-content">
                                    <h2><a href="shop-product-right">Simply Lemonade with Raspberry Juice</a></h2>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 80%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (3.0)</span>
                                    </div>
                                    <div>
                                        <span class="font-small text-muted">By <a href="vendor-details-1">Yoplait</a></span>
                                    </div>
                                    <div class="product-card-bottom">
                                        <div class="product-price">
                                            <span>$15.85</span>
                                            <span class="old-price">$16.8</span>
                                        </div>
                                        <div class="add-cart">
                                            <a class="add" href="shop-cart"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--End Deals-->
        </div>
        <div class="col-lg-1-5 primary-sidebar sticky-sidebar" style="position: relative; overflow: visible; box-sizing: border-box; min-height: 1px;">
            
            <!-- Fillter By Price -->
            
            <!-- Product sidebar Widget -->
            
            
        <div class="theiaStickySidebar" style="padding-top: 0px; padding-bottom: 1px; position: static; transform: none; top: 0px; left: 12.0125px;"><div class="sidebar-widget widget-category-2 mb-30">
                <h5 class="section-title style-1 mb-30">Category</h5>
                <ul>
                    <li>
                        <a href="shop-grid-right"> <img src="{{ asset('frontend/images/theme/icons/category-1.svg')}}" alt="">Milks &amp; Dairies</a><span class="count">30</span>
                    </li>
                    <li>
                        <a href="shop-grid-right"> <img src="{{ asset('frontend/images/theme/icons/category-2.svg')}}" alt="">Clothing</a><span class="count">35</span>
                    </li>
                    <li>
                        <a href="shop-grid-right"> <img src="{{ asset('frontend/images/theme/icons/category-3.svg')}}" alt="">Pet Foods </a><span class="count">42</span>
                    </li>
                    <li>
                        <a href="shop-grid-right"> <img src="{{ asset('frontend/images/theme/icons/category-4.svg')}}" alt="">Baking material</a><span class="count">68</span>
                    </li>
                    <li>
                        <a href="shop-grid-right"> <img src="{{ asset('frontend/images/theme/icons/category-5.svg')}}" alt="">Fresh Fruit</a><span class="count">87</span>
                    </li>
                </ul>
            </div><div class="sidebar-widget price_range range mb-30">
                <h5 class="section-title style-1 mb-30">Fill by price</h5>
                <div class="price-filter">
                    <div class="price-filter-inner">
                        <div id="slider-range" class="mb-20 noUi-target noUi-ltr noUi-horizontal noUi-background"><div class="noUi-base"><div class="noUi-origin noUi-connect" style="left: 25%;"><div class="noUi-handle noUi-handle-lower"></div></div><div class="noUi-origin noUi-background" style="left: 50%;"><div class="noUi-handle noUi-handle-upper"></div></div></div></div>
                        <div class="d-flex justify-content-between">
                            <div class="caption">From: <strong id="slider-range-value1" class="text-brand">$500</strong></div>
                            <div class="caption">To: <strong id="slider-range-value2" class="text-brand">$1,000</strong></div>
                        </div>
                    </div>
                </div>
            </div><div class="sidebar-widget product-sidebar mb-30 p-30 bg-grey border-radius-10">
                <h5 class="section-title style-1 mb-30">New products</h5>
                <div class="single-post clearfix">
                    <div class="image">
                        <img src="{{ asset('frontend/images/shop/thumbnail-3.jpg')}}" alt="#">
                    </div>
                    <div class="content pt-10">
                        <h5><a href="shop-product-detail.html">Chen Cardigan</a></h5>
                        <p class="price mb-0 mt-5">$99.50</p>
                        <div class="product-rate">
                            <div class="product-rating" style="width: 90%"></div>
                        </div>
                    </div>
                </div>
                <div class="single-post clearfix">
                    <div class="image">
                        <img src="{{ asset('frontend/images/shop/thumbnail-4.jpg')}}" alt="#">
                    </div>
                    <div class="content pt-10">
                        <h6><a href="shop-product-detail.html">Chen Sweater</a></h6>
                        <p class="price mb-0 mt-5">$89.50</p>
                        <div class="product-rate">
                            <div class="product-rating" style="width: 80%"></div>
                        </div>
                    </div>
                </div>
                <div class="single-post clearfix">
                    <div class="image">
                        <img src="{{ asset('frontend/images/shop/thumbnail-5.jpg')}}" alt="#">
                    </div>
                    <div class="content pt-10">
                        <h6><a href="shop-product-detail.html">Colorful Jacket</a></h6>
                        <p class="price mb-0 mt-5">$25</p>
                        <div class="product-rate">
                            <div class="product-rating" style="width: 60%"></div>
                        </div>
                    </div>
                </div>
            </div><div class="banner-img wow fadeIn mb-lg-0 animated d-lg-block d-none animated" style="visibility: visible;">
                <img src="{{ asset('frontend/images/banner/banner-11.png')}}" alt="">
                <div class="banner-text">
                    <span>Oganic</span>
                    <h4>
                        Save 17% <br>
                        on <span class="text-brand">Oganic</span><br>
                        Juice
                    </h4>
                </div>
            </div></div></div>
    </div>
</div>
@endsection