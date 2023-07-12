<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NiceController;
use App\Http\Controllers\UserPostController;
use App\Http\Controllers\CategoryController;
use App\Models\Nice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use App\Events\MessageReceived;
use App\Http\Controllers\Auth\LoginController;

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


Auth::routes();




Route::group(['middleware' => 'auth'], function(){
    Route::get('/',[HomeController::class,'index'])->name('index');

    #search
    Route::get('/serach', [HomeController::class,'search'])->name('search');

    #post
    Route::get('/post/create', [PostController::class,'create'])->name('post.create');
    Route::post('/post/store', [PostController::class,'store'])->name('post.store');
    Route::get('/post/{id}/show',[PostController::class,'show'])->name('post.show');
    Route::patch('/post/{id}/update', [PostController::class,'update'])->name('post.update');
    Route::patch('/post/{id}/changePostStatus', [PostController::class, 'changePostStatus'])->name('post.changeStatus');

    #chat routes
    Route::group(['prefix' => 'chat', 'as' => 'chat.'], function(){
        Route::get('/{id}', [ChatController::class, 'showChat'])->name('showChat');
        Route::get('/', [ChatController::class, 'getChattedUser'])->name('getChattedUser');
        Route::post('/store',[ChatController::class, 'store'])->name('store');
    });

    #profile routes
    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function(){
        Route::get('/{id}/show', [ProfileController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/{id}/update', [ProfileController::class, 'update'])->name('update');
    });

    #admin route
    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function(){
        #categories
        Route::post('/create_category', [CategoryController::class, 'createCategory'])->name('create_category');
    });
});

// Google Login
Route::get('/login/google', [LoginController::class,'redirectToGoogle'])->name('google.redirect');
Route::get('/login/google/callback', [LoginController::class,'handleGoogleCallback'])->name('google.callback');
