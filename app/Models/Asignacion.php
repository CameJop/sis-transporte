<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignacion extends Model
{
    use HasFactory;

    protected $table = 'ASIGNACION';
    protected $primaryKey = 'id_asignacion';
    public $timestamps = false;

    protected $fillable = [
        'id_viaje',
        'id_empleado',
        'fecha_asignacion'
    ];

    // Relaciones
    public function viaje()
    {
        return $this->belongsTo(Viaje::class, 'id_viaje');
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado');
    }
}