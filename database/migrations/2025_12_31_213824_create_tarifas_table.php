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
        Schema::create('tarifas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cancha_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('dia_semana'); // 0 = domingo
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->decimal('precio', 8, 2);
            $table->timestamps();
        });
        
        $table->unique([
            'cancha_id',
            'dia_semana',
            'hora_inicio',
            'hora_fin'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarifas');
    }
};
