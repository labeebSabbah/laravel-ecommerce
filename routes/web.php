<?php

use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Models\SubCategory;

session_start();

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

Route::get('/banned', function() {
    return view('user.banned');
});

Route::middleware(['customer', 'nBan'])->group(function () {

    Route::get('/', [MainController::class, 'index']);

    Route::get('/products', function(){
        return view('products', [
            'products'=> Product::with(['category','subCategory'])->get(),
        ]);
    });
      
    Route::get('/products/search', [MainController::class, 'search']);

    Route::get('/product/{id}', [MainController::class, 'product']);

    Route::middleware('auth')->group(function () {

        Route::get('/cart', function() {
            return view('cart');
        });
        Route::post('/cart/add', [MainController::class, 'add']);
        Route::post('/cart/delete', [MainController::class, 'delete']);

        Route::get('/orders', [OrderController::class, 'cindex']);
        Route::post('/order/new', [OrderController::class, 'add']);
        Route::get('/order/{id}', function ($id) {
            $o = Order::findOr($id, function () {return new Order;});
            if (Auth::user()->id == $o->customer_id) {
                return view('order', ['o' => $o]);
            } return redirect('/orders');
        });

    });
        
    Route::middleware('guest')->group(function () {
        
        Route::get('/login', function () {
            return view('user.login');
        })->name('login');
            
        Route::get('/register', function () {
            return view('user.register');
        });
        
        Route::post('/user/login', [UserController::class, 'login']);
    
        Route::post('/user/register', [UserController::class, 'register']);
        
    });
    
});

Route::middleware('auth')->group(function () {
    
    Route::middleware('admin')->group(function () {

        Route::get('/admin', function () {
            return view('admin.dashboard');
        });

        Route::get('/admin/users', [UserController::class, 'index']);
        Route::put('/admin/users/ban', [UserController::class, 'ban']);

        Route::get('/admin/categories', [CategoryController::class, 'index']);
        Route::post('/admin/category/create', [CategoryController::class, 'createCat']);
        Route::get('/admin/category/{id}', function ($id) {return view('admin.category', ['cat' => Category::find($id)]);});
        Route::put('/admin/category/{id}/update', [CategoryController::class, 'updateCat']);
        Route::delete('/admin/category/{id}/delete', [CategoryController::class, 'deleteCat']);
        Route::get('admin/category/{id}/subCategories', [CategoryController::class, 'subCats']);

        Route::post('/admin/subCategory/create', [CategoryController::class, 'createSub']);
        Route::put('/admin/subCategory/{id}/update', [CategoryController::class, 'updateSub']);
        Route::delete('/admin/subCategory/{id}/delete', [CategoryController::class, 'deleteSub']);

        Route::get('/admin/products', [ProductController::class, 'index']);
        Route::post('/admin/product/create', [ProductController::class, 'create']);
        Route::get('/admin/product/{id}', function ($id){return view('admin.product', ['p' => Product::with(['category','subCategory'])->find($id)]);});
        Route::put('/admin/product/{id}/edit', [ProductController::class, 'update']);
        Route::delete('/admin/product/{id}/delete', [ProductController::class, 'delete']);

        Route::get('/admin/orders', [OrderController::class, 'index']);
        Route::get('admin/order/{id}', function ($id) {return view('admin.order', ['o' => Order::find($id)]);});
        Route::put('/admin/order/{id}/update', [OrderController::class, 'update']);

    });
    
    Route::get('/user/logout', [UserController::class, 'logout']);

});