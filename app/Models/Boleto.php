<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boleto extends Model
{
    use HasFactory;

    protected $table = 'BOLETO';
    protected $primaryKey = 'id_boleto';
    public $timestamps = false; // Usamos el default de la DB para fecha_compra

    protected $fillable = [
        'id_viaje',
        'id_cliente',
        'asiento',
        'precio',
        'fecha_compra'
    ];

    public function viaje()
    {
        return $this->belongsTo(Viaje::class, 'id_viaje');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }
}