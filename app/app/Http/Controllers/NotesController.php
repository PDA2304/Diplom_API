<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotesCreateRequest;
use App\Http\Requests\NotesUpdateRequest;
use App\Models\Notes;

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
        if($result == null)
            return response()->json($result,404);
        return response()->json($result,200);        
    }

    function indexUser($userId)
    {
        $result = Notes::where('user_id', '=', $userId)->where('logic_delete', '=', 0)->get();
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
