<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boleto extends Model
{
    use HasFactory;

    protected $table = 'BOLETO';
    protected $primaryKey = 'id_boleto';
    
    // Como tu SQL tiene DEFAULT CURRENT_TIMESTAMP, 
    // si no tienes updated_at, puedes desactivar timestamps o manejarlos así:
    public $timestamps = false;

    protected $fillable = [
        'id_viaje',
        'id_cliente',
        'asiento',
        'precio',
        'fecha_compra'
    ];

    /**
     * Relación con el Viaje
     */
    public function viaje()
    {
        return $this->belongsTo(Viaje::class, 'id_viaje');
    }

    /**
     * Relación con el Cliente
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }
}