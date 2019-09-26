<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequisicaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisicaos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_requisitante')->unsigned();
            $table->foreign('id_requisitante')->references('id')->on('users')->onDelete('cascade');
            $table->integer('id_secretario')->unsigned()->nullable();
            $table->foreign('id_secretario')->references('id')->on('users')->onDelete('cascade');
            $table->string('titulo');
            $table->text('descricao');
            $table->enum('status', ['Pendente', 'Confirmada', 'Negada']);
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
        Schema::dropIfExists('requisicaos');
    }
}
