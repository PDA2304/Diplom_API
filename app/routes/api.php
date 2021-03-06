<?php

use App\Http\Controllers\AccountContoller;
use App\Http\Controllers\FilesController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\ShareController;
use App\Http\Controllers\TrashController;
use App\Http\Controllers\UserController;
use App\Http\Resources\DataResource;
use App\Models\ShareData;
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

Route::get('/php', function () {
    phpinfo();
    return false;
});

#region Пользователь
Route::post('/sing_up', [UserController::class, 'sing_up']);
Route::post('/sing_in', [UserController::class, 'sing_in']);
Route::post('/confirmation', [UserController::class, 'confirmation']);
Route::post('/confirmationNewLogin', [UserController::class, 'confirmationNewLogin']);
Route::post('/newUserName', [UserController::class, 'new_user_name']);
Route::post('/newLogin', [UserController::class, 'new_login']);
Route::post('/newPassword', [UserController::class, 'new_password']);
Route::post('/userSearch', [UserController::class, 'user_search']);
#endregion

#region Заметка
Route::post('/notes', [NotesController::class, 'create']);
Route::get('/notes/user/{userId}', [NotesController::class, 'indexUser']);
Route::get('/notes/{id}', [NotesController::class, 'show']);
Route::put('/notes/{id}', [NotesController::class, 'update']);
Route::delete('/notes/logicDelete/{id}', [NotesController::class, 'logicDeleteNotes']);
Route::delete('/notes/{id}', [NotesController::class, 'destroy']);
#endregion

#region Файла
Route::post('/files', [FilesController::class, 'create']);
Route::get('/files/user/{userId}', [FilesController::class, 'indexUser']);
Route::put('/files', [FilesController::class, 'update']);
Route::delete('/files/logicDelete/{id}', [FilesController::class, 'logicDeleteFiles']);
#endregion

#region Аккаунты
Route::post('/account', [AccountContoller::class, 'create']);
Route::get('/account/{id}', [AccountContoller::class, 'show']);
Route::get('/account/user/{userId}', [AccountContoller::class, 'indexUser']);
Route::put('/account', [AccountContoller::class, 'update']);
Route::delete('/account/logicDelete/{id}', [AccountContoller::class, 'logicDeleteAccount']);
Route::delete('/account/{id}', [AccountContoller::class, 'destroy']);
#endregion

#region Поделиться
Route::post('/share/add/', [ShareController::class, 'shareAddData']);
Route::delete('/share/remove', [ShareController::class, 'shareRemoveData']);
#endregion

#region корзина
Route::get('/trash/{id}', [TrashController::class, 'indexUser']);
Route::post('/trash', [TrashController::class, 'restoration']);
Route::post('/trash/allUser/{id}', [TrashController::class, 'restorationallUser']);
Route::delete('/trash/allUser/{id}', [TrashController::class, 'destroyAllUser']);
Route::delete('/trash', [TrashController::class, 'destroy']);
#endregion

#region Информация
Route::get('/information/history_action', [InformationController::class, 'indexHistoryAction']);
Route::get('/information/user_share', [InformationController::class, 'indexUserShare']);
Route::get('/information/data_information', [InformationController::class, 'indexDataInformation']);
#endregion

#region Вывод всех данных
Route::get('/data/{id}', function ($id) {
    $result =
        DataResource::collection(
            ShareData::leftJoin('share_account', 'share_data.id', '=', 'share_account.share_id')
                ->leftJoin('share_notes', 'share_data.id', '=', 'share_notes.share_id')
                ->leftJoin('share_files', 'share_data.id', '=', 'share_files.share_id')
                ->leftJoin('account', 'share_account.account_id', '=', 'account.id')
                ->leftJoin('notes', 'share_notes.notes_id', '=', 'notes.id')
                ->leftJoin('files', 'share_files.file_id', '=', 'files.id')
                ->orderBy('share_data.created_at', 'DESC')
                ->select(
                    'share_data.created_at',
                    'notes.notes_name',
                    'account.account_name',
                    'files.files_name',
                    'notes.id as notes_id',
                    'account.id as account_id',
                    'files.id as files_id',
                    'share_data.user_sender_id',
                    'share_data.user_receiver_id'
                )
                ->where(function ($query) use ($id) {
                    $query->orwhere('user_receiver_id', '=', $id);
                })
                ->where(function ($query) {
                    $query->orwhere('notes.logic_delete', '=', 0)
                        ->orwhere('account.logic_delete', '=', 0)
                        ->orwhere('files.logic_delete', '=', 0);
                })
                ->get()
        );


    return response()->json($result, 200);
});
#endregion