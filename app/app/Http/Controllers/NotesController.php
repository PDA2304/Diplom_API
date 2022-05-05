<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotesCreateRequest;
use App\Http\Requests\NotesUpdateRequest;
use App\Http\Resources\NotesIndexResource;
use App\Models\Notes;
use App\Models\ShareData;
use App\Models\ShareNotes;

class NotesController extends Controller
{

    function create(NotesCreateRequest $request)
    {
        $result = Notes::create([
            'notes_name' => $request->notes_name,
            'content' => $request->content,
            'description' => $request->description,
            'user_id' => $request->user_id,
        ]);
        $shareData = ShareData::create([
            'user_sender_id' =>  $request->user_id,
            'user_receiver_id' =>  $request->user_id
        ]);
        ShareNotes::create([
            'notes_id' => $result->id,
            'share_id' => $shareData->id
        ]);
        return response()->json($result, 200);
    }

    function update(NotesUpdateRequest $request, $id)
    {
        $result = Notes::find($id);
        if ($result == null)
            return response()->json('Таких данных нет', 404);
        $result->update($request->all());
        return response()->json($result, 200);
    }

    function show($id)
    {
        $result = Notes::find($id);
        if ($result == null)
            return response()->json($result, 404);
        return response()->json($result, 200);
    }

    function indexUser($userId)
    {
        $result = NotesIndexResource::collection(
            ShareNotes::join('share_data', 'share_notes.share_id', '=', 'share_data.id')
                ->join('notes', 'share_notes.notes_id', '=', 'notes.id')
                ->orderBy('notes.created_at','DESC')
                ->where('logic_delete', '=', 0)
                ->get()
                ->where('user_receiver_id', '=', $userId)
        );
        return response()->json($result, 200);
    }

    function logicDeleteNotes($id)
    {
        $result = Notes::find($id);
        $result->logic_delete = true;
        $result->save();
        return response()->json($result, 200);
    }

    function destroy($id)
    {
        $result = Notes::find($id);
        $result->delete();
        return response()->json($result, 200);
    }
}
