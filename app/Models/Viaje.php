<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Viaje extends Model
{
    use HasFactory;

    protected $table = 'VIAJE';
    protected $primaryKey = 'id_viaje';
    
    // Desactivamos si no usas created_at/updated_at, 
    // o dejamos en true si Laravel los maneja.
    public $timestamps = false;

    protected $fillable = [
        'id_ruta',
        'id_bus',
        'fecha_salida',
        'hora_salida',
        'estado'
    ];

    /**
     * Relación: Un viaje pertenece a una Ruta
     */
    public function ruta()
    {
        return $this->belongsTo(Ruta::class, 'id_ruta');
    }

    /**
     * Relación: Un viaje tiene un Bus asignado
     */
    public function bus()
    {
        return $this->belongsTo(Bus::class, 'id_bus');
    }

    /**
     * Relación: Un viaje tiene muchas asignaciones de conductores
     */
    public function asignaciones()
    {
        return $this->hasMany(Asignacion::class, 'id_viaje');
    }
}