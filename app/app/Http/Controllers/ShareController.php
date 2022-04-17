<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShareNotesAddRequest;
use App\Http\Requests\ShareNotesRemoveRequest;
use App\Models\ShareData;
use App\Models\ShareNotes;
use Illuminate\Http\Request;

class ShareController extends Controller
{
    function shareAddNotes(ShareNotesAddRequest $request)
    {
        $result = ShareNotes::join('share_data', 'share_notes.share_id', '=', 'share_data.id')
            ->join('notes', 'share_notes.notes_id', '=', 'notes.id')
            ->get()
            ->where('user_receiver_id', '=', $request->user_receiver)
            ->where('notes_id', '=', $request->notes_id)->first();
        if ($result != null)
            return response()->json('Не возможно поделиться данными', 422);

        $shareData = ShareData::create([
            'user_sender_id' =>  $request->user_sender,
            'user_receiver_id' =>  $request->user_receiver
        ]);

        $shareNotes = ShareNotes::create([
            'notes_id' => $request->notes_id,
            'share_id' => $shareData->id
        ]);
    }


    function shareRemoveNotes(ShareNotesRemoveRequest $request)
    {
        $shareNotes = ShareNotes::join('share_data', 'share_notes.share_id', '=', 'share_data.id')
            ->join('notes', 'share_notes.notes_id', '=', 'notes.id')
            ->get()
            ->where('user_receiver_id', '=', $request->user_receiver_id)
            ->where('notes_id', '=', $request->notes_id)->first();

        if ($shareNotes == null) {
            return response()->json('Таких данных нет', 200);
        }
        if ($shareNotes->user_sender_id == $shareNotes->user_receiver_id) {
            return response()->json('Данные относятся к владельцу', 200);
        }

        ShareData::find($shareNotes->share_id)->delete();
        return response()->json($shareNotes, 200);
    }
}