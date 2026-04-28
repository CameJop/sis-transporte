<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleFactura extends Model
{
    use HasFactory;

    protected $table = 'DETALLE_FACTURA';
    protected $primaryKey = 'id_detalle';
    public $timestamps = false;

    protected $fillable = [
        'id_factura',
        'tipo',
        'id_referencia',
        'monto'
    ];

    /**
     * Relación con la cabecera de la factura
     */
    public function factura()
    {
        return $this->belongsTo(Factura::class, 'id_factura');
    }

    /**
     * Relación polimórfica manual: Obtener el objeto referenciado (Boleto o Encomienda)
     */
    public function getReferenciaAttribute()
    {
        if ($this->tipo === 'BOLETO') {
            return Boleto::find($this->id_referencia);
        }
        // Asumiendo que existe el modelo Encomienda
        return Encomienda::find($this->id_referencia);
    }
}