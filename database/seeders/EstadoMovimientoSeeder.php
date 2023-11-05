<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;


class EstadoMovimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('estado_movimiento')->insert([
            [
            'id' => 1,
            'nombre'=>'Pendiente',
            'icono' => ''
        ],
        [
            'id' => 2,
            'nombre' => 'Realizado',
            'icon0' => ''
        ]
    ]);
    }
}
