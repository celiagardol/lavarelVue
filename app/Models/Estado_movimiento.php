<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class estado_movimiento extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'icono'];

    public function movimientos()
    {
        return $this->hasMany(Movimiento::class, 'estado_movimiento_id');
    }
}
