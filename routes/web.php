<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\ToDoController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BusinessController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\FaqTitleController;
use App\Http\Controllers\Admin\BroadcastController;

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

Route::get('/', function() {
	return view('welcome');
})->name('index');


Route::prefix('/admin')->group(function() {


    Route::get('/', [ AdminAuthController::class, 'showLoginPage' ])->name('admin');
    Route::get('/login', [ AdminAuthController::class, 'showLoginPage' ])->name('admin.login');
    Route::post('/login/submit', [ AdminAuthController::class, 'login' ])->name('admin.login.submit');
    Route::get('/forgot-password', [ AdminAuthController::class, 'showForgotPasswordPage' ])->name('admin.forgot.password');
    Route::post('/reset-password', [ AdminAuthController::class, 'sendResetLink' ])->name('admin.reset.password');
    Route::get('/generate-password', [ AdminAuthController::class, 'generatePassword' ])->name('admin.generate.password');
    Route::get('/page-not-found', [ AdminAuthController::class, 'pageNotFound' ])->name('admin.pagenotfound');
    Route::get('/error', [ AdminAuthController::class, 'error' ])->name('admin.error');

    Route::group([ 'middleware' => ['authadmin'] ], function() {

        Route::get('/profile', [ AdminAuthController::class, 'showProfilePage' ])->name('admin.profile');
        Route::post('/profile/update', [AdminAuthController::class, 'updateProfile'])->name('admin.profile.update');
        

        Route::get('logout', [ AdminAuthController::class, 'logout' ])->name('admin.logout');

        Route::prefix('/dashboard')->group(function() {

            Route::get('/', [ AdminAuthController::class, 'dashboard' ])->name('admin.dashboard');
            Route::post('/add-item', [ ToDoController::class, 'add' ] )->name('admin.todo.add');
            Route::post('/change-todo-status', [ ToDoController::class, 'changeToDoStatus' ] )->name('admin.change.todo.status');
            Route::get('/change-item-order', [ ToDoController::class , 'changeItemOrder'])->name('change.item.controller');
        });

        Route::prefix('/blog')->group(function() {

            Route::get('/', [ BlogController::class, 'index' ])->name('admin.blog');
            Route::get('/add', [ BlogController::class, 'add' ])->name('admin.blog.add');
            Route::post('/add/store', [ BlogController::class, 'store' ])->name('admin.blog.add.store');
            Route::get('/edit/{id}', [ BlogController::class, 'edit' ])->name('admin.blog.edit');
            Route::post('/delete', [ BlogController::class, 'delete' ])->name('admin.blog.delete');
        });

        Route::prefix('/business')->group(function() {

            Route::get('/', [ BusinessController::class, 'index' ])->name('admin.business');
            Route::get('/add', [ BusinessController::class, 'add' ])->name('admin.business.add');
            Route::post('/add/store', [ BusinessController::class, 'store' ])->name('admin.business.add.store');
            Route::get('/edit/{id}', [ BusinessController::class, 'edit' ])->name('admin.business.edit');
            Route::post('/delete', [ BusinessController::class, 'delete' ])->name('admin.business.delete');
        });


        Route::prefix('/user')->group(function() {
            Route::get('/', [ UserController::class, 'index' ])->name('admin.user');
            Route::get('/add', [ UserController::class, 'add' ])->name('admin.user.add');
            Route::post('/add/store', [ UserController::class, 'store' ])->name('admin.user.add.store');
            Route::get('/edit/{id}', [ UserController::class, 'edit' ])->name('admin.user.edit');
            Route::post('/delete', [ UserController::class, 'delete' ])->name('admin.user.delete');
        });

        Route::prefix('/broadcast')->group(function() {
            Route::get('/', [ BroadcastController::class, 'index' ])->name('admin.broadcast.message');
            Route::post('/send', [ BroadcastController::class, 'broadcastMessage' ])->name('admin.broadcast.message.send');
        });
    });

});


