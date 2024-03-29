<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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

//register
Route::middleware('register_middleware')->get('/', function () {
    return view('admin.auth.register');
})->name('admin#register');


//login
Route::middleware('login_middleware')->get('admin/login', function() {
    return view('admin.auth.login');
})->name('admin#login');


//logout
Route::get('admin/logout', function() {
    Session::flush();
    Auth::logout();
    return redirect()->route('admin#login');
})->name('admin#logout');


//user must login or register
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    //show all categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('admin#categories');

    Route::prefix('admin')->group(function() {
        /* CATEGORIES */
        //create category
        Route::post('/categories/store', [CategoryController::class, 'store'])->name('admin#storeCategory');

        //delete category
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('admin#destroyCategory');

        //search category
        Route::get('/categories/search', [CategoryController::class, 'search'])->name('admin#searchCategory');

        //edit category
        Route::get('/categories/edit/{id}', [CategoryController::class, 'edit'])->name('admin#editCategory');

        //update category
        Route::put('categories/update/{id}', [CategoryController::class, 'update'])->name('admin#updateCategory');

        /* PRODUCTS */
        //show products
        Route::get('/products', [ProductController::class, 'index'])->name('admin#products');

        //product creation form
        Route::get('/products/create', [ProductController::class, 'create'])->name('admin#createProduct');

        //create product
        Route::post('/products/store', [ProductController::class, 'store'])->name('admin#storeProduct');

        //search product
        Route::get('/products/search', [ProductController::class, 'search'])->name('admin#searchProducts');

        //delete product
        Route::delete('/products/delete/{id}', [ProductController::class, 'destroy'])->name('admin#destroyProduct');

        //edit product
        Route::get('/products/edit/{id}', [ProductController::class, 'edit'])->name('admin#editProduct');

        //update product
        Route::put('/products/update/{id}', [ProductController::class, 'update'])->name('admin#updateProduct');
    });
});
