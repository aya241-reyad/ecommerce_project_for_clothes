<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\sizes\SizeIndex;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\SubCatController;



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
/*

 Route::get('/login', function () {
    return redirect('/login');
});
*/

Route::post('/do-login', [LoginController::class, 'doLogin'])->name('do-login');
Route::get('/login', [LoginController::class, 'viewLogin'])->name('login');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::post('/update/admin', [HomeController::class, 'updateProfile'])->name('updateProfile');

    Route::resource('products',ProductController::class);
    Route::resource('categories',CategoryController::class);
    Route::resource('subCategories',SubCatController::class);

    Route::resource('cards',CardController::class);
    Route::resource('offers',OfferController::class);
    Route::resource('sliders', SliderController::class);
    Route::resource('shippings', ShippingController::class);
    Route::get('/view-settings', [SettingController::class, 'create'])->name('view-settings');
    Route::post('/store-settings', [SettingController::class, 'store'])->name('store-settings');
    Route::get('/view-clients', [ClientController::class, 'index'])->name('view-clients');
    Route::get('/delete-clients/{id}', [ClientController::class, 'delete'])->name('delete-clients');
    Route::get('client-change-status', [ClientController::class,'changeStatus']);
    Route::get('Backend/changeStatus', [OfferController::class,'changeStatus']);
    Route::get('Backend/change-slider-status', [SliderController::class,'changeStatus']);
    Route::get('orders',[OrderController::class,'index'])->name('orders');
    Route::get('/show-order/{id}', [OrderController::class, 'show'])->name('show-order');
    Route::resource('products', ProductController::class);
    Route::get('generate-pdf/{id}', [PDFController::class, 'generatePDF']);
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
        Route::get('/Backend/change/status/featured', [ProductController::class , 'changeStatus']);

    Route::controller(ColorController::class)->group(function () {
        Route::get('/colors', 'index')->name('index.colors');
        Route::get('color/create', 'create');
        Route::post('color/store', 'store');
        Route::get('color/edit/{id}', 'edit')->name('color.edit');
        Route::put('color/update/{id}', 'update')->name('color.update');
    Route::delete('color/delete/{id}', 'destroy')->name('colors.delete');
        Route::get('/Backend/change/status/color', 'changeStatus');

    });
    
              Route::controller(CouponController::class)->group(function () {
            Route::get('/coupons', 'index')->name('coupon.index');
            Route::get('/coupons/create', 'create')->name('coupon.create');
            Route::post('coupons/store','store')->name('coupon.store');
            Route::post('coupons/renew', 'renew')->name('coupon.renew');
            Route::delete('coupons/delete/{id}', 'delete')->name('coupon.delete');
            Route::get('coupons/edit/{id}','edit')->name('coupon.edit');
                        Route::put('coupons/update/{id}','update')->name('coupon.update');


        });


    Route::controller(SizeController::class)->group(function () {
        Route::get('sizes', 'index')->name('sizes.index');
        Route::post('size/store' , 'store')->name('size.store');
        Route::delete('size/delete/{id}', 'destroy')->name('size.delete');

    });

});