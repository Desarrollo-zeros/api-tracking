<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Personas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('identificacion', 191);
            $table->string('primerNombre', 191);
            $table->string('segundoNombre', 191);
            $table->string('primerApellido', 191);
            $table->string('segundoApellido', 191);
            $table->integer('userId')->unsigned();
            $table->foreign('userid')->references('id')->on("usuarios");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personas');
    }
}
