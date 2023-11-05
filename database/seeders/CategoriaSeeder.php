<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;


class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categorias')->insert([
            [
            'id' => 1,
            'nombre'=>'Egibide',
            'icon' => '',
            'user_id' => 1
        ],
        [
            'id' => 2,
            'nombre'=>'Supermercados',
            'icon' => '',
            'user_id' => 1
            
        ],
        [
            'id' => 3,
            'nombre'=>'Hogar',
            'icon' => '',
            'user_id' => 1
        ],
        [
            'id'=>4,
            'nombre'=>'Suministros',
            'icon' => '',
            'user_id' => 1
        ],
        [
            'id'=>5,
            'nombre'=>'Restaurantes',
            'icon' => '',
            'user_id' => 1
        ]
    ]); 
    }
}
