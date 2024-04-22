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
        Schema::create('respaldos_nominas', function (Blueprint $table) {
            $table->id('id');
            $table->string('rfc', 254)->nullable();
            $table->string('jpp', 254)->nullable();
            $table->integer('numjpp')->nullable();
            $table->integer('clave')->nullable();
            $table->integer('secuen')->nullable();
            $table->string('descri', 254)->nullable();
            $table->integer('pago4')->nullable();
            $table->string('pagot', 254)->nullable();
            $table->string('leyen', 254)->nullable();
            $table->date('fechaini')->nullable();
            $table->date('fechafin')->nullable();
            $table->string('nomelec', 254)->nullable();
            $table->string('supervive', 254)->nullable();
            $table->string('archivo', 254)->nullable();
            $table->string('tipo_nomina', 254)->nullable();
            $table->decimal('monto')->default(0);
            $table->string('tipo_pago', 255)->nullable();
            $table->integer('folio')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respaldos_nominas');
    }
};
