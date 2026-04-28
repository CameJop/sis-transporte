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

    /**
     * Relación: La terminal donde inicia la ruta
     */
    public function origen()
    {
        return $this->belongsTo(Terminal::class, 'id_origen');
    }

    /**
     * Relación: La terminal donde termina la ruta
     */
    public function destino()
    {
        return $this->belongsTo(Terminal::class, 'id_destino');
    }

    /**
     * Relación: Una ruta puede ser usada en muchos viajes
     */
    public function viajes()
    {
        return $this->hasMany(Viaje::class, 'id_ruta');
    }
}