<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallesContenedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles_contenedores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contenedor_id')->unsigned()->nullable(false);
            $table->foreign('contenedor_id')->references('id')->on('contenedores');
            $table->date('fecha')->nullable(false);
            $table->double('energia_consumida')->nullable(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalles_contenedores');
    }
}
