<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $table = 'factura';
    protected $primaryKey = 'id_factura';

    // Asegúrate de que estos campos estén en el fillable
    protected $fillable = [
        'id_cliente',
        'id_empleado',
        'id_metodo_pago',
        'fecha'
    ];

    // ESTA ES LA RELACIÓN QUE FALTA O ESTÁ MAL ESCRITA
    public function metodo_pago()
    {
        // Verifica que el modelo se llame 'MetodoPago' 
        // y que la llave foránea sea 'id_metodo_pago'
        return $this->belongsTo(MetodoPago::class, 'id_metodo_pago');
    }

    // Aprovecha de revisar que estas también existan:
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado');
    }
}