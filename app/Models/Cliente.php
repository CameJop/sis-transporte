<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'CLIENTE';
    protected $primaryKey = 'id_cliente';
    
    // Si tu tabla no tiene las columnas created_at/updated_at, usa false.
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'documento_identidad',
        'telefono',
        'email'
    ];

    /**
     * Relación: Un cliente puede comprar muchos boletos
     */
    public function boletos()
    {
        return $this->hasMany(Boleto::class, 'id_cliente');
    }

    /**
     * Relación: Un cliente puede enviar muchas encomiendas
     */
    public function encomiendasEnviadas()
    {
        return $this->hasMany(Encomienda::class, 'id_cliente_remitente');
    }
}