<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('name');
            $table->string('sobrenome');
            $table->string('rm', 10)->unique();
            $table->string('telefone', 15)->unique();
            $table->string('curso')->nullable();
            $table->enum('disciplina', ['TCC I', 'TCC II'])->nullable();
            $table->integer('id_orientador')->unsigned()->nullable();
            $table->foreign('id_orientador')->references('id')->on('users')->onDelete('cascade');
            $table->integer('reunioes_agendadas')->default(0);
            $table->boolean('em_espera')->default(false);
            $table->enum('tipo', ['Aluno', 'Orientador', 'Secretário']);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
