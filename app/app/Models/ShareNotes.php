<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShareNotes extends Model
{
    use HasFactory;

    protected $table = 'share_notes';

    protected $fillable = [
        'notes_id',
        'share_id'
    ];


    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
