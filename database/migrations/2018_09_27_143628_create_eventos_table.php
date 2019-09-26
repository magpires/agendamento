<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo');
            $table->integer('id_orientador')->unsigned();
            $table->integer('id_aluno')->unsigned();
            $table->integer('id_secretario')->unsigned();
            $table->foreign('id_orientador')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_aluno')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_secretario')->references('id')->on('users')->onDelete('cascade');
            $table->enum('status', ['Disponível', 'Em espera', 'Marcada', 'Concluída']);
            $table->integer('vezes_editado')->default(0);
            $table->dateTime('start');
            $table->dateTime('end');
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
        Schema::dropIfExists('eventos');
    }
}
