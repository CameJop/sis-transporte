<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoMantenimiento extends Model
{
    use HasFactory;

    protected $table = 'TIPO_MANTENIMIENTO';
    protected $primaryKey = 'id_tipo_mant';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion'
    ];

    /**
     * Relación con los registros de mantenimiento
     */
    public function mantenimientos()
    {
        return $this->hasMany(Mantenimiento::class, 'id_tipo_mant');
    }
}