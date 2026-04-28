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
        'hora_salida',
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
}