<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;

class CuentaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cuentas')->insert([
            [
                'id'=>1,
                'nombre'=>'Familiar',
                'saldoActual'=>976,
                'fecha'=> '2023-08-07',
                'icono'=>'',
                'user_id' => 1
            ],
        ]);
    }
}
