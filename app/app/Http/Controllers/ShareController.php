<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShareAccountAddRequest;
use App\Http\Requests\ShareAccountRemoveRequest;
use App\Http\Requests\ShareAddDataRequest;
use App\Http\Requests\ShareNotesAddRequest;
use App\Http\Requests\ShareNotesRemoveRequest;
use App\Http\Requests\ShareRemoveDataRequest;
use App\Models\Account;
use App\Models\File;
use App\Models\Notes;
use App\Models\ShareAccount;
use App\Models\ShareData;
use App\Models\ShareFile;
use App\Models\ShareNotes;
use Illuminate\Http\Request;

class ShareController extends Controller
{
    function shareAddData(ShareAddDataRequest $request)
    {
        foreach ($request->user_receiver as $key) {
            switch ($request->type_table) {
                case 1: {
                        // Notes
                        $result = ShareNotes::where('notes_id', '=', $request->data_id)
                            ->leftJoin('share_data', 'share_data.id', '=', 'share_notes.share_id')
                            ->where('user_receiver_id', '=', $key)
                            ->get();

                        if (count($result) == 0) {

                            if (count(ShareNotes::where('notes_id', '=', $request->data_id)->get()) == 0) break;
                            if ($request->user_sender_id == $key) break;

                            $shareData = ShareData::create([
                                'user_sender_id' =>  $request->user_sender_id,
                                'user_receiver_id' =>  $key
                            ]);
                            $shareNotes = ShareNotes::create([
                                'notes_id' => $request->data_id,
                                'share_id' => $shareData->id
                            ]);
                        }

                        break;
                    }

                case 2: {
                        // Files
                        $result = ShareFile::where('file_id', '=', $request->data_id)
                            ->leftJoin('share_data', 'share_data.id', '=', 'share_files.share_id')
                            ->where('user_receiver_id', '=', $key)
                            ->get();

                        if (count($result) == 0) {

                            if (count(ShareFile::where('file_id', '=', $request->data_id)->get()) == 0) break;
                            if ($request->user_sender_id == $key) break;

                            $shareData = ShareData::create([
                                'user_sender_id' =>  $request->user_sender_id,
                                'user_receiver_id' =>   $key
                            ]);
                            $shareNotes = ShareFile::create([
                                'file_id' => $request->data_id,
                                'share_id' => $shareData->id
                            ]);
                        }
                        break;
                    }
                case 3: {
                        // Account
                        $result = ShareAccount::where('account_id', '=', $request->data_id)
                            ->leftJoin('share_data', 'share_data.id', '=', 'share_account.share_id')
                            ->where('user_receiver_id', '=', $key)
                            ->get();

                        if (count($result) == 0) {

                            if (count(ShareAccount::where('account_id', '=', $request->data_id)->get()) == 0) break;
                            if ($request->user_sender_id == $key) break;
                            $shareData = ShareData::create([
                                'user_sender_id' =>  $request->user_sender_id,
                                'user_receiver_id' =>  $key
                            ]);
                            $shareNotes = ShareAccount::create([
                                'account_id' => $request->data_id,
                                'share_id' => $shareData->id
                            ]);
                        }

                        break;
                    }
            }
        }
        return response()->json('sucess', 200);
    }


    function shareRemoveData(ShareRemoveDataRequest $request)
    {
        switch ($request->type_table) {
            case 1: {
                    // Notes
                    $shareAccount = ShareNotes::join('share_data', 'share_notes.share_id', '=', 'share_data.id')
                        ->join('notes', 'share_notes.notes_id', '=', 'notes.id')
                        ->get()
                        ->where('user_receiver_id', '=', $request->user_receiver_id)
                        ->where('notes_id', '=', $request->data_id)->first();

                    // if (ShareNotes::find($request->data_id) == null) break;
                    if ($request->user_sender_id == $request->user_receiver_id) break;

                    ShareData::find($shareAccount->share_id)->delete();
                    break;
                }

            case 2: {
                    // Files
                    $shareAccount = ShareFile::join('share_data', 'share_files.share_id', '=', 'share_data.id')
                        ->join('files', 'share_files.file_id', '=', 'files.id')
                        ->get()
                        ->where('user_receiver_id', '=', $request->user_receiver_id)
                        ->where('files.id', '=', $request->data_id)->first();

                    // if (ShareFile::find($request->data_id) == null) break;
                    if ($request->user_sender_id == $request->user_receiver_id) break;

                    ShareData::find($shareAccount->share_id)->delete();
                    break;
                }
            case 3: {
                    // Account
                    $shareAccount = ShareAccount::join('share_data', 'share_account.share_id', '=', 'share_data.id')
                        ->join('account', 'share_account.account_id', '=', 'account.id')
                        ->get()
                        ->where('user_receiver_id', '=', $request->user_receiver_id)
                        ->where('account_id', '=', $request->data_id)->first();

                    // if (ShareAccount::find($request->data_id) == null) break;
                    if ($request->user_sender_id == $request->user_receiver_id) break;

                    ShareData::find($shareAccount->share_id)->delete();
                    break;
                }
        }
        return response()->json('sucess', 200);
    }
}
