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
       Schema::create('pagos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('reserva_id')
                ->constrained('reservas')
                ->onDelete('cascade');

            $table->decimal('monto', 8, 2);

            $table->enum('metodo', ['tarjeta', 'yape', 'plin', 'efectivo'])
                ->nullable();

            $table->enum('estado', ['pendiente', 'pagado', 'fallido', 'reembolsado'])
                ->default('pendiente');

            $table->string('referencia')->nullable();

            $table->timestamp('fecha_pago')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
