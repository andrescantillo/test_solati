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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('document')->unique()->comment('Numero de identificacion');
            $table->string('first_name')->comment('Primer nombre');
            $table->string('last_name')->nullable()->comment('Segundo nombre');
            $table->string('phone')->nullable()->comment('Telefono');
            $table->string('address')->nullable()->comment('Direccion');
            $table->date('birthday')->nullable();

            $table->unsignedBigInteger('id_companies')->comment('Id de la empresa');
            $table->foreign('id_companies')->references('id')->on('companies');

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
