<?php

namespace App\Http\Controllers;

use App\Http\Requests\SingInRequest;
use App\Http\Requests\SingUpRequest;
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
        return response()->json($result,200);
    }

    function sing_in(SingInRequest $request)
    {
        $result = ModelsUser::where('login', $request->login)->first();
        if (!Hash::check($request->password, $result->password)) {
            return response()->json(['password' => ["Не верный пароль"]], 422);
        }
        $result->token = Str::random(100);
        $result->save();
        return response()->json($result, 200);
    }

    public function confirmation(Request $request)
    {
        $mail_data = ["number" => random_int(10000, 99999)];

        Mail::send('email', $mail_data, function ($message) use ($request) {
            $message->sender("isip_d.a.pahomov@mpt.ru");
            $message->to($request->login);
            $message->subject("PrimetechPassManager подтвеждение почты");
        });

        return response()->json($mail_data, 200);
    }

    function user_search()
    {
    }

    function index()
    {
    }
}
