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
        Schema::disableForeignKeyConstraints();

        // Si existe la columna dias, la eliminamos
        if (Schema::hasColumn('tarifas', 'dias')) {
            Schema::table('tarifas', function (Blueprint $table) {
                $table->dropColumn('dias');
            });
        }

        // Si existe dia_semana, la convertimos a JSON
        if (Schema::hasColumn('tarifas', 'dia_semana')) {
            DB::statement("ALTER TABLE tarifas MODIFY dia_semana JSON NULL");
        }

        Schema::enableForeignKeyConstraints();
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tarifas', function (Blueprint $table) {
            //
        });
    }
};
