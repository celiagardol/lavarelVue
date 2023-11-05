<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;


class TipoMovimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipo_movimiento')->insert([
            [
                "id"=>1,
                "nombre"=> "Ingreso"
            ],
            [
                "id"=>2,
                "nombre"=> "Gasto"
            ],
            [
                "id"=>3,
                "nombre"=> "Traspaso entre cuentas"
            ],
            [
                "id"=>4,
                "nombre"=> "Ajuste de cuentas"
            ]
        ]);
    }
}
