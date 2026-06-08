<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RespaldoActionHistory extends Model
{
    protected $table = 'respaldo_action_history';

    protected $fillable = [
        'action',
        'respaldo_id',
        'snapshot',
        'performed_by',
    ];

    protected $casts = [
        'snapshot' => 'array',
    ];
}