<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneradoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generadores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('generador',12)->unique()->nullable(false);
            $table->boolean('estado')->nullable(false);
            $table->integer('contador')->nullable(false);
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
        Schema::dropIfExists('generadores');
    }
}
