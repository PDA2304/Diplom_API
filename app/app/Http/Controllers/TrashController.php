<?php

namespace App\Http\Controllers;

use App\Http\Requests\SelectRequest;
use App\Http\Resources\DataResource;
use App\Models\Account;
use App\Models\Notes;
use App\Models\ShareAccount;
use App\Models\ShareData;
use App\Models\ShareNotes;
use Illuminate\Http\Request;

class TrashController extends Controller
{
    public function index()
    {
        //
    }

    public function indexUser($id)
    {
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
                    ->where('user_sender_id', '=', $id)
                    ->where(function ($query) {
                        $query->orwhere('notes.logic_delete', '=', 1)
                            ->orwhere('account.logic_delete', '=', 1)
                            ->orwhere('files.logic_delete', '=', 1);
                    })
                    ->get()
            );


        return response()->json($result, 200);
    }

    public function restorationAllUser($id)
    {
        Notes::where('user_id', '=', $id)->where('logic_delete', 1)->update(['logic_delete' => 0]);
        // Files::where('user_id','=',$id)->where('logic_delete',1)->update(['logic_delete' => 0]);
        Account::where('user_id', '=', $id)->where('logic_delete', 1)->update(['logic_delete' => 0]);
        return response()->json('succes', 200);
    }


    public function restoration(SelectRequest $request)
    {

        foreach ($request->all() as $key) {
            switch ($key['type_table']) {
                case 0: {
                        // notes
                        $result = Notes::find($key['id']);
                        if ($result == null)
                            break;
                        $result->logic_delete = false;
                        $result->save();
                        break;
                    }
                case 1: {
                        //files
                        // $result = Files::find($key['id']);
                        // $result->logic_delete = false;
                        // $result->save();
                        break;
                    }
                case 2: {
                        //account
                        $result = Account::find($key['id']);
                        if ($result == null)
                            break;
                        $result->logic_delete = false;
                        $result->save();
                        break;
                    }
            }
        }

        return response()->json('succes', 200);
    }


    public function destroyAllUser($id)
    {
        Notes::where('user_id', '=', $id)->where('logic_delete', 1)->delete();
        // Files::where('user_id','=',$id)->where('logic_delete',1)->delete();
        Account::where('user_id', '=', $id)->where('logic_delete', 1)->delete();
        return response()->json('succes', 200);
    }

    public function destroy(SelectRequest $request)
    {
        foreach ($request->all() as $key) {
            switch ($key['type_table']) {
                case 0: {
                        // notes
                        $result =  ShareNotes::where('notes_id', '=', $key['id'])->first();
                        if ($result == null)
                            break;
                        ShareData::whereId($result->share_id)->delete();
                        Notes::whereId($key['id'])->delete();
                        break;
                    }
                case 1: {
                        //files
                        // $result = Files::find($key['id']);
                        // $result->delete();
                        break;
                    }
                case 2: {
                        //account
                        $result = ShareAccount::where('account_id', '=', $key['id'])->first();
                        if ($result == null)
                            break;
                        ShareData::whereId($result->share_id)->delete();
                        Account::whereId($key['id'])->delete();
                        break;
                    }
            }
        }

        return response()->json('succes', 200);
    }
}
