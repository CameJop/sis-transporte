<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encomienda extends Model
{
    use HasFactory;

    protected $table = 'ENCOMIENDA';
    protected $primaryKey = 'id_encomienda';
    public $timestamps = false;

    protected $fillable = [
        'id_viaje',
        'id_cliente_remitente',
        'id_cliente_destinatario',
        'peso',
        'estado',
        'fecha_envio'
    ];

    public function viaje() {
        return $this->belongsTo(Viaje::class, 'id_viaje');
    }

    public function remitente() {
        return $this->belongsTo(Cliente::class, 'id_cliente_remitente');
    }

    public function destinatario() {
        return $this->belongsTo(Cliente::class, 'id_cliente_destinatario');
    }
}