<?php

use App\Http\Controllers\CategoryController;
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
    });
});
