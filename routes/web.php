<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\HomeController;  
use App\Http\Controllers\Frontend\TeamsController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\ReviewsController;
use App\Http\Controllers\Frontend\CartController;


// Route::get('/', function () {
//     return view('index');
// });
Route::get('/',[HomeController::class, 'index'])->name('frontend.index');
Route::get('/about-us',[FrontendController::class, 'aboutPage'])->name('frontend.about');
Route::get('/blog',[FrontendController::class, 'blogPage'])->name('frontend.blog');
Route::get('/contact',[FrontendController::class, 'contactPage'])->name('frontend.contact');
Route::get('/seller',[FrontendController::class, 'sellerPage'])->name('frontend.seller');
Route::get('/product',[FrontendController::class, 'productPage'])->name('frontend.product');
Route::get('/provide/condition',[FrontendController::class, 'condition'])->name('frontend.condition' );
Route::get('/client',[FrontendController::class, 'client'])->name('frontend.client' );

Route::get('/product-detail',[FrontendController::class, 'productDetailPage'])->name('frontend.productDetail');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
//teams
Route::get('/team',[TeamsController::class, 'team'])->name('frontend.team');

//Blog
Route::get('/blog', [BlogController::class, 'getBlogPage'])->name('frontend.blog');
Route::get('/blog-category/{id}/{title}', [BlogController::class, 'getBlogCategoryPage'])->name('frontend.blog-category');
Route::get('/blogs/{id}/{title}', [BlogController::class, 'getArticlePage'])->name('frontend.article');
//Product
Route::get('/product/{id}/{title}', [ProductController::class, 'getProductPage'])->name('frontend.product');
Route::get('/getProductReviewsGrid', [ProductController::class, 'getProductReviewsGrid'])->name('frontend.getProductReviewsGrid');
Route::post('/submit-review', [ReviewsController::class, 'store'])->name('frontend.starstore');

//Add to cart
Route::get('/frontend/add_to_cart/{id}/{qty}', [CartController::class, 'AddToCart'])->name('frontend.add_to_cart');
Route::get('/frontend/view_cart', [CartController::class, 'ViewCart'])->name('frontend.view_cart');
Route::get('/frontend/remove_to_cart/{rowid}', [CartController::class, 'RemoveToCart'])->name('frontend.remove_to_cart');
Route::get('/cart', [CartController::class, 'getCart'])->name('frontend.cart');
Route::get('/frontend/viewcart_data', [CartController::class, 'getViewCartData'])->name('frontend.getViewCartData');

//Wishlist
Route::get('/frontend/add_to_wishlist/{id}', [CartController::class, 'addToWishlist'])->name('frontend.add_to_wishlist');
Route::get('/wishlist', [CartController::class, 'getWishlist'])->name('frontend.wishlist');
Route::get('/frontend/remove_to_wishlist/{rowid}', [CartController::class, 'RemoveToWishlist'])->name('frontend.remove_to_wishlist');
Route::get('/frontend/count_wishlist', [CartController::class, 'countWishlist'])->name('frontend.countWishlist');
//Checkout
Route::get('/checkout', [App\Http\Controllers\Frontend\CheckoutFrontController::class, 'LoadCheckout'])->name('frontend.checkout');
Route::post('/frontend/make_order', [App\Http\Controllers\Frontend\CheckoutFrontController::class, 'LoadMakeOrder'])->name('frontend.make_order');
Route::get('/thank', [App\Http\Controllers\Frontend\CheckoutFrontController::class, 'LoadThank'])->name('frontend.thank');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin-auth.php';
require __DIR__.'/seller-auth.php';

