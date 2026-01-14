<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    // database/migrations/xxxx_remove_dep_prov_from_clientes_table.php
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropColumn(['departamento_id', 'provincia_id']);
        });
    }

    public function down()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->unsignedBigInteger('departamento_id')->nullable();
            $table->unsignedBigInteger('provincia_id')->nullable();
        });
    }
};
