<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
use App\Category;
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('/admin')->namespace('Admin')->group(function(){
    Route::match(['get', 'POST'], '/', 'AdminController@login');

    Route::group(['middleware' => ['admin']], function(){

        Route::get('dashboard', 'AdminController@dashboard');
        Route::get('logout', 'AdminController@logout');
        Route::get('settings', 'AdminController@setting');
        Route::post('check-current-pwd', 'AdminController@chkCurrentPassword');
        Route::post('update-current-pwd', 'AdminController@updateCurrentPassword');
        Route::match(['get', 'post'], 'update-admin-details', 'AdminController@updateAdminDetails');

        //sections route
        Route::get('sections', 'SectionController@section');
        Route::post('update-section-status', 'SectionController@updateSectionStatus');

        //categories route
        Route::get('categories', 'CategoryController@category');
        Route::post('update-category-status', 'CategoryController@updateCategoryStatus');
        Route::match(['get', 'post'], 'add-edit-category/{id?}' , 'CategoryController@addEditCategory');

        Route::post('append-categories-level', 'CategoryController@appendCategoryLevel');
        Route::get('delete-category-image/{id}', 'CategoryController@deleteCategoryImage');
        Route::get('delete-category/{id}', 'CategoryController@deleteCategory');

        //products route
        Route::get('products', 'ProductsController@product');
        Route::post('update-product-status', 'ProductsController@updateProductStatus');
        Route::get('delete-product/{id}', 'ProductsController@deleteProduct');
        Route::match(['get', 'post'], 'add-edit-product/{id?}', 'ProductsController@addEditProduct');
        Route::get('delete-product-image/{id}', 'ProductsController@deleteProductImage');
        Route::get('delete-product-video/{id}', 'ProductsController@deleteProductVideo');

        //Products Attributes Route
        Route::match(['get', 'post'], 'add-product-attributes/{id}', 'ProductsController@addAttributes');
        Route::post('edit-product-attributes/{id}', 'ProductsController@editAttribute');
        Route::post('update-attribute-status', 'ProductsController@updateProductAttributeStatus');
        Route::get('delete-attribute/{id}', 'ProductsController@deleteAttribute');

        //for product alternative images
        Route::match(['get', 'post'], 'add-images/{id}', 'ProductsController@addImages');
        Route::post('update-product-image-status', 'ProductsController@updateImageStatus');
        Route::get('delete-image/{id}', 'ProductsController@deleteAltImage');

        //Brands Routes
        Route::get('brands', 'BrandController@brand');
        Route::post('update-brand-status', 'BrandController@updateBrandStatus');
        Route::match(['get', 'post'], 'add-edit-brand/{id?}', 'BrandController@addEditBrand');
        Route::get('delete-brand/{id}', 'BrandController@deleteBrand');

        //banners Route
        Route::get('banners', 'BannersController@banner');
        Route::post('update-banner-status', 'BannersController@updateBannerStatus');
        Route::get('delete-banner/{id}', 'BannersController@deleteBanner');
        Route::match(['get', 'post'], 'add-edit-banners/{id?}', 'BannersController@addEditBanner');
        Route::get('delete-banner-image/{id}', 'BannersController@deleteBannerImage');

        //coupons
        Route::get('/coupons', 'CouponsController@coupons');
        Route::post('/update-coupon-status', 'CouponsController@updateCouponStatus');
        Route::get('delete-coupon/{id}', 'CouponsController@deleteCoupon');
        Route::match(['get', 'post'], 'add-edit-coupons/{id?}', 'CouponsController@addEditCoupon');
        
        //orders
        Route::get('/orders', 'OrdersController@orders');
        //order details amdin
        Route::get('/orders/{id}','OrdersController@orderDetails'); 
        Route::post('/update-order-status', 'OrdersController@updateOrderStatus');
        //view order invoice
        Route::get('/view-order-invoice/{id}', 'OrdersController@viewOrderInvoice');
        //print pdf file
        Route::get('/print-pdf-invoice/{id}', 'OrdersController@printPdfInvoice');
    });

});

Route::namespace('Front')->group(function(){
    //home page route
    Route::get('/', 'IndexController@index');
    //get category urls
    $catUrls = Category::select('url')->where('status', 1)->get()->pluck('url')->toArray();
    // echo "<pre>"; print_r($catUrls); 
    foreach($catUrls as $url)
    {
        Route::get('/'.$url, 'ProductsController@listing');
        // echo "<pre>"; print_r($url); 
    }
    //product details
    Route::get('/product/{id}', 'ProductsController@details');
    //getting price according to size
    Route::post('/getting-product-price', 'ProductsController@getProductPrice');
    //add to cart
    Route::post('add-to-cart', 'ProductsController@addtoCart');
    //shopping cart rout
    Route::get('/cart', 'ProductsController@cart');
    //update cart item quantity
    Route::post('/update-cart-item-qty', 'ProductsController@updateCartItem');
    //delete cart item
    Route::post('/delete-cart-item', 'ProductsController@deleteCartItem');
    //login/register
    Route::get('/login-register', ['as'=>'login', 'uses'=>'UsersController@loginRegister']);
    //check user email existance
    Route::match(['get', 'post'], '/check-email', 'UsersController@checkEmail');
    //login
    Route::post('/login', 'UsersController@userLogin');
    //register
    Route::post('/register', 'UsersController@userRegister');
    //logout
    Route::get('/logout', 'UsersController@logoutUser');
    //confirm email
    Route::match(['get', 'post'], '/confirm/{code}', 'UsersController@confirmAccount');
    //user forgot password
    Route::match(['get', 'post'], '/forgot-password', 'UsersController@forgotPassword');
    //middleware auth
    Route::group(['middleware'=>['auth']], function(){
        
        //user account 
        Route::match(['get', 'post'], '/account', 'UsersController@account');
        //orders
        Route::get('/orders', 'OrdersController@orders');
        //view order details
        Route::get('/order-details/{id?}', 'OrdersController@orderDetails');
        //check current password
        Route::post('/check-user-pwd', 'UsersController@checkeUserPwd');
        //update user password
        Route::post('/update-user-pwd', 'UsersController@updateUserPwd');
        //apply coupon\
        Route::post('/apply-coupon', 'ProductsController@applyCoupon');
        //checkout
        Route::match(['get', 'post'], '/checkout', 'ProductsController@checkout');
        //add edit delivery address by user
        Route::match(['get', 'post'], '/add-edit-delivery-address/{id?}', 'ProductsController@addEditDeliveryAddress');
        //delete delivery address
        Route::get('/delete-delivery-address/{id?}', 'ProductsController@deleteDeliveryAddress');
        //thanks page
        Route::get('/thanks', 'ProductsController@thanks');
        
    });


});