<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Itinerario extends Model
{
    // Apuntamos a tu tabla en la base de datos
    protected $table = 'ITINERARIO';
    protected $primaryKey = 'id_itinerario';
    
    // Permitimos la asignación masiva de sus columnas
    protected $fillable = ['id_ruta', 'hora_salida', 'dia_semana', 'estado'];

    /**
     * Relación: Un itinerario pertenece a una Ruta
     */
    public function ruta()
    {
        return $this->belongsTo(Ruta::class, 'id_ruta');
    }
}