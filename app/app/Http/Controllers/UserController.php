<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewLoginRequest;
use App\Http\Requests\NewPasswordRequest;
use App\Http\Requests\NewUserNameRequest;
use App\Http\Requests\SingInRequest;
use App\Http\Requests\SingUpRequest;
use App\Http\Requests\UserSearchRequest;
use App\Models\File;
use App\Models\ShareAccount;
use App\Models\ShareFile;
use App\Models\ShareNotes;
use App\Models\User as ModelsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use TheSeer\Tokenizer\Token as TokenizerToken;

class UserController extends Controller
{
    function sing_up(SingUpRequest $request)
    {
        $result = ModelsUser::create([
            'user_name' => $request->user_name,
            'login' => $request->login,
            'password' => Hash::make($request->password),
            'token' => Str::random(100)
        ]);
        return response()->json($result, 200);
    }

    function sing_in(SingInRequest $request)
    {
        $result = ModelsUser::where('login', $request->login)->first();
        if (!Hash::check($request->password, $result->password)) {
            return response()->json(['error' => ['password' => ["Не верный пароль"]]], 422);
        }
        $result->token = Str::random(100);
        $result->save();
        return response()->json($result, 200);
    }

    public function confirmation(SingUpRequest $request)
    {
        $mail_data = ["number" => random_int(10000, 99999)];

        Mail::send('email', $mail_data, function ($message) use ($request) {
            $message->sender("isip_d.a.pahomov@mpt.ru");
            $message->to($request->login);
            $message->subject("PrimetechPassManager подтверждение почты");
        });

        return response()->json($mail_data, 200);
    }

    public function new_password(NewPasswordRequest $request)
    {
        $result = ModelsUser::find($request->id);
        if (!Hash::check($request->old_password, $result->password)) {
            return response()->json(['error' => ['old_password' => ["Пароль не совпадает со старым"]]], 422);
        }
        $result->password =  Hash::make($request->new_password);
        $result->save();
        return response()->json(true, 200);
    }

    public function confirmationNewLogin(NewLoginRequest $request)
    {
        $mail_data = ["number" => random_int(10000, 99999)];

        Mail::send('email', $mail_data, function ($message) use ($request) {
            $message->sender("isip_d.a.pahomov@mpt.ru");
            $message->to($request->login);
            $message->subject("PrimetechPassManager смена почты");
        });

        return response()->json($mail_data, 200);
    }

    public function new_login(NewLoginRequest $request)
    {
        $result = ModelsUser::find($request->id);
        $result->login = $request->login;
        $result->save();
        return response()->json($result, 200);
    }

    public function new_user_name(NewUserNameRequest $request)
    {
        $result = ModelsUser::find($request->id);
        $result->user_name = $request->user_name;
        $result->save();
        return response()->json($result, 200);
    }

    function user_search(UserSearchRequest $request)
    {

        switch ($request->type_table) {
            case 1: {
                    //Заметки
                    $resultId = ShareNotes::leftJoin('share_data', 'share_data.id', '=', 'share_notes.share_id')
                        ->where('share_notes.notes_id', '=', $request->data_id)->select('share_data.user_receiver_id')
                        ->groupBy('share_data.user_receiver_id')->get();
                    break;
                }
            case 2: {
                    //Файлы
                    $resultId = ShareFile::leftJoin('share_data', 'share_data.id', '=', 'share_files.share_id')
                        ->where('share_files.file_id', '=', $request->data_id)->select('share_data.user_receiver_id')
                        ->groupBy('share_data.user_receiver_id')->get();
                    break;
                }
            case 3: {
                    //Аккаунты
                    $resultId = ShareAccount::leftJoin('share_data', 'share_data.id', '=', 'share_account.share_id')
                        ->where('share_account.account_id', '=', $request->data_id)->select('share_data.user_receiver_id')
                        ->groupBy('share_data.user_receiver_id')->get();
                    break;
                }
            default:
                break;
        }

        if (trim($request->search) == '')
            return response()->json(['error' => ['search' => ['Пользователь ничего не ввел']]], 422);
        $searchTerm =  '%'. $request->search . '%';
        $result = ModelsUser::where('login', 'ilike', $searchTerm);

        foreach ($resultId as $key) {
            $result = $result->where('id', '!=', $key->user_receiver_id);
        }

        return response()->json($result->get(), 200);
    }

    function index()
    {
    }
}
