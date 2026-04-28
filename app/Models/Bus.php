<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;

    protected $table = 'BUS';
    protected $primaryKey = 'id_bus';
    public $timestamps = false;

    protected $fillable = [
        'placa',
        'capacidad',
        'estado'
    ];

    public function viajes()
    {
        return $this->hasMany(Viaje::class, 'id_bus');
    }
}