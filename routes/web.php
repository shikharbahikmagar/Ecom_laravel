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

Route::get('/', function () {
    return view('welcome');
});

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

    });

});

Route::namespace('Front')->group(function(){
    Route::get('/', 'IndexController@index');
    Route::get('/{url}', 'ProductsController@listing');
});