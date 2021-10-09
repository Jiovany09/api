<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContenedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contenedores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('contenedor',13)->unique()->nullable(false);
            $table->boolean('estado')->nullable(false);
            $table->integer('contador')->nullable(false);
            $table->integer('generador_id')->unsigned()->nullable(false);
            $table->foreign('generador_id')->references('id')->on('generadores');
            $table->integer('empleado_id')->unsigned()->nullable(false);
            $table->foreign('empleado_id')->references('id')->on('users');
            $table->string('serial',50)->unique()->nullable(false);
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
        Schema::dropIfExists('contenedores');
    }
}
