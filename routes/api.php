<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

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


// Example of POST Route:
Route::post('/telegram/webhook',[ApiController::class,'test'])->name("webhook");


Route::post("/telegram/start",[ApiController::class,'start'])->name("start");

Route::post("/telegram/update",[ApiController::class,'update'])->name("update");

Route::post("/telegram/explore",[ApiController::class,'explore'])->name("explore");

// Route::post("/telegram/menu",[ApiController::class,'menu_principal'])->name("menu");

// !!IMPORTANT!!
/* 
You need to add your route in "$except" array inside the app/Http/Middleware/VerifyCsrfToken.php file in order to bypass the CSRF Token verification process that takes place whenever a POST route is called.

Example:

protected $except = [
    '/<token>/webhook'
];
*/