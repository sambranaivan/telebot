<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use Telegram\Bot;
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


Route::get('/test', [ApiController::class, 'test']);
Route::get('/telegram', [ApiController::class, 'test']);

// Put this inside either the POST route '/<token>/webhook' closure (see below) or 
// whatever Controller is handling your POST route
$updates = Telegram::getWebhookUpdates();

// Example of POST Route:
Route::post('/telegram/webhook', function () {
    $updates = Telegram::getWebhookUpdates();

    return 'ok';
});

// !!IMPORTANT!!
/* 
You need to add your route in "$except" array inside the app/Http/Middleware/VerifyCsrfToken.php file in order to bypass the CSRF Token verification process that takes place whenever a POST route is called.

Example:

protected $except = [
    '/<token>/webhook'
];
*/