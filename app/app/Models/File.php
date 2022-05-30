<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $table = 'files';

    protected $casts = [
        'user_id' => 'integer',
        'size' => 'integer',
    ];

    protected $fillable = [
        'files_name',
        'path',
        'size',
        'logic_delete',
        'description',
        'created_at',
        'user_id'
    ];


    protected $hidden = [
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
