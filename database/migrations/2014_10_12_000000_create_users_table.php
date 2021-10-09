<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre')->nullable(false);
            $table->string('paterno')->nullable(false);
            $table->string('materno')->nullable(true);
            $table->string('email')->unique()->nullable(false);
            $table->string('tipo',15)->nullable(false);
            $table->string('telefono',11)->unique()->nullable(true);
            $table->string('password')->nullable(false);
            $table->string('clave',20)->unique()->nullable(true);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
