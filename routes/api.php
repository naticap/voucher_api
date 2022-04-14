<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PurchaseTransactionController;
use App\Http\Controllers\VoucherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('me', function() {
        return Auth::user();
    });
    
    Route::resource('customers', CustomerController::class);
    Route::get('eligible', [CustomerController::class, 'eligible']);

    Route::resource('vouchers', VoucherController::class);

    Route::resource('purchase-transactions', PurchaseTransactionController::class);
    Route::get('logout', [AuthController::class, 'logout']);
});




