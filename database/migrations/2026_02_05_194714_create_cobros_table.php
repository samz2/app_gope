<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cobros', function (Blueprint $table) {
            $table->id();

            // Relación con reserva
            $table->foreignId('reserva_id')
                ->constrained()
                ->cascadeOnDelete();

            // Datos del cobro
            $table->decimal('monto', 10, 2);
            $table->enum('metodo_pago', [
                'efectivo',
                'transferencia',
                'tarjeta',
                'yape',
                'plin'
            ])->nullable();

            // Estado
            $table->enum('estado', [
                'pendiente',
                'pagado',
                'anulado'
            ])->default('pendiente');

            // Fecha en que se pagó
            $table->timestamp('fecha_pago')->nullable();

            // Opcional: referencia o código de operación
            $table->string('referencia')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cobros');
    }
};
