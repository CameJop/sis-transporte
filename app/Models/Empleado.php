<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $table = 'EMPLEADO';
    protected $primaryKey = 'id_empleado';
    public $timestamps = false; // La tabla no tiene created_at/updated_at

    protected $fillable = [
        'nombre',
        'telefono',
        'licencia',
        'rol',
        'estado'
    ];

    /**
     * Relación con las asignaciones de viajes
     */
    public function asignaciones()
    {
        return $this->hasMany(Asignacion::class, 'id_empleado');
    }
}