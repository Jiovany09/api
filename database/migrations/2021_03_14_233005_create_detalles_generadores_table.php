<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallesGeneradoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles_generadores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('generador_id')->unsigned()->nullable(false);
            $table->foreign('generador_id')->references('id')->on('generadores');
            $table->date('fecha')->nullable(false);
            $table->double('energia_producida')->nullable(false);
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
        Schema::dropIfExists('detalles_generadores');
    }
}
