<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model
{
    use HasFactory;

    protected $table = 'MANTENIMIENTO';
    protected $primaryKey = 'id_mantenimiento';
    public $timestamps = false;

    protected $fillable = [
        'id_bus',
        'id_tipo_mant',
        'id_empleado',
        'fecha',
        'costo',
        'descripcion',
        'estado'
    ];

    public function bus() {
        return $this->belongsTo(Bus::class, 'id_bus');
    }

    public function tipoMantenimiento() {
        return $this->belongsTo(TipoMantenimiento::class, 'id_tipo_mant');
    }

    public function empleado() {
        return $this->belongsTo(Empleado::class, 'id_empleado');
    }
}