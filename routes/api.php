<?php

use App\Http\Controllers\CourseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::resource('courses', CourseController::class);
Route::get('/checkout', [CourseController::class, 'checkout'])->name('checkout');
Route::get('/success', [CourseController::class, 'success'])->name('checkout.success');
Route::get('/cancel', [CourseController::class, 'cancel'])->name('checkout.cancel');