<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\v1\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/unauthenticated', function () {
    return response()->json(['status'=> false, 'message' => 'Unauthenticated.'], 401);
});

Route::prefix('v1')->namespace('Api/v1')->group(function () {

    Route::get('state', [ ApiController::class, 'getState' ]);
    
    Route::get('city', [ ApiController::class, 'getCity' ]);
    
    Route::post('login', [ ApiController::class, 'login' ]);
    
    Route::post('forgot-password', [ ApiController::class, 'forgotPassword' ]);
    
    Route::post('reset-password', [ ApiController::class, 'resetPassword' ]);

    Route::middleware('auth:api')->group(function () {
        // our routes to be protected will go in here
        Route::get('blogs', [ApiController::class, 'getBlogs']);

        Route::get('profile', [ApiController::class, 'myProfile']);
        
        Route::post('update-profile', [ApiController::class, 'updateProfile']);
        
        Route::post('add-member', [ApiController::class, 'addMember']);
        
        Route::get('get-sub-members', [ApiController::class, 'getSubMembers']);

        Route::get('get-all-members-with-sub-members', [ApiController::class, 'getAllMembersWithSubMembers']);
        
        Route::get('notification', [ApiController::class, 'getNotificaion']);
        
        Route::post('change-password', [ApiController::class, 'changePassword']);
        
        Route::get('all-members-excel', [ApiController::class, 'allMembersExcel']);
        
        Route::get('generate-pdf-profile', [ApiController::class, 'generatePDFProfile']);
        
        Route::get('get-all-business', [ApiController::class, 'getBusiness']);

    });

});
