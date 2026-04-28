<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruta extends Model
{
    use HasFactory;

    protected $table = 'RUTA';
    protected $primaryKey = 'id_ruta';
    public $timestamps = false;

    protected $fillable = [
        'id_origen',
        'id_destino',
        'distancia',
        'duracion_estimada'
    ];

    public function origen() {
        return $this->belongsTo(Terminal::class, 'id_origen');
    }

    public function destino() {
        return $this->belongsTo(Terminal::class, 'id_destino');
    }
}