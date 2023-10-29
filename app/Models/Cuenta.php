<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cuenta extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre', 
        'saldoActual', 
        'fecha', 
        'concepto', 
        'icono', 
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function movimientos()
    {
        return $this->hasMany(Movimiento::class);
    }
}
