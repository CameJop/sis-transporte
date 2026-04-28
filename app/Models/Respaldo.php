<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respaldo extends Model
{
    use HasFactory;

    protected $table = 'RESPALDO';
    protected $primaryKey = 'id_respaldo';
    public $timestamps = false; // La fecha se maneja por DB o manual

    protected $fillable = [
        'fecha',
        'descripcion'
    ];
}