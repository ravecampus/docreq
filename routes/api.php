<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\BookAddressController;
use App\Http\Controllers\ChargesController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserCartController;
use App\Http\Controllers\OrderListController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PurposeController;
use App\Http\Controllers\ItemPurposeController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('signup',[AuthController::class, 'signup']);
Route::post('login',[AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('item/list',[ItemController::class,'list']);
Route::resource('item',ItemController::class);
Route::post('reset-password', [ResetPasswordController::class, 'resetPasswordRequest']);
Route::post('new-password', [ResetPasswordController::class, 'newPassword']);
Route::get('purpose/recommend', [PurposeController::class, 'recommenderList']);

Route::get('charges/get-charge/{id}',[ChargesController::class, 'getCharge']);
Route::middleware('auth:sanctum')->group(function () {
    Route::resource('order-status/action', OrderStatusController::class);
    Route::post('paypal/charges',[PaymentController::class,'charge']);
    Route::get('paypal/success/{id}',[PaymentController::class,'success']);
    Route::post('item-upload',[ItemsController::class, 'itemUpload']);
    Route::resource('items',ItemsController::class);
    Route::post('users/pass', [UserController::class, 'changePass']);
    Route::resource('users', UserController::class);
    Route::resource('clients', ClientController::class);
    Route::get('address-book/auth',[BookAddressController::class, 'authAddressBook']);
    Route::resource('address-book',BookAddressController::class);
    Route::put('charges/delivery/{id}',[ChargesController::class, 'delivery']);
    Route::put('charges/payment/{id}',[ChargesController::class, 'payment']);
    Route::post('user/password',[AuthController::class, 'changePassword']);
    Route::post('user/fillup',[AuthController::class, 'fillupName']);
    Route::post('user/email',[AuthController::class, 'changeEmail']);
    Route::resource('order', OrderController::class);
    Route::resource('user-cart', UserCartController::class);
    Route::get('order/pay/{id}', [OrderListController::class, 'orderpay']);
    Route::get('order-list', [OrderListController::class, 'orderList']);
    Route::get('auth-order', [OrderListController::class, 'authOrderList']);
    Route::get('order-status', [OrderListController::class, 'specificOrder']);
    Route::resource('report', ReportController::class);
    Route::get('purpose/list', [PurposeController::class, 'listPurpose']);
    Route::resource('purpose', PurposeController::class);
    Route::resource('item-purpose', ItemPurposeController::class);
    Route::get('others', [PurposeController::class, 'otherAlsoReq']);
  
});
