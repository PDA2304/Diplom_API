<?php

namespace App\Http\Controllers;

use App\Http\Requests\DataInformationRequest;
use App\Http\Requests\HistoryActionRequest;
use App\Http\Requests\UserShareRequest;
use App\Http\Resources\IndexHistoryActionResource;
use App\Http\Resources\IndexUserShareResource;
use App\Models\Action;
use App\Models\ShareAccount;
use App\Models\ShareFile;
use App\Models\ShareNotes;
use App\Models\User;
use Illuminate\Http\Request;
use Jenssegers\Date\Date;

class InformationController extends Controller
{
    public function indexHistoryAction(HistoryActionRequest $request)
    {
        $result = IndexHistoryActionResource::collection(Action::where('user_id', '=', $request->user_id)
            ->where('type_table_id', '=', $request->type_table_id)
            ->where('data_id', '=', $request->data_id)
            ->orderBy('id', 'DESC')
            ->get());
        return response()->json($result, 200);
    }

    public  function indexUserShare(UserShareRequest $request)
    {
        switch ($request->type_table_id) {
            case 0: {
                    //Заметки
                    $result = IndexUserShareResource::collection(ShareNotes::join('share_data', 'share_data.id', '=', 'share_notes.share_id')
                        ->where('user_receiver_id', '!=', $request->user_id)
                        ->where('notes_id', '=', $request->data_id)
                        ->get());
                    return response()->json($result, 200);
                }
            case 1: {
                    //Файлы
                    return response()->json();
                }
            case 2: {
                    //Аккаунты
                    $result = IndexUserShareResource::collection(ShareAccount::join('share_data', 'share_data.id', '=', 'share_account.share_id')
                        ->where('user_receiver_id', '!=', $request->user_id)
                        ->where('account_id', '=', $request->data_id)
                        ->get());
                    return response()->json($result, 200);
                }
            default:
                return response()->json('Нет такого типа таблицы', 200);
        }
    }

    public function indexDataInformation(DataInformationRequest $request)
    {
        if ($request->type_table_id == 0) {
            $result = ShareNotes::join('share_data', 'share_data.id', '=', 'share_notes.share_id')
                ->join('notes', 'notes.id', '=', 'share_notes.notes_id')
                ->where('notes_id', '=', $request->data_id)
                ->first();
            if ($result == null) return response()->json('Данных нет', 404);
            return response()->json(
                [
                    'user_id' => $result->user_id,
                    'creator' => $result->user_id == $result->user_receiver_id,
                    'information_text' => [
                        [
                            'title' => 'Имя владельца',
                            'content' => $result->notes->user->user_name,
                        ],
                        [
                            'title' => 'Почта владельца',
                            'content' => $result->notes->user->login,
                        ],
                        [
                            'title' => 'Дата создания',
                            'content' =>  Date::parse(
                                $result->notes->created_at
                            )->format('j F Y'),
                        ],
                        [
                            'title' => 'Дата изменения',
                            'content' => Date::parse($result->notes->created_at)->format('j F Y'),
                        ],
                    ]
                ],
                200
            );
        }
        if ($request->type_table_id == 1) {
            $result = ShareFile::join('share_data', 'share_data.id', '=', 'share_files.share_id')
                ->join('files', 'files.id', '=', 'share_files.file_id')
                ->where('file_id', '=', $request->data_id)
                ->first();
            if ($result == null) return response()->json('Данных нет', 404);
            return  response()->json(
                [
                    'user_id' => $result->user_id,
                    'creator' => $result->user_id == $result->user_receiver_id,
                    'information_text' => [
                        [
                            'title' => 'Имя владельца',
                            'content' => $result->files->user->user_name,
                        ],
                        [
                            'title' => 'Почта владельца',
                            'content' => $result->files->user->login,
                        ],
                        [
                            'title' => 'Тип файла',
                            'content' => substr($result->files->path, strrpos($result->files->path, '.') - strlen($result->files->path) + 1)
                        ],
                        [
                            'title' => 'Размер файла',
                            'content' => "".strval(round($result->files->size / 1024, 2))." МБ"
                        ],
                        [
                            'title' => 'Дата создания',
                            'content' =>  Date::parse(
                                $result->files->created_at
                            )->format('j F Y'),
                        ],
                        [
                            'title' => 'Дата изменения',
                            'content' => Date::parse($result->files->created_at)->format('j F Y'),
                        ],
                    ]
                ],
                200
            );
        }
        if ($request->type_table_id == 2) {
            $result = ShareAccount::join('share_data', 'share_data.id', '=', 'share_account.share_id')
                ->join('account', 'account.id', '=', 'share_account.account_id')
                ->where('account_id', '=', $request->data_id)
                ->first();
            if ($result == null) return response()->json('Данных нет', 404);

            return  response()->json(
                [
                    'user_id' => $result->user_id,
                    'creator' => $result->user_id == $result->user_receiver_id,
                    'information_text' => [
                        [
                            'title' => 'Имя владельца',
                            'content' => $result->account->user->user_name,
                        ],
                        [
                            'title' => 'Почта владельца',
                            'content' => $result->account->user->login,
                        ],
                        [
                            'title' => 'Дата создания',
                            'content' =>  Date::parse(
                                $result->account->created_at
                            )->format('j F Y'),
                        ],
                        [
                            'title' => 'Дата изменения',
                            'content' => Date::parse($result->account->created_at)->format('j F Y'),
                        ],
                    ]
                ],
                200
            );
        }
        return response()->json('Нет такого типа таблицы', 200);
    }
}
