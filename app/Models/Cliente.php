<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'CLIENTE';
    protected $primaryKey = 'id_cliente';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'documento_identidad',
        'telefono',
        'email'
    ];

    /**
     * Un cliente puede comprar muchos boletos
     */
    public function boletos()
    {
        return $this->hasMany(Boleto::class, 'id_cliente');
    }

    /**
     * Un cliente puede tener muchas facturas
     */
    public function facturas()
    {
        return $this->hasMany(Factura::class, 'id_cliente');
    }
}