<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShareData extends Model
{
    use HasFactory;

    protected $table = 'share_data';

    protected $fillable = [
        'user_sender_id',
        'user_receiver_id'
    ];


    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
