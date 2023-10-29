<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            $table->string('concepto');
            $table->date('fecha');
            $table->bigInteger('importe');
            $table->foreignId("estado_movimiento_id")->constrained('estado_movimiento')->nullable()->cascadeOnDelete();
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade');
            $table->unsignedBigInteger('subcategoria_id')->nullable();
            $table->foreign('subcategoria_id')->references('id')->on('subcategorias')->onDelete('cascade');
            $table->foreignId("cuenta_id")->constrained('cuentas')->cascadeOnDelete();
            $table->foreignId("user_id")->constrained('users')->cascadeOnDelete();
            $table->foreignId("tipo_movimiento_id")->constrained('tipo_movimiento')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimiento');
    }
};
