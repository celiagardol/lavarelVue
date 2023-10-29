<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class movimiento extends Model
{
    use HasFactory;
    protected $fillable = ['concepto', 'fecha', 'importe', 'estado_movimiento_id', 'categoria_id', 'subcategoria_id', 'cuenta_id', 'user_id'];

    public function estadoMovimiento()
    {
        return $this->belongsTo(EstadoMovimiento::class, 'estado_movimiento_id');
    }

    public function tipoMovimiento()
    {
        return $this->belongsTo(TipoMovimiento::class, 'tipo_movimiento_id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function subcategoria()
    {
        return $this->belongsTo(Subcategoria::class, 'subcategoria_id');
    }

    public function cuenta()
    {
        return $this->belongsTo(Cuenta::class, 'cuenta_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
