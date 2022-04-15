<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{
    use HasFactory;

    protected $table = 'notes';

    protected $fillable = [
        'notes_name',
        'content',
        'logic_delete',
        'description',
        'user_id'
    ];


    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
