<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShareAccount extends Model
{
    use HasFactory;

    protected $table = 'share_account';

    protected $fillable = [
        'account_id',
        'share_id',
        'created_at',
    ];


    protected $hidden = [
        'updated_at',
    ];
}
