<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model
{
    use HasFactory;

    protected $table = 'METODO_PAGO';
    protected $primaryKey = 'id_metodo_pago';
    public $timestamps = false;

    protected $fillable = [
        'descripcion'
    ];

    /**
     * Relación con las facturas emitidas
     */
    public function facturas()
    {
        return $this->hasMany(Factura::class, 'id_metodo_pago');
    }
}