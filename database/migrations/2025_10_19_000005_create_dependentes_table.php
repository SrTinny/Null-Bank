<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDependentesTable extends Migration
{
    public function up()
    {
        Schema::create('dependentes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome', 100)->unique();
            $table->date('dt_nascimento');
            $table->enum('parentesco', ['filho','conjuge','genitor']);
            $table->integer('idade');
            $table->unsignedInteger('funcionario_matricula');
            $table->timestamps();

            $table->foreign('funcionario_matricula')->references('matricula')->on('funcionario')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('dependentes');
    }
}
