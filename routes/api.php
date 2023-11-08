<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/payin/toppay/webhook', 'WebhookController@toppay_payin')->name('payin.toppay.webhook');
Route::post('/payout/toppay/webhook', 'WebhookController@toppay_payout')->name('payout.toppay.webhook');
Route::post('/upgrade/toppay/webhook', 'WebhookController@toppay_plan_upgrade')->name('plan_upgrade.toppay.webhook');

Route::post('/payin/webhook', 'WebhookController@payin')->name('payin.webhook');
Route::post('/payin/webhook_new', 'WebhookController@webhook_new')->name('payin.webhook_new');
Route::post('/payout/webhook', 'WebhookController@payout')->name('payout.webhook');
// Route::post('/payment/reset/investment', 'WebhookController@resetInvestment');
