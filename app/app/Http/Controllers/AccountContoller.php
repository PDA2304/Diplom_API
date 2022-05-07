<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountCreateRequest;
use App\Http\Requests\AccountUpdateRequest;
use App\Http\Resources\AccountIndexResource;
use App\Models\Account;
use App\Models\ShareAccount;
use App\Models\ShareData;

class AccountContoller extends Controller
{
    function create(AccountCreateRequest $request)
    {
        $result = Account::create([
            'account_name' => $request->account_name,
            'login' => $request->login,
            'password' => $request->password,
            'description' => $request->description,
            'user_id' => $request->user_id
        ]);

        $shareData = ShareData::create([
            'user_sender_id' =>  $request->user_id,
            'user_receiver_id' =>  $request->user_id
        ]);

        ShareAccount::create([
            'account_id' => $result->id,
            'share_id' => $shareData->id
        ]);

        return response()->json($result, 200);
    }

    function update(AccountUpdateRequest $request)
    {
        $result = Account::find($request->id);
        if ($result == null)
            return response()->json('Таких данных нет', 404);
        $result->update([
            'account_name' => $request->account_name,
            'login' => $request->login,
            'password' => $request->password,
            'description' => $request->description,
        ]);
        return response()->json($result, 200);
    }

    function show($id)
    {
        $result = Account::find($id);
        return $result == null ?
            response()->json($result, 404) :
            response()->json($result, 200);
    }

    function indexUser($userId)
    {
        $result = AccountIndexResource::collection(
            ShareAccount::join('share_data', 'share_account.share_id', '=', 'share_data.id')
                ->join('account', 'share_account.account_id', '=', 'account.id')
                ->orderBy('account.created_at','DESC')  
                ->where('logic_delete', '=', 0)
                ->get()
                ->where('user_receiver_id', '=', $userId)
        );
        return response()->json($result, 200);
    }

    function logicDeleteAccount($id)
    {
        $result = Account::find($id);
        if ($result == null)
            return response()->json('Таких данных нет', 404);
        $result->logic_delete = true;
        $result->save();
        return response()->json($result, 200);
    }

    function desctroy($id)
    {
        $result = Account::find($id);
        if ($result == null)
            return response()->json('Таких данных нет', 404);
        $result->delete();
        return response()->json($result, 200);
    }
}
