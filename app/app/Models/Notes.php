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
        'created_at',
        'user_id'
    ];


    protected $hidden = [
        'updated_at',
    ];
}
