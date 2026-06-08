<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Viaje extends Model
{
    use HasFactory;

    protected $table = 'VIAJE';
    protected $primaryKey = 'id_viaje';
    public $timestamps = false;

    protected $fillable = [
        'id_ruta',
        'id_bus',
        'fecha_salida',
        'id_itinerario',
        'estado'
    ];

    public function ruta()
    {
        return $this->belongsTo(Ruta::class, 'id_ruta');
    }

    public function bus()
    {
        return $this->belongsTo(Bus::class, 'id_bus');
    }
    public function itinerario()
    {
        // belongsTo porque la tabla VIAJE tiene la llave foránea 'id_itinerario'
        return $this->belongsTo(Itinerario::class, 'id_itinerario');
    }
}