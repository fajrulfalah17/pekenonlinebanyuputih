<?php

use Illuminate\Support\Facades\Route;

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
Route::get('', 'HomeController@index')->name('home');

Route::get('/categories', 'CategoryController@index')->name('categories');
Route::get('/categories/{id}', 'CategoryController@detail')->name('categories-detail');

Route::get('/details/{id}', 'DetailController@index')->name('detail');
Route::post('/details/{id}', 'DetailController@add')->name('detail-add');

Route::get('/success', 'CartController@success')->name('success');

Route::get('/register/success', 'Auth\RegisterController@success')->name('register-success');




Route::group(['middelware' => ('auth')], function(){
        Route::post('/checkout', 'CheckoutController@process')->name('checkout');

        Route::get('/cart', 'CartController@index')->name('cart');
        Route::delete('/cart/{id}', 'CartController@delete')->name('cart-delete');

        Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
        Route::get('/dashboard/products', 'DashboardProductController@index')
                ->name('dashboard-products');
        Route::get('/dashboard/products/create', 'DashboardProductController@create')
                ->name('dashboard-products-create');
        Route::post('/dashboard/products', 'DashboardProductController@store')
                ->name('dashboard-products-store');
        Route::get('/dashboard/products/{id}', 'DashboardProductController@details')
                ->name('dashboard-products-details');
        Route::post('/dashboard/products/{id}', 'DashboardProductController@update')
                ->name('dashboard-products-update');

        Route::post('/dashboard/products/gallery/upload', 'DashboardProductController@uploadGallery')
                ->name('dashboard-products-gallery-upload');
        
        Route::get('/dashboard/products/gallery/delete/{id}', 'DashboardProductController@deleteGallery')
                ->name('dashboard-products-gallery-delete');

        Route::get('/dashboard/transactions', 'TransactionController@index')
                ->name('dashboard-transactions');
        Route::get('/dashboard/transactions/{id}', 'TransactionController@details')
                ->name('dashboard-transactions-details');
        Route::post('/dashboard/transactions/{id}', 'TransactionController@update')
                ->name('dashboard-transactions-update');

        Route::get('/dashboard/settings', 'DashboardSettingController@store')
                ->name('dashboard-settings-store');
        Route::get('/dashboard/account', 'DashboardSettingController@account')
                ->name('dashboard-settings-account');
        Route::post('/dashboard/account/{redirect}', 'DashboardSettingController@update')
                ->name('dashboard-settings-redirect');
});

//
Route::prefix('admin')
        ->namespace('Admin')
        ->middleware(['auth', 'admin'])
        ->group(function(){
                Route::get('/', 'DashboardController@index')->name('admin-dashboard');
                Route::resource('category', 'CategoryController');
                Route::resource('user', 'UserController');
                Route::resource('product', 'ProductController');
                Route::resource('product-gallery', 'ProductGalleryController');
        });

Auth::routes();