<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ChangePassword;
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
    ///Query builder
    $brands = DB::table('brands')->get();
    $abouts = DB::table('home_abouts')->first();
    //Eloquent orm
    $images = Multipic::all();

    return view('home', compact('brands', 'abouts', 'images'));
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

//All Admin Routes

Route::get('/home/slider', [HomeController::class, 'HomeSlider'])->name('home.slider');

Route::get('/add/slider', [HomeController::class, 'AddSlider'])->name('add.slider');

Route::post('/store/slider', [HomeController::class, 'StoreSlider'])->name('store.slider');

Route::get('/slider/edit/{id}', [HomeController::class, 'Edit']);

Route::post('/slider/update/{id}', [HomeController::class, 'Update']);

Route::get('slider/delete/{id}', [HomeController::class, 'Delete']);

// Home About Routes
Route::get('/home/about', [AboutController::class, 'HomeAbout'])->name('home.about');

Route::get('/add/About', [AboutController::class, 'AddAbout'])->name('add.about');

Route::post('/store/about', [AboutController::class, 'StoreAbout'])->name('store.about'); 

Route::get('/edit/about/{id}', [AboutController::class, 'EditAbout']);

Route::post('/update/about/{id}', [AboutController::class, 'UpdateAbout']);

Route::get('/delete/about/{id}', [AboutController::class, 'DeleteAbout']);

//Portfolio Page Routes
Route::get('/portfolio', [AboutController::class, 'Portfolio'])->name('portfolio');

//Admin Contact Page

Route::get('/admin/contact', [ContactController::class, 'AdminContact'])->name('admin.contact');

Route::get('/admin/add/contact', [ContactController::class, 'AdminAddContact'])->name('add.contact');

Route::post('/admin/store/contact', [ContactController::class, 'AdminStoreContact'])->name('store.contact');

Route::get('/contact/edit/{id}', [ContactController::class, 'AdminEditContact']);

Route::post('/update/contact/{id}', [ContactController::class, 'AdminUpdateContact']);

Route::get('/contact/delete/{id}', [ContactController::class, 'AdminDeleteContact']);

//Home Contact Page Route

Route::get('/contact', [ContactController::class, 'Contact'])->name('contact');

Route::post('/contact/form', [ContactController::class, 'ContactForm'])->name('contact.form');

Route::get('/admin/message', [ContactController::class, 'AdminMessage'])->name('admin.message');

Route::get('/message/delete/{id}', [ContactController::class, 'AdminDeleteMessage']);







Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('admin.index');
})->name('dashboard');

Route::get('/user/logout', [BrandController::class, 'Logout'])->name('user.logout');

//Change Password and User Profile

Route::get('/user/password', [ChangePassword::class, 'ChangePassword'])->name('change.password');

Route::post('/password/update', [ChangePassword::class, 'UpdatePassword'])->name('password.update');

// User Profile

Route::get('/user/profile', [ChangePassword::class, 'PasswordUpdate'])->name('profile.update');

Route::post('/user/profile/update', [ChangePassword::class, 'UpdateProfile'])->name('update.user.profile');
