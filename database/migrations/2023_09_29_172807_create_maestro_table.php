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
        Schema::create('maestro', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->string('jpp', 3)->nullable();
            $table->string('clave', 9)->nullable();
            $table->integer('num')->nullable();
            $table->string('rfc', 13)->nullable();
            $table->string('nombre', 250)->nullable();
            $table->date('fnacimien')->nullable();
            $table->string('categ', 50)->nullable();
            $table->string('curp', 21)->nullable();
            $table->string('sexo', 1)->nullable();
            $table->string('proyecto', 20)->nullable();
            $table->string('domicilio', 500)->nullable();
            $table->integer('codigop')->nullable();
            $table->string('telefono', 60)->nullable();
            $table->string('imss', 30)->nullable();
            $table->date('fching')->nullable();
            $table->string('nivel', 30)->nullable();
            $table->string('nomelec', 1)->nullable();
            $table->string('leyen', 250)->nullable();
            $table->string('tiporel', 25)->nullable();
            $table->string('superviven', 1)->nullable();
            $table->string('dire_super', 1)->nullable();
            $table->date('fsupervive')->nullable();
            $table->string('cuentabanc', 35)->nullable();
            $table->string('banco', 15)->nullable();
            $table->string('tipopen', 50)->nullable();
            $table->string('rfc_homo', 13)->nullable();
            $table->string('nosuspen', 25)->nullable();
            $table->date('fechasus')->nullable();
            $table->date('fechaeje')->nullable();
            $table->text('fcapsus')->nullable();
            $table->date('fcedula')->nullable();
            $table->integer('anios')->nullable();
            $table->integer('meses')->nullable();
            $table->integer('quinquenios')->nullable();
            $table->text('f_baja')->nullable();
            $table->string('motivo', 100)->nullable();
            $table->integer('ley')->nullable();
            $table->string('usuario_sis', 13)->nullable();
            $table->text('f_captura')->nullable();
            $table->string('cve_reg', 2)->nullable();
            $table->string('cve_dto', 2)->nullable();
            $table->string('cve_mun', 3)->nullable();
            $table->string('cve_loc', 4)->nullable();
            $table->string('correo', 100)->nullable();
            $table->unsignedBigInteger('dias_aguinaldo')->nullable();
            $table->longText('huella')->nullable();
            $table->string('f_impresion', 255)->nullable();
            $table->text('num_susp_seguro')->nullable();
            $table->date('fec_susp_seguro')->nullable();
            $table->date('fec_susp_ejec')->nullable();
            $table->boolean('d_madres')->default(false);
            $table->text('llave_qr')->nullable();
            $table->boolean('demanda')->default(false);
            $table->boolean('retroactivo')->default(false);
            $table->boolean('is_fecha_sesion_confianza')->default(false);
            $table->date('fecha_sesion_confianza')->nullable();
            $table->text('proyectovictima')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maestro');
    }
};
