<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Mail\InqueryEmail;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/send_mail/', function(Request $request){
    $to = 'gautamsairash@gmail.com';
    Mail::to($to)->send(new InqueryEmail($request->name, $request->email, $request->subject, $request->body));

    return 'Email has been sent!';
});


Route::post('/store/{id}', [\App\Http\Controllers\LocationTrackController::class, 'create']);
Route::get('/show/{id}', [\App\Http\Controllers\LocationTrackController::class, 'show']);
Route::post('/reset/{id}', [\App\Http\Controllers\LocationTrackController::class, 'reset']);
