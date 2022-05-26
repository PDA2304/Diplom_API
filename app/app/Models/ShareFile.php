<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShareFile extends Model
{
    use HasFactory;

    protected $table = 'share_files';

    protected $fillable = [
        'file_id',
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

    public function files()
    {
        return $this->belongsTo(File::class, 'file_id', 'id');
    }
}
