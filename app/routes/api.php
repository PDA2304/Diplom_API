<?php

use App\Http\Controllers\AccountContoller;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\ShareController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

#region Пользователь
Route::post('/sing_up',[UserController::class, 'sing_up']);
Route::post('/sing_in',[UserController::class, 'sing_in']);
Route::post('/confirmation',[UserController::class, 'confirmation']);
#endregion

#region Заметка
Route::post('/notes',[NotesController::class, 'create']);
Route::post('/notes/restoration/{id}',[NotesController::class, 'restorationNotes']);
Route::get('/notes/user/{userId}',[NotesController::class, 'indexUser']);
Route::get('/notes/{id}',[NotesController::class, 'show']);
Route::put('/notes/{id}',[NotesController::class,'update']);
Route::delete('/notes/logicDelete/{id}',[NotesController::class, 'logicDeleteNotes']);
Route::delete('/notes/{id}',[NotesController::class, 'destroy']);
#endregion

#region Файла

#endregion

#region Аккаунты
Route::post('/account',[AccountContoller::class,'create']);
Route::get('/account/{id}',[AccountContoller::class,'show']);
Route::get('/account/user/{userId}',[AccountContoller::class, 'indexUser']);
Route::put('/account',[AccountContoller::class,'update']);
Route::delete('/account/logicDelete/{id}',[AccountContoller::class, 'logicDeleteAccount']);
Route::delete('/account/{id}',[AccountContoller::class, 'destroy']);
#endregion

#region Поделиться
Route::post("/share/add/notes",[ShareController::class,'shareAddNotes']);
Route::post("/share/add/account",[ShareController::class,'shareAddAccount']);
Route::delete('/share/remove/notes',[ShareController::class,'shareRemoveNotes']);
Route::delete('/share/remove/account',[ShareController::class,'shareRemoveAccount']);
#endregion