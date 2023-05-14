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
use App\Models\Nice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use App\Events\MessageReceived;

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
    Route::get('/post/{id}/edit', [PostController::class, 'edit'])->name('post.edit');
    Route::patch('/post/{id}/update', [PostController::class,'update'])->name('post.update');
    Route::get('/user_post/create',[PostController::class,'createPost'])->name('user_post.create');
    Route::delete('/post/{id}/destroy', [PostController::class,'destroy'])->name('post.destroy');
    Route::patch('/post/{id}/changePostStatus', [PostController::class, 'changePostStatus'])->name('post.changeStatus');

    #user_post
    Route::post('/user_post/store', [UserPostController::class,'store'])->name('user_post.store');

    #comments store
    Route::group(['prefix' => 'comment' , 'as' => 'comment.'], function(){
        Route::post('/comment/{post_id}/store',[CommentController::class,'store'])->name('store');
        Route::delete('/comment/{id}/destroy', [CommentController::class, 'destroy'])->name('destroy');
    });

    #chat routes
    Route::group(['prefix' => 'chat', 'as' => 'chat.'], function(){
        Route::get('/{id}', [ChatController::class, 'showChat'])->name('showChat');
        Route::get('/{id}/messages', [ChatController::class, 'getMessages'])->name('messages');
        Route::post('/send',[ChatController::class, 'send'])->name('send');
        Route::post('/store',[ChatController::class, 'store'])->name('store');
    });



    #profile routes
    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function(){
        Route::get('/{id}/show', [ProfileController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/{id}/update', [ProfileController::class, 'update'])->name('update');
    });

    #nice rotes
    Route::group(['prefix' => 'nice', 'as' => 'nice.'], function(){
        Route::post('/{post_id}/store', [NiceController::class, 'store'])->name('store');
        Route::delete('/{id}/destroy', [NiceController::class, 'destroy'])->name('destroy');

    });

    #follow route
    Route::group(['prefix' => 'follow', 'as' => 'follow.'], function(){
        Route::post('/{id}/store', [FollowController::class, 'store'])->name('store');
        Route::delete('/{id}/destroy', [FollowController::class, 'destroy'])->name('destroy');

    });

    #admin route
    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function(){
        #users
        Route::get('/users',[UserController::class, 'index'])->name('users');
        Route::delete('/users/{id}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');
        Route::patch('/users/{id}/activate', [UserController::class, 'activate'])->name('users.activate');

        #posts
        Route::get('/posts', [App\Http\Controllers\Admin\PostController::class, 'index'])->name('posts');
        Route::delete('/posts/{id}/deactivate', [App\Http\Controllers\Admin\PostController::class, 'deactivate'])->name('posts.deactivate');
        Route::patch('/posts/{id}/activate', [App\Http\Controllers\Admin\PostController::class, 'activate'])->name('posts.activate');

        #categories
        Route::get('/categories', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('categories');
        Route::get('/create_category', [App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('create_category');
        Route::post('/category/store', [App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('store');
        Route::delete('/categories/{id}/destroy', [App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('categories.destroy');
        Route::get('/categories/{id}/edit',
        [ App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('categories.edit');
        Route::patch('/categories/{id}/update',[ App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('categories.update');





    });

    // Broadcast
    Broadcast::routes(['middleware' => ['auth:sanctum']]);
});
