<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use HasFactory;

    protected $table = 'actions';

    protected $fillable = [
        'id',
        'action_date',
        'user_id',
        'data_id',
        'type_action_id',
        'type_table_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function action()
    {
        return $this->belongsTo(TypeAction::class, 'type_action_id', 'id');
    }

    public function table(){
        return $this->belongsTo(TypaTable::class, 'type_table_id', 'id');
    }
}
