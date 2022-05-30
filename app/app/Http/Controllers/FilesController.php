<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilesCreateRequest;
use App\Http\Requests\FilesUpdateRequest;
use App\Http\Resources\FileResource;
use App\Http\Resources\IndexFilesResource;
use App\Models\File;
use App\Models\ShareData;
use App\Models\ShareFile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{
    public function index()
    {
        //
    }

    public function create(FilesCreateRequest $request)
    {
        $isSize = File::where('user_id', '=', $request->user_id)->addSelect(DB::raw('sum(files.size)'))->first();
        $isSize->sum = $isSize->sum + $request->size;
        if ($isSize->sum >= 1000000000) {
            return response()->json(['error' => ['file' => ["Недостаточно места"]]], 422);
        }
        $path = $request->file->store($request->login);
        $result = File::create([
            'files_name' => $request->file_name,
            'path' => $path,
            'size' => Storage::size($path),
            'description' => $request->description,
            'user_id' => $request->user_id
        ]);
        $shareData = ShareData::create([
            'user_sender_id' =>  $request->user_id,
            'user_receiver_id' =>  $request->user_id
        ]);
        ShareFile::create([
            'file_id' => $result->id,
            'share_id' => $shareData->id
        ]);
        return response()->json(new FileResource($result), 200);
    }

    public function show($id)
    {
        //
    }

    function update(FilesUpdateRequest $request)
    {
        $result = File::find($request->id);
        if ($result == null)
            return response()->json('Таких данных нет', 404);
        $isSize = File::where('user_id', '=', $request->user_id)->addSelect(DB::raw('sum(files.size)'))->first();
        $isSize->sum = $isSize->sum + $request->size;
        if ($isSize->sum >= 1000000000) {
            return response()->json(['error' => ['file' => ["Недостаточно места"]]], 422);
        }
        if (!Storage::delete($result->path)) {
            return response()->json(['error' => ['file' => ["Ошибка"]]], 422);
        }
        $path = $request->file->store(User::find($result->user_id)->login);
        $result->update([
            'files_name' => $request->file_name,
            'path' => $path,
            'size' => $request->size,
            'description' => $request->description,
        ]);

        return response()->json(new FileResource($result), 200);
    }


    public function indexUser($userId)
    {
        $result = IndexFilesResource::collection(

            ShareFile::join('share_data', 'share_files.share_id', '=', 'share_data.id')
                ->join('files', 'share_files.file_id', '=', 'files.id')
                ->orderBy('files.created_at', 'DESC')
                ->where('logic_delete', '=', 0)
                ->get()
                ->where('user_receiver_id', '=', $userId)
        );
        return response()->json($result, 200);
    }

    function logicDeleteFiles($id)
    {
        $result = File::find($id);
        $result->logic_delete = true;
        $result->save();
        return response()->json($result, 200);
    }

    public function destroy($id)
    {
        //
    }
}
