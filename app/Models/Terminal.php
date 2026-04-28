<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terminal extends Model
{
    use HasFactory;

    protected $table = 'TERMINAL';
    protected $primaryKey = 'id_terminal';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'ciudad'
    ];

    /**
     * Relación con las rutas donde esta terminal es origen
     */
    public function rutasOrigen()
    {
        return $this->hasMany(Ruta::class, 'id_origen');
    }

    /**
     * Relación con las rutas donde esta terminal es destino
     */
    public function rutasDestino()
    {
        return $this->hasMany(Ruta::class, 'id_destino');
    }
}