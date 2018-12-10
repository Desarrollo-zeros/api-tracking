<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Ubicaciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ubicaciones', function(Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id')->unsigned();
            $table->string('ip', 100);
            $table->string('ciudad', 100);
            $table->string('region', 255)->default(null);
            $table->string('region_code', 10);
            $table->string('pais', 255)->default(null);
            $table->string('pais_code', 10)->default(null);
            $table->string('contiente', 255)->default(null);
            $table->string('contiente_code', 255)->default(null);
            $table->string('latitud', 255)->default(null);
            $table->string('longitud', 255)->default(null);
            $table->string('exactitud', 255)->default(null);
            $table->string('moneda', 255)->default(null);
            $table->string('hora', 255)->default(null);
            $table->string('icono', 255)->default(null);
            $table->integer('codigo_telefono')->default(null);
            $table->string('codigo_postal', 255)->default(null);
            $table->integer('personId')->unsigned()->default(null);
            $table->foreign('personid')->references('id')->on('personas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ubicaciones');
    }
}
