<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
      $this->call(UserSeeder::class);
      $this->call(EstadoMovimientoSeeder::class);
      $this->call(TipoMovimientoSeeder::class);
      $this->call(CategoriaSeeder::class);
      $this->call(CuentaSeeder::class);
         


       //  \App\Models\Categoria::factory()->create([
         //    'name' => 'Test User',
           //  'email' => 'test@example.com',
         //]);
    }
}
