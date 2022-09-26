<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Models\Category;
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

Route::get('/banned', function() {
    return view('user.banned');
});

Route::middleware(['customer', 'nBan'])->group(function () {

    Route::get('/', [MainController::class, 'index']);
      
    Route::get('/search', function() {
        return view('search');
    });
        
    Route::middleware('guest')->group(function () {
        
        Route::get('/login', function () {
            return view('user.login');
        });
            
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
        Route::get('/admin/category/{id}', function ($id) {
            $cat = Category::find($id);
            return view('admin.category', ['cat' => $cat]);
        });
        Route::put('/admin/category/{id}/update', [CategoryController::class, 'updateCat']);
        Route::delete('/admin/category/{id}/delete', [CategoryController::class, 'deleteCat']);
        Route::get('admin/category/{id}/subCategories', [CategoryController::class, 'subCats']);
        Route::post('/admin/subCategory/create', [CategoryController::class, 'createSub']);
        Route::put('/admin/subCategory/{id}/update', [CategoryController::class, 'updateSub']);
        Route::delete('/admin/subCategory/{id}/delete', [CategoryController::class, 'deleteSub']);

        Route::get('/admin/products', [ProductController::class, 'index']);
        Route::post('/admin/product/create', [ProductController::class, 'create']);

        Route::get('/admin/orders', function () {
            return view('admin.orders');
        });


    });
    
    Route::get('/user/logout', [UserController::class, 'logout']);

});