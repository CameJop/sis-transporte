<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

    protected $table = 'Rol';
    protected $primaryKey = 'id_rol';
    public $timestamps = false;

    protected $fillable = ['nombre'];

    /**
     * Relación con usuarios (si decides implementarlos luego)
     */
    public function usuarios()
    {
        return $this->hasMany(User::class, 'id_rol');
    }
}