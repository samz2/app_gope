<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {
            // eliminar foreign key
            $table->dropForeign(['provincia_id']);
            // eliminar columna
            $table->dropColumn('provincia_id');
        });
    }

    public function down()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->foreignId('provincia_id')
                ->nullable()
                ->constrained('provincias');
        });
    }
};
