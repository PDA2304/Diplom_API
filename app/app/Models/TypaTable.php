<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypaTable extends Model
{
    use HasFactory;

    protected $table = 'type_table';

    protected $fillable = [
        'id',
        'table_name',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    
}
