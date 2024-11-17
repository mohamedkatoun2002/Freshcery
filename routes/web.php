<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/about', [App\Http\Controllers\HomeController::class, 'about'])->name('about');
Route::get('/contact', [App\Http\Controllers\HomeController::class, 'contact'])->name('contact');
Route::get('/faq', [App\Http\Controllers\HomeController::class, 'faq'])->name('faq');
Route::get('/terms', [App\Http\Controllers\HomeController::class, 'terms'])->name('terms');
Route::get('/privacy-policy', [App\Http\Controllers\HomeController::class, 'privacyPolicy'])->name('privacy-policy');


//grouping routes
Route::group(['prefix' => 'products'], function () {
    //Products
    Route::get('/category/{id}', [App\Http\Controllers\Products\ProductsController::class, 'singleCategory'])->name('single.category');
    Route::get('/single-product/{id}', [App\Http\Controllers\Products\ProductsController::class, 'singleProduct'])->name('single.product');
    Route::get('/shop', [App\Http\Controllers\Products\ProductsController::class, 'shop'])->name('products.shop');


    //Cart
    Route::post('/add-cart', [App\Http\Controllers\Products\ProductsController::class, 'addToCart'])->name('products.add.cart');
    Route::get('/cart', [App\Http\Controllers\Products\ProductsController::class, 'cart'])->name('products.cart')->middleware('auth:web');
    Route::get('/delete-cart/{id}', [App\Http\Controllers\Products\ProductsController::class, 'deleteCart'])->name('products.delete.cart');

    //Checkout
    Route::post('/prepare-checkout', [App\Http\Controllers\Products\ProductsController::class, 'prepareCheckout'])->name('products.checkout.prepare');
    Route::get('/checkout', [App\Http\Controllers\Products\ProductsController::class, 'checkout'])->name('products.checkout')->middleware('check.for.price');
    Route::post('/checkout', [App\Http\Controllers\Products\ProductsController::class, 'checkoutProcess'])->name('products.checkout.process')->middleware('check.for.price');

    //Payment
    Route::get('/pay', [App\Http\Controllers\Products\ProductsController::class, 'payWithPayPal'])->name('products.pay')->middleware('check.for.price');
    Route::get('/success', [App\Http\Controllers\Products\ProductsController::class, 'success'])->name('products.success')->middleware('check.for.price');
});

Route::group(['prefix' => 'users'], function () {
    //users pages
    Route::get('/my-orders', [App\Http\Controllers\Users\UsersController::class, 'MyOrders'])->name('users.orders')->middleware('auth:web');
    Route::get('/settings', [App\Http\Controllers\Users\UsersController::class, 'settings'])->name('users.settings')->middleware('auth:web');
    Route::post('/settings', [App\Http\Controllers\Users\UsersController::class, 'updateUsersSettings'])->name('users.settings.update')->middleware('auth:web');
});


//Admin Panel
Route::get('admin/login', [App\Http\Controllers\Admin\AdminController::class, 'login'])->name('admin.login')->middleware('check.for.auth');
Route::post('admin/login', [App\Http\Controllers\Admin\AdminController::class, 'loginProcess'])->name('login.process');

Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function () {

    Route::get('/index', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('admin.dashboard');


    //Admin Section
    Route::get('all-admins', [App\Http\Controllers\Admin\AdminController::class, 'allAdmins'])->name('all.admins');
    Route::get('create-admins', [App\Http\Controllers\Admin\AdminController::class, 'createAdmins'])->name('create.admins');
    Route::post('create-admins', [App\Http\Controllers\Admin\AdminController::class, 'storeAdmins'])->name('store.admins');

    //Categories
    Route::get('all-categories', [App\Http\Controllers\Admin\AdminController::class, 'displayAllCategories'])->name('all.categories');
    Route::get('create-categories', [App\Http\Controllers\Admin\AdminController::class, 'createCategories'])->name('create.categories');
    Route::post('create-categories', [App\Http\Controllers\Admin\AdminController::class, 'storeCategories'])->name('store.categories');
    Route::get('edit-categories/{id}', [App\Http\Controllers\Admin\AdminController::class, 'editCategories'])->name('edit.categories');
    Route::post('update-categories/{id}', [App\Http\Controllers\Admin\AdminController::class, 'updateCategories'])->name('update.categories');
    Route::get('delete-categories/{id}', [App\Http\Controllers\Admin\AdminController::class, 'deleteCategories'])->name('delete.categories');

    //Products
    Route::get('all-products', [App\Http\Controllers\Admin\AdminController::class, 'displayAllProducts'])->name('all.products');
    Route::get('create-products', [App\Http\Controllers\Admin\AdminController::class, 'createProducts'])->name('create.products');
    Route::post('create-products', [App\Http\Controllers\Admin\AdminController::class, 'storeProducts'])->name('store.products');
    Route::get('delete-products/{id}', [App\Http\Controllers\Admin\AdminController::class, 'deleteProducts'])->name('delete.products');

    //Orders
    Route::get('all-orders', [App\Http\Controllers\Admin\AdminController::class, 'displayAllOrders'])->name('all.orders');
    Route::get('edit-order/{id}', [App\Http\Controllers\Admin\AdminController::class, 'editOrders'])->name('edit.order');
    Route::post('edit-order/{id}', [App\Http\Controllers\Admin\AdminController::class, 'updateOrders'])->name('update.order');
    Route::get('delete-order/{id}', [App\Http\Controllers\Admin\AdminController::class, 'deleteOrders'])->name('delete.order');
});
