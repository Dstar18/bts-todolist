<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Session;  
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// login & register
Route::post('/login', [AuthController::class, 'auth']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::post('/register', [UsersController::class, 'store']);

Route::middleware(['BasicAuth','CheckLogin'])->group(function () {
    // checklist
    Route::get('/checklist', [ChecklistController::class, 'index']);
    Route::post('/checklist', [ChecklistController::class, 'store']);
    Route::post('/checklist/{id}', [ChecklistController::class, 'update']);
    Route::delete('/checklist/{id}', [ChecklistController::class, 'destroy']);
    Route::get('/checklist/{id}/item', [ChecklistController::class, 'show']);

    // items
    Route::post('/checklist/{id}/item', [ItemController::class, 'store']);
    Route::post('/checklist/{idChecklist}/item/{id}', [ItemController::class, 'update']);
    Route::get('/item/{id}', [ItemController::class, 'show']);
    Route::delete('/item/{id}', [ItemController::class, 'destroy']);
});
