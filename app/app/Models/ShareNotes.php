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
        'share_id',
        'created_at'
    ];


    protected $hidden = [
        'updated_at',
    ];

    public function shareData()
    {
        return $this->belongsTo(ShareData::class, 'share_id', 'id');
    }

    public function notes()
    {
        return $this->belongsTo(Notes::class, 'notes_id', 'id');
    }

}
