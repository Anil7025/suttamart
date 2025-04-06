<?php

use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\admin\MenuController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\admin\TransactionController; 
use App\Http\Controllers\admin\TestimonialsController;
use App\Http\Controllers\admin\NewslettersController;
use App\Http\Controllers\admin\CustomerController;
use App\Http\Controllers\admin\SellerController;
use App\Http\Controllers\admin\MenuBuilderController;
use App\Http\Controllers\admin\PageController;
use App\Http\Controllers\admin\ContactController;
use App\Http\Controllers\admin\ProductsController;
use App\Http\Controllers\admin\InventoryController;
use App\Http\Controllers\admin\Pro_categoriesController;
use App\Http\Controllers\admin\Blog_categoriesController;
use App\Http\Controllers\admin\BlogController;
use App\Http\Controllers\admin\BrandsController;
use App\Http\Controllers\admin\ShopController;
use App\Http\Controllers\admin\ReviewsController;
use App\Http\Controllers\admin\ShippingController;
use App\Http\Controllers\admin\CollectionsController;
use App\Http\Controllers\admin\AttributesController;
use App\Http\Controllers\admin\LabelsController;
use App\Http\Controllers\admin\CouponsController;
use App\Http\Controllers\admin\HomeSliderController;
use App\Http\Controllers\admin\Offer_adsController;
use App\Http\Controllers\admin\SectionManageController;
use App\Http\Controllers\admin\ThemeOptionsController;
use App\Http\Controllers\admin\SocialMediasController;
use App\Http\Controllers\admin\SettingsController;
use App\Http\Controllers\admin\UploadController;
use App\Http\Controllers\admin\ComboController;
use App\Http\Controllers\admin\OrdersExportController;
use App\Http\Controllers\admin\TransactionsExportController; 
use App\Http\Controllers\admin\WithdrawalController;
use App\Http\Controllers\admin\SellerSettingsController;  
use App\Http\Controllers\admin\TaxesController;
use App\Http\Controllers\admin\TeamsController;
use App\Http\Controllers\admin\ConditionsController;
use App\Models\Shop;

Route::middleware('guest:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'getDashboardData'])->name('dashboard')->middleware(['verified']);
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy']) ->name('logout');
    Route::get('/notfound', [HomeController::class, 'notFoundPage'])->name('notfound');

    //Page
    Route::get('/page', [PageController::class, 'getAllPageData'])->name('page');
    Route::get('/getPagePaginationData', [PageController::class, 'getPagePaginationData'])->name('getPagePaginationData');
    Route::post('/getPageById', [PageController::class, 'getPageById'])->name('getPageById');
    Route::post('/deletePage', [PageController::class, 'deletePage'])->name('deletePage');
    Route::post('/bulkActionPage', [PageController::class, 'bulkActionPage'])->name('bulkActionPage');
    Route::post('/hasPageTitleSlug', [PageController::class, 'hasPageTitleSlug'])->name('hasPageTitleSlug');
    Route::post('/savePageData', [PageController::class, 'savePageData'])->name('savePageData');

    //Brands
    Route::get('/brands', [BrandsController::class, 'getBrandsPageLoad'])->name('brands');
    Route::get('/getBrandsTableData', [BrandsController::class, 'getBrandsTableData'])->name('getBrandsTableData');
    Route::post('/saveBrandsData', [BrandsController::class, 'saveBrandsData'])->name('saveBrandsData');
    Route::post('/getBrandsById', [BrandsController::class, 'getBrandsById'])->name('getBrandsById');
    Route::post('/deleteBrands', [BrandsController::class, 'deleteBrands'])->name('deleteBrands');
    Route::post('/bulkActionBrands', [BrandsController::class, 'bulkActionBrands'])->name('bulkActionBrands');
    //Testimonials
    Route::get('/testimonials', [TestimonialsController::class, 'getTestimonialsPageLoad'])->name('testimonials');
    Route::get('/getTestimonialsTableData', [TestimonialsController::class, 'getTestimonialsTableData'])->name('getTestimonialsTableData');
    Route::post('/saveTestimonialsData', [TestimonialsController::class, 'saveTestimonialsData'])->name('saveTestimonialsData');
    Route::post('/getTestimonialsById', [TestimonialsController::class, 'getTestimonialsById'])->name('getTestimonialsById');
    Route::post('/deleteTestimonials', [TestimonialsController::class, 'deleteTestimonials'])->name('deleteTestimonials');
    Route::post('/bulkActionTestimonials', [TestimonialsController::class, 'bulkActionTestimonials'])->name('bulkActionTestimonials');
    //Product Categories
    Route::get('/product-categories', [Pro_categoriesController::class, 'getProductCategoriesPageLoad'])->name('product-categories');
    Route::get('/getProductCategoriesTableData', [Pro_categoriesController::class, 'getProductCategoriesTableData'])->name('getProductCategoriesTableData');
    Route::post('/saveProductCategoriesData', [Pro_categoriesController::class, 'saveProductCategoriesData'])->name('saveProductCategoriesData');
    Route::post('/getProductCategoriesById', [Pro_categoriesController::class, 'getProductCategoriesById'])->name('getProductCategoriesById');
    Route::post('/deleteProductCategories', [Pro_categoriesController::class, 'deleteProductCategories'])->name('deleteProductCategories');
    Route::post('/bulkActionProductCategories', [Pro_categoriesController::class, 'bulkActionProductCategories'])->name('bulkActionProductCategories');
    Route::post('/hasProductCategorySlug', [Pro_categoriesController::class, 'hasProductCategorySlug'])->name('hasProductCategorySlug');
    //Products
    Route::get('/products', [ProductsController::class, 'getProductsPageLoad'])->name('products');
    Route::get('/getProductsTableData', [ProductsController::class, 'getProductsTableData'])->name('getProductsTableData');
    Route::post('/saveProductsData', [ProductsController::class, 'saveProductsData'])->name('saveProductsData');
    Route::post('/deleteProducts', [ProductsController::class, 'deleteProducts'])->name('deleteProducts');
    Route::post('/bulkActionProducts', [ProductsController::class, 'bulkActionProducts'])->name('bulkActionProducts');
    Route::post('/hasProductSlug', [ProductsController::class, 'hasProductSlug'])->name('hasProductSlug');
    //Update
    Route::get('/product/{id}', [ProductsController::class, 'getProductPageData'])->name('product');
    Route::post('/updateProductsData', [ProductsController::class, 'updateProductsData'])->name('updateProductsData');
    //Shops
    Route::get('/shops', [ShopController::class, 'getShopsPageLoad'])->name('shops');
    Route::get('/getShopsTableData', [ShopController::class, 'getShopsTableData'])->name('getShopsTableData');
    Route::post('/saveShopsData', [ShopController::class, 'saveShopsData'])->name('saveShopsData');
    Route::post('/getShopsById', [ShopController::class, 'getShopsById'])->name('getShopsById');
    Route::post('/deleteShops', [ShopController::class, 'deleteShops'])->name('deleteShops');
    Route::post('/bulkActionShops', [ShopController::class, 'bulkActionShops'])->name('bulkActionShops');  
    //Product Images
    Route::get('/product-images/{id}', [ProductsController::class, 'getProductImagesPageData'])->name('product-images');
    Route::get('/getProductImagesTableData', [ProductsController::class, 'getProductImagesTableData'])->name('getProductImagesTableData');
    Route::post('/saveProductImagesData', [ProductsController::class, 'saveProductImagesData'])->name('saveProductImagesData');
    Route::post('/deleteProductImages', [ProductsController::class, 'deleteProductImages'])->name('deleteProductImages');
    
    //Tax
	Route::get('/tax', [TaxesController::class, 'getTaxPageLoad'])->name('tax');
	Route::post('/saveTaxData', [TaxesController::class, 'saveTaxData'])->name('saveTaxData');
    //Contact
    Route::get('/contact', [ContactController::class, 'getContactData'])->name('contact');
    Route::get('/getContactPaginationData', [ContactController::class, 'getContactPaginationData'])->name('getContactPaginationData');
    Route::post('/getContactById', [ContactController::class, 'getContactById'])->name('getContactById');
    Route::post('/deleteContact', [ContactController::class, 'deleteContact'])->name('deleteContact');
    Route::post('/bulkActionContact', [ContactController::class, 'bulkActionContact'])->name('bulkActionContact');
    Route::post('/saveContactData', [ContactController::class, 'saveContactData'])->name('saveContactData');
    //Manage Stock
    Route::get('/manage-stock', [InventoryController::class, 'getManageStockPageLoad'])->name('manage-stock');
    Route::get('/getManageStockTableData', [InventoryController::class, 'getManageStockTableData'])->name('getManageStockTableData');
    Route::post('/getProductById', [InventoryController::class, 'getProductById'])->name('getProductById');
    Route::post('/saveManageStockData', [InventoryController::class, 'saveManageStockData'])->name('saveManageStockData');

    //Price
    Route::get('/price/{id}', [ProductsController::class, 'getPricePageData'])->name('price');
    Route::post('/savePriceData', [ProductsController::class, 'savePriceData'])->name('savePriceData');
    
    //Inventory
    Route::get('/inventory/{id}', [ProductsController::class, 'getInventoryPageData'])->name('inventory');
    Route::post('/saveInventoryData', [ProductsController::class, 'saveInventoryData'])->name('saveInventoryData');
    //Orders
    Route::get('/orders', [OrdersController::class, 'getOrdersPageLoad'])->name('orders');
    Route::get('/getOrdersTableData', [OrdersController::class, 'getOrdersTableData'])->name('getOrdersTableData');
    Route::post('/bulkActionOrders', [OrdersController::class, 'bulkActionOrders'])->name('bulkActionOrders');
    Route::get('/order/{id}', [OrdersController::class, 'getOrderData'])->name('order');
    Route::post('/updateOrderStatus', [OrdersController::class, 'updateOrderStatus'])->name('updateOrderStatus');
    Route::get('/getPaymentOrderStatusData', [OrdersController::class, 'getPaymentOrderStatusData'])->name('getPaymentOrderStatusData');
    Route::post('/deleteOrder', [OrdersController::class, 'deleteOrder'])->name('deleteOrder');
     //Slider
     Route::get('/slider', [HomeSliderController::class, 'getSliderPageLoad'])->name('slider');
     Route::get('/getSliderTableData', [HomeSliderController::class, 'getSliderTableData'])->name('getSliderTableData');
     Route::post('/saveSliderData', [HomeSliderController::class, 'saveSliderData'])->name('saveSliderData');
     Route::post('/getSliderById', [HomeSliderController::class, 'getSliderById'])->name('getSliderById');
     Route::post('/deleteSlider', [HomeSliderController::class, 'deleteSlider'])->name('deleteSlider');
     Route::post('/bulkActionSlider', [HomeSliderController::class, 'bulkActionSlider'])->name('bulkActionSlider');
     //Offer Ads
     Route::get('/offer-ads', [Offer_adsController::class, 'getOfferAdsPageLoad'])->name('offer-ads');
     Route::get('/getOfferAdsTableData', [Offer_adsController::class, 'getOfferAdsTableData'])->name('getOfferAdsTableData');
     Route::post('/saveOfferAdsData', [Offer_adsController::class, 'saveOfferAdsData'])->name('saveOfferAdsData');
     Route::post('/getOfferAdsById', [Offer_adsController::class, 'getOfferAdsById'])->name('getOfferAdsById');
     Route::post('/deleteOfferAds', [Offer_adsController::class, 'deleteOfferAds'])->name('deleteOfferAds');
     Route::post('/bulkActionOfferAds', [Offer_adsController::class, 'bulkActionOfferAds'])->name('bulkActionOfferAds');
     //Teams
     Route::get('/teams', [TeamsController::class, 'getTeamsPageLoad'])->name('teams');
     Route::get('/getTeamsTableData', [TeamsController::class, 'getTeamsTableData'])->name('getTeamsTableData');
     Route::post('/saveTeamsData', [TeamsController::class, 'saveTeamsData'])->name('saveTeamsData');
     Route::post('/getTeamsById', [TeamsController::class, 'getTeamsById'])->name('getTeamsById');
     Route::post('/deleteTeams', [TeamsController::class, 'deleteTeams'])->name('deleteTeams');
     Route::post('/hasTeamSlug', [TeamsController::class, 'hasTeamSlug'])->name('hasTeamSlug');
     Route::post('/bulkActionTeams', [TeamsController::class, 'bulkActionTeams'])->name('bulkActionTeams');
     //Conditions
     Route::get('/conditions', [ConditionsController::class, 'getConditionsPageLoad'])->name('conditions');
     Route::get('/getConditionsTableData', [ConditionsController::class, 'getConditionsTableData'])->name('getConditionsTableData');
     Route::post('/saveConditionsData', [ConditionsController::class, 'saveConditionsData'])->name('saveConditionsData');
     Route::post('/getConditionsById', [ConditionsController::class, 'getConditionsById'])->name('getConditionsById');
     Route::post('/deleteConditions', [ConditionsController::class, 'deleteConditions'])->name('deleteConditions');
     Route::post('/bulkActionConditions', [ConditionsController::class, 'bulkActionConditions'])->name('bulkActionConditions');







    
    
    //Transactions
    Route::get('/transactions', [TransactionController::class, 'getTransactionsPageLoad'])->name('transactions');
    Route::get('/getTransactionsTableData', [TransactionController::class, 'getTransactionsTableData'])->name('getTransactionsTableData');

    //Newsletters
    Route::get('/subscribe-settings', [NewslettersController::class, 'getSubscribeSettings'])->name('subscribe-settings');
    Route::post('/SubscribePopupUpdate', [NewslettersController::class, 'SubscribePopupUpdate'])->name('SubscribePopupUpdate');
    Route::get('/mailchimp-settings', [NewslettersController::class, 'getMailChimpSettings'])->name('mailchimp-settings');
    Route::post('/MailChimpSettingsUpdate', [NewslettersController::class, 'MailChimpSettingsUpdate'])->name('MailChimpSettingsUpdate');
    Route::get('/subscribers', [NewslettersController::class, 'getSubscribers'])->name('subscribers');
    Route::get('/getSubscriberTableData', [NewslettersController::class, 'getSubscriberTableData'])->name('getSubscriberTableData');
    Route::post('/saveSubscriberData', [NewslettersController::class, 'saveSubscriberData'])->name('saveSubscriberData');
    Route::post('/getSubscriberById', [NewslettersController::class, 'getSubscriberById'])->name('getSubscriberById');
    Route::post('/deleteSubscriber', [NewslettersController::class, 'deleteSubscriber'])->name('deleteSubscriber');
        
   
    //Customers Page
    Route::get('/customers', [CustomerController::class, 'getCustomersPageLoad'])->name('customers');
    Route::get('/getCustomersTableData', [CustomerController::class, 'getCustomersTableData'])->name('getCustomersTableData');
    Route::post('/saveCustomersData', [CustomerController::class, 'saveCustomersData'])->name('saveCustomersData');
    Route::post('/getCustomerById', [CustomerController::class, 'getCustomerById'])->name('getCustomerById');
    Route::post('/deleteCustomer', [CustomerController::class, 'deleteCustomer'])->name('deleteCustomer');
    Route::post('/bulkActionCustomers', [CustomerController::class, 'bulkActionCustomers'])->name('bulkActionCustomers');

    //Sellers Page
    Route::get('/sellers', [SellerController::class, 'getSellersPageLoad'])->name('sellers');
    Route::get('/getSellersTableData', [SellerController::class, 'getSellersTableData'])->name('getSellersTableData');
    Route::post('/saveSellersData', [SellerController::class, 'saveSellersData'])->name('saveSellersData');
    Route::post('/getSellerById', [SellerController::class, 'getSellerById'])->name('getSellerById');
    Route::post('/deleteSeller', [SellerController::class, 'deleteSeller'])->name('deleteSeller');
    Route::post('/bulkActionSellers', [SellerController::class, 'bulkActionSellers'])->name('bulkActionSellers');
    Route::post('/saveBankInformationData', [SellerController::class, 'saveBankInformationData'])->name('saveBankInformationData');
    
    //Users Page
    Route::get('/users', [UserController::class, 'getUsersPageLoad'])->name('users');
    Route::get('/getUsersTableData', [UserController::class, 'getUsersTableData'])->name('getUsersTableData');
    Route::post('/saveUsersData', [UserController::class, 'saveUsersData'])->name('saveUsersData');
    Route::post('/getUserById', [UserController::class, 'getUserById'])->name('getUserById');
    Route::post('/deleteUser', [UserController::class, 'deleteUser'])->name('deleteUser');
    Route::post('/bulkActionUsers', [UserController::class, 'bulkActionUsers'])->name('bulkActionUsers');

    //Profile Page
    Route::get('/profile', [UserController::class, 'getProfilePageLoad'])->name('profile');
    Route::post('/profileUpdate', [UserController::class, 'profileUpdate'])->name('profileUpdate');

    //Menu Page
    Route::get('/menu', [MenuController::class, 'getMenuPageLoad'])->name('menu');
    Route::get('/getMenuTableData', [MenuController::class, 'getMenuTableData'])->name('getMenuTableData');
    Route::post('/saveMenuData', [MenuController::class, 'saveMenuData'])->name('saveMenuData');
    Route::post('/getMenuById', [MenuController::class, 'getMenuById'])->name('getMenuById');
    Route::post('/deleteMenu', [MenuController::class, 'deleteMenu'])->name('deleteMenu');
    Route::post('/bulkActionMenu', [MenuController::class, 'bulkActionMenu'])->name('bulkActionMenu');

    //Menu Builder Page
    Route::get('/menu-builder/{id}', [MenuBuilderController::class, 'getMenuBuilderPageLoad'])->name('menu-builder');
    Route::get('/getPageMenuBuilderData', [MenuBuilderController::class, 'getPageMenuBuilderData'])->name('getPageMenuBuilderData');
    Route::get('/getBrandMenuBuilderData', [MenuBuilderController::class, 'getBrandMenuBuilderData'])->name('getBrandMenuBuilderData');
    Route::get('/getProductMenuBuilderData', [MenuBuilderController::class, 'getProductMenuBuilderData'])->name('getProductMenuBuilderData');
    Route::get('/getProductCategoryMenuBuilderData', [MenuBuilderController::class, 'getProductCategoryMenuBuilderData'])->name('getProductCategoryMenuBuilderData');
    Route::get('/getBlogCategoryMenuBuilderData', [MenuBuilderController::class, 'getBlogCategoryMenuBuilderData'])->name('getBlogCategoryMenuBuilderData');
    Route::post('/SaveParentMenu', [MenuBuilderController::class, 'SaveParentMenu'])->name('SaveParentMenu');
    Route::get('/ajaxMakeMenuList', [MenuBuilderController::class, 'ajaxMakeMenuList'])->name('ajaxMakeMenuList');
    Route::post('/UpdateMenuSettings', [MenuBuilderController::class, 'UpdateMenuSettings'])->name('UpdateMenuSettings');
    Route::post('/deleteParentChildMenu', [MenuBuilderController::class, 'deleteParentChildMenu'])->name('deleteParentChildMenu');
    Route::post('/getMegaMenuTitleById', [MenuBuilderController::class, 'getMegaMenuTitleById'])->name('getMegaMenuTitleById');
    Route::post('/UpdateMegaMenuTitle', [MenuBuilderController::class, 'UpdateMegaMenuTitle'])->name('UpdateMegaMenuTitle');
    Route::post('/UpdateSortableMenuList', [MenuBuilderController::class, 'UpdateSortableMenuList'])->name('UpdateSortableMenuList');
    //All Combo
    Route::post('/getTimezoneList', [ComboController::class, 'getTimezoneList'])->name('getTimezoneList');
    Route::post('/getUserStatusList', [ComboController::class, 'getUserStatusList'])->name('getUserStatusList');
    Route::post('/getUserRolesList', [ComboController::class, 'getUserRolesList'])->name('getUserRolesList');
    Route::post('/getStatusList', [ComboController::class, 'getStatusList'])->name('getStatusList');
    Route::post('/getCategoryList', [ComboController::class, 'getCategoryList'])->name('getCategoryList');
    Route::post('/getBrandList', [ComboController::class, 'getBrandList'])->name('getBrandList');
    
    
    
    
    
    //Variations
    Route::get('/variations/{id}', [ProductsController::class, 'getVariationsPageData'])->name('variations');
    Route::post('/saveVariationsData', [ProductsController::class, 'saveVariationsData'])->name('saveVariationsData');
    
    //Product SEO
    Route::get('/product-seo/{id}', [ProductsController::class, 'getProductSEOPageData'])->name('product-seo');
    Route::post('/saveProductSEOData', [ProductsController::class, 'saveProductSEOData'])->name('saveProductSEOData');
        
    //Related Products
    Route::get('/related-products/{id}', [ProductsController::class, 'getRelatedProductsPageData'])->name('related-products');
    Route::get('/getProductListForRelatedTableData', [ProductsController::class, 'getProductListForRelatedTableData'])->name('getProductListForRelatedTableData');
    Route::get('/getRelatedProductTableData', [ProductsController::class, 'getRelatedProductTableData'])->name('getRelatedProductTableData');
    Route::post('/saveRelatedProductsData', [ProductsController::class, 'saveRelatedProductsData'])->name('saveRelatedProductsData');
    Route::post('/deleteRelatedProduct', [ProductsController::class, 'deleteRelatedProduct'])->name('deleteRelatedProduct');
        
          
    //Blog Categories
    Route::get('/blog-categories', [Blog_categoriesController::class, 'getBlogCategoriesPageLoad'])->name('blog-categories');
    Route::get('/getBlogCategoriesTableData', [Blog_categoriesController::class, 'getBlogCategoriesTableData'])->name('getBlogCategoriesTableData');
    Route::post('/saveBlogCategoriesData', [Blog_categoriesController::class, 'saveBlogCategoriesData'])->name('saveBlogCategoriesData');
    Route::post('/getBlogCategoriesById', [Blog_categoriesController::class, 'getBlogCategoriesById'])->name('getBlogCategoriesById');
    Route::post('/deleteBlogCategories', [Blog_categoriesController::class, 'deleteBlogCategories'])->name('deleteBlogCategories');
    Route::post('/bulkActionBlogCategories', [Blog_categoriesController::class, 'bulkActionBlogCategories'])->name('bulkActionBlogCategories');
    Route::post('/hasBlogCategorySlug', [Blog_categoriesController::class, 'hasBlogCategorySlug'])->name('hasBlogCategorySlug');
        
    //Blog
    Route::get('/blog', [BlogController::class, 'getBlogPageLoad'])->name('blog');
    Route::get('/getBlogTableData', [BlogController::class, 'getBlogTableData'])->name('getBlogTableData');
    Route::post('/saveBlogData', [BlogController::class, 'saveBlogData'])->name('saveBlogData');
    Route::post('/getBlogById', [BlogController::class, 'getBlogById'])->name('getBlogById');
    Route::post('/deleteBlog', [BlogController::class, 'deleteBlog'])->name('deleteBlog');
    Route::post('/bulkActionBlog', [BlogController::class, 'bulkActionBlog'])->name('bulkActionBlog');
    Route::post('/hasBlogSlug', [BlogController::class, 'hasBlogSlug'])->name('hasBlogSlug');
    
    

    //Review & Ratings
    Route::get('/review', [ReviewsController::class, 'getReviewRatingsPageLoad'])->name('review');
    Route::get('/getReviewRatingsTableData', [ReviewsController::class, 'getReviewRatingsTableData'])->name('getReviewRatingsTableData');
    Route::post('/deleteReviewRatings', [ReviewsController::class, 'deleteReviewRatings'])->name('deleteReviewRatings');
    Route::post('/bulkActionReviewRatings', [ReviewsController::class, 'bulkActionReviewRatings'])->name('bulkActionReviewRatings');

    //Shipping
    Route::get('/shipping', [ShippingController::class, 'getShippingPageLoad'])->name('shipping');
    Route::get('/getShippingTableData', [ShippingController::class, 'getShippingTableData'])->name('getShippingTableData');
    Route::post('/saveShippingData', [ShippingController::class, 'saveShippingData'])->name('saveShippingData');
    Route::post('/getShippingById', [ShippingController::class, 'getShippingById'])->name('getShippingById');
    Route::post('/deleteShipping', [ShippingController::class, 'deleteShipping'])->name('deleteShipping');
    Route::post('/bulkActionShipping', [ShippingController::class, 'bulkActionShipping'])->name('bulkActionShipping');

    //Collections
    Route::get('/collections', [CollectionsController::class, 'getCollectionsPageLoad'])->name('collections');
    Route::get('/getCollectionsTableData', [CollectionsController::class, 'getCollectionsTableData'])->name('getCollectionsTableData');
    Route::post('/saveCollectionsData', [CollectionsController::class, 'saveCollectionsData'])->name('saveCollectionsData');
    Route::post('/getCollectionsById', [CollectionsController::class, 'getCollectionsById'])->name('getCollectionsById');
    Route::post('/deleteCollections', [CollectionsController::class, 'deleteCollections'])->name('deleteCollections');
    Route::post('/bulkActionCollections', [CollectionsController::class, 'bulkActionCollections'])->name('bulkActionCollections');
    
    //Attributes
    Route::get('/attributes', [AttributesController::class, 'getAttributesPageLoad'])->name('attributes');
    Route::get('/getAttributesTableData', [AttributesController::class, 'getAttributesTableData'])->name('getAttributesTableData');
    Route::post('/saveAttributesData', [AttributesController::class, 'saveAttributesData'])->name('saveAttributesData');
    Route::post('/getAttributesById', [AttributesController::class, 'getAttributesById'])->name('getAttributesById');
    Route::post('/deleteAttributes', [AttributesController::class, 'deleteAttributes'])->name('deleteAttributes');
    Route::post('/bulkActionAttributes', [AttributesController::class, 'bulkActionAttributes'])->name('bulkActionAttributes');
    
    //Labels
    Route::get('/labels', [LabelsController::class, 'getLabelsPageLoad'])->name('labels');
    Route::get('/getLabelsTableData', [LabelsController::class, 'getLabelsTableData'])->name('getLabelsTableData');
    Route::post('/saveLabelsData', [LabelsController::class, 'saveLabelsData'])->name('saveLabelsData');
    Route::post('/getLabelsById', [LabelsController::class, 'getLabelsById'])->name('getLabelsById');
    Route::post('/deleteLabels', [LabelsController::class, 'deleteLabels'])->name('deleteLabels');
    Route::post('/bulkActionLabels', [LabelsController::class, 'bulkActionLabels'])->name('bulkActionLabels');
    
    //Coupons
    Route::get('/coupons', [CouponsController::class, 'getCouponsPageLoad'])->name('coupons');
    Route::get('/getCouponsTableData', [CouponsController::class, 'getCouponsTableData'])->name('getCouponsTableData');
    Route::post('/saveCouponsData', [CouponsController::class, 'saveCouponsData'])->name('saveCouponsData');
    Route::post('/getCouponsById', [CouponsController::class, 'getCouponsById'])->name('getCouponsById');
    Route::post('/deleteCoupons', [CouponsController::class, 'deleteCoupons'])->name('deleteCoupons');
    Route::post('/bulkActionCoupons', [CouponsController::class, 'bulkActionCoupons'])->name('bulkActionCoupons');

   
    //Page Variation
    Route::get('/page-variation', [ThemeOptionsController::class, 'getPageVariation'])->name('page-variation');
    Route::post('/savePageVariation', [ThemeOptionsController::class, 'savePageVariation'])->name('savePageVariation');

    //Section Manage
    Route::get('/section-manage', [SectionManageController::class, 'getSectionManagePageLoad'])->name('section-manage');
    Route::get('/getSectionManageTableData', [SectionManageController::class, 'getSectionManageTableData'])->name('getSectionManageTableData');
    Route::post('/saveSectionManageData', [SectionManageController::class, 'saveSectionManageData'])->name('saveSectionManageData');
    Route::post('/getSectionManageById', [SectionManageController::class, 'getSectionManageById'])->name('getSectionManageById');
    Route::post('/deleteSectionManage', [SectionManageController::class, 'deleteSectionManage'])->name('deleteSectionManage');
    Route::post('/bulkActionSectionManage', [SectionManageController::class, 'bulkActionSectionManage'])->name('bulkActionSectionManage');
    
    //Theme Logo
    Route::get('/theme-options', [ThemeOptionsController::class, 'getThemeOptionsPageLoad'])->name('theme-options');
    Route::post('/saveThemeLogo', [ThemeOptionsController::class, 'saveThemeLogo'])->name('saveThemeLogo');
    
    //Theme Options Header
    Route::get('/theme-options-header', [ThemeOptionsController::class, 'getThemeOptionsHeaderPageLoad'])->name('theme-options-header');
    Route::post('/saveThemeOptionsHeader', [ThemeOptionsController::class, 'saveThemeOptionsHeader'])->name('saveThemeOptionsHeader');
    
   
    //Theme Options Footer
    Route::get('/theme-options-footer', [ThemeOptionsController::class, 'getThemeOptionsFooterPageLoad'])->name('theme-options-footer');
    Route::post('/saveThemeOptionsFooter', [ThemeOptionsController::class, 'saveThemeOptionsFooter'])->name('saveThemeOptionsFooter');
    
   
    //Theme Options SEO
    Route::get('/theme-options-seo', [ThemeOptionsController::class, 'getThemeOptionsSEOPageLoad'])->name('theme-options-seo');
    Route::post('/saveThemeOptionsSEO', [ThemeOptionsController::class, 'saveThemeOptionsSEO'])->name('saveThemeOptionsSEO');
    
    //Cookie Consent
    Route::get('/cookie-consent', [ThemeOptionsController::class, 'getCookieConsent'])->name('cookie-consent');
    Route::post('/saveCookieConsent', [ThemeOptionsController::class, 'saveCookieConsent'])->name('saveCookieConsent');

    //Social Media
    Route::get('/social-media', [SocialMediasController::class, 'getSocialMediaPageLoad'])->name('social-media');
    Route::get('/getSocialMediaTableData', [SocialMediasController::class, 'getSocialMediaTableData'])->name('getSocialMediaTableData');
    Route::post('/saveSocialMediaData', [SocialMediasController::class, 'saveSocialMediaData'])->name('saveSocialMediaData');
    Route::post('/getSocialMediaById', [SocialMediasController::class, 'getSocialMediaById'])->name('getSocialMediaById');
    Route::post('/deleteSocialMedia', [SocialMediasController::class, 'deleteSocialMedia'])->name('deleteSocialMedia');
    Route::post('/bulkActionSocialMedia', [SocialMediasController::class, 'bulkActionSocialMedia'])->name('bulkActionSocialMedia');

    //General Page
    Route::get('/general', [SettingsController::class, 'getGeneralPageLoad'])->name('general');
    Route::post('/GeneralSettingUpdate', [SettingsController::class, 'GeneralSettingUpdate'])->name('GeneralSettingUpdate');
    
    //Theme Register
    Route::get('/theme-register', [SettingsController::class, 'loadThemeRegisterPage'])->name('theme-register');
    Route::get('/getPcodeData', [SettingsController::class, 'getPcodeData'])->name('getPcodeData');
    Route::post('/CodeVerified', [SettingsController::class, 'CodeVerified'])->name('CodeVerified');
    Route::post('/deletePcode', [SettingsController::class, 'deletePcode'])->name('deletePcode');
    
    //Google Recaptcha
    Route::get('/google-recaptcha', [SettingsController::class, 'loadGoogleRecaptchaPage'])->name('google-recaptcha');
    Route::post('/GoogleRecaptchaUpdate', [SettingsController::class, 'GoogleRecaptchaUpdate'])->name('GoogleRecaptchaUpdate');
    
    //Google Map
    Route::get('/google-map', [SettingsController::class, 'loadGoogleMapPage'])->name('google-map');
    Route::post('/GoogleMapUpdate', [SettingsController::class, 'GoogleMapUpdate'])->name('GoogleMapUpdate');

    //Mail Settings
    Route::get('/mail-settings', [SettingsController::class, 'loadMailSettingsPage'])->name('mail-settings');
    Route::post('/saveMailSettings', [SettingsController::class, 'saveMailSettings'])->name('saveMailSettings');
    
    //Payment methods
    Route::get('/payment-methods', [SettingsController::class, 'loadPaymentMethodsPage'])->name('payment-methods');
    Route::post('/StripeSettingsUpdate', [SettingsController::class, 'StripeSettingsUpdate'])->name('StripeSettingsUpdate');
    Route::post('/PaypalSettingsUpdate', [SettingsController::class, 'PaypalSettingsUpdate'])->name('PaypalSettingsUpdate');
    Route::post('/RazorpaySettingsUpdate', [SettingsController::class, 'RazorpaySettingsUpdate'])->name('RazorpaySettingsUpdate');
    Route::post('/MollieSettingsUpdate', [SettingsController::class, 'MollieSettingsUpdate'])->name('MollieSettingsUpdate');
    Route::post('/CODSettingsUpdate', [SettingsController::class, 'CODSettingsUpdate'])->name('CODSettingsUpdate');
    Route::post('/BankSettingsUpdate', [SettingsController::class, 'BankSettingsUpdate'])->name('BankSettingsUpdate');
    
    //Media Settings
    Route::get('/media-settings', [SettingsController::class, 'loadMediaSettingsPage'])->name('media-settings');
    Route::get('/getMediaSettingsTableData', [SettingsController::class, 'getMediaSettingsTableData'])->name('getMediaSettingsTableData');
    Route::post('/getMediaSettingsById', [SettingsController::class, 'getMediaSettingsById'])->name('getMediaSettingsById');
    Route::post('/MediaSettingsUpdate', [SettingsController::class, 'MediaSettingsUpdate'])->name('MediaSettingsUpdate');
    
    //All File Upload
    Route::post('/FileUpload', [UploadController::class, 'FileUpload'])->name('FileUpload');
    Route::post('/MediaUpload', [UploadController::class, 'MediaUpload'])->name('MediaUpload');
    
    
    
    //Orders Excel/CSV Export
    Route::get('/orders-excel-export', [OrdersExportController::class, 'OrdersExcelExport'])->name('orders-excel-export');
    Route::get('/orders-csv-export', [OrdersExportController::class, 'OrdersCSVExport'])->name('orders-csv-export');
    
    //Transactions Excel/CSV Export
    Route::get('/transactions-excel-export', [TransactionsExportController::class, 'TransactionsExcelExport'])->name('transactions-excel-export');
    Route::get('/transactions-csv-export', [TransactionsExportController::class, 'TransactionsCSVExport'])->name('transactions-csv-export');
    
    //Withdrawals
    Route::get('/withdrawals', [WithdrawalController::class, 'getWithdrawalsPageLoad'])->name('withdrawals');
    Route::get('/getWithdrawalsTableData', [WithdrawalController::class, 'getWithdrawalsTableData'])->name('getWithdrawalsTableData');
    Route::post('/saveWithdrawalsData', [WithdrawalController::class, 'saveWithdrawalsData'])->name('saveWithdrawalsData');
    Route::post('/getWithdrawalById', [WithdrawalController::class, 'getWithdrawalById'])->name('getWithdrawalById');
    Route::post('/deleteWithdrawal', [WithdrawalController::class, 'deleteWithdrawal'])->name('deleteWithdrawal');
    
    Route::post('/saveScreenshot', [WithdrawalController::class, 'saveScreenshot'])->name('saveScreenshot');
    Route::post('/getScreenshotById', [WithdrawalController::class, 'getScreenshotById'])->name('getScreenshotById');
    Route::post('/deleteScreenshotById', [WithdrawalController::class, 'deleteScreenshotById'])->name('deleteScreenshotById');

    //Seller Settings
    Route::get('/seller-settings', [SellerSettingsController::class, 'getSellerSettingsPageLoad'])->name('seller-settings');
    Route::post('/SellerSettingsSave', [SellerSettingsController::class, 'SellerSettingsSave'])->name('SellerSettingsSave');
        
});
