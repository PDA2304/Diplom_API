<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $table = 'account';

    protected $fillable = [
        'account_name',
        'login',
        'password',
        'description',
        'logic_delete',
        'user_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
