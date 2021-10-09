<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLamparasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lamparas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('lampara',12)->unique()->nullable(false);
            $table->boolean('estado')->nullable(false);
            $table->integer('contenedor_id')->unsigned()->nullable(false);
            $table->foreign('contenedor_id')->references('id')->on('contenedores');
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
        Schema::dropIfExists('lamparas');
    }
}
