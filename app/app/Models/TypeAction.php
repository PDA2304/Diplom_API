<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeAction extends Model
{
    use HasFactory;

    protected $table = 'type_actions';

    protected $fillable = [
        'id',
        'action_name',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    
}