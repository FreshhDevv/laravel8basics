<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ContactController;
use App\Models\Multipic;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;


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

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/', function () {
    $brands = DB::table('brands')->get();
    return view('home', compact('brands'));
});

Route::get('/home', function () {
    echo "This is the Home Page";
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/contact', [ContactController::class, 'index'])->name('con');

//Category Controller
Route::get('/category/all', [CategoryController::class, 'AllCat'])->name('all.category');

Route::post('/category/add', [CategoryController::class, 'AddCat'])->name('store.category');

Route::get('/category/edit/{id}', [CategoryController::class, 'Edit']);

Route::post('/category/update/{id}', [CategoryController::class, 'Update']);

Route::get('/softdelete/category/{id}', [CategoryController::class, 'SoftDelete']);

Route::get('/category/restore/{id}', [CategoryController::class, 'Restore']);

Route::get('/delete/category/{id}', [CategoryController::class, 'Delete']);

/// Brand Routes ///

Route::get('/brand/all', [BrandController::class, 'AllBrand'])->name('all.brand');

Route::post('/brand/add',[BrandController::class, 'StoreBrand'])->name('store.brand');

Route::get('/brand/edit/{id}', [BrandController::class, 'Edit']);

Route::post('/brand/update/{id}', [BrandController::class, 'Update']);

Route::get('/brand/delete/{id}', [BrandController::class, 'Delete']);

// Multi Image Routes

Route::get('/multi/image', [BrandController::class, 'Multipic'])->name('multi.image');

Route::post('/multi/add', [BrandController::class, 'StoreImage'])->name('store.image');


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    // $users = User::all();
    // $users = DB::table('users')->get();
    return view('admin.index');
})->name('dashboard');

Route::get('/user/logout', [BrandController::class, 'Logout'])->name('user.logout');
