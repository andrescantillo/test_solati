<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('log_activities', function (Blueprint $table) {
        $table->increments('id');
        $table->string('subject')->comment('Asunto o titulo del mensaje');
        $table->enum('success', ["true", "false"])->nullable()->comment('Tipo de estado de actividad');
        $table->string('endpoint')->nullable()->comment('Nombre del endpoint');
        $table->string('method')->nullable()->comment('Metodo http');
        $table->string('url')->nullable()->comment('Url completa que proviene de los header de la peticion.(fullUrl)');;
        $table->text('values')->nullable()->comment('Los valorles que proviene del request de la peticion');
        $table->text('message')->nullable()->comment('Mensaje generado en el sistema');
        $table->string('ip')->nullable();
        $table->string('agent')->nullable()->comment('User-Agent que proviene de los header de la peticion');
        $table->integer('user_id')->nullable()->comment('Usuario que genero la actividad');
        $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_activities');
    }
};
