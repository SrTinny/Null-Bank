<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuncionarioTable extends Migration
{
    public function up()
    {
        Schema::create('funcionario', function (Blueprint $table) {
            $table->integer('matricula')->primary();
            $table->string('nome', 100);
            $table->string('senha', 255);
            $table->string('endereco', 255);
            $table->string('cidade', 45);
            $table->enum('cargo', ['gerente','atendente','caixa']);
            $table->enum('sexo', ['masculino','feminino']);
            $table->date('dt_nascimento');
            $table->decimal('salario', 10, 2);
            $table->unsignedInteger('agencia_id');
            $table->timestamps();

            $table->foreign('agencia_id')->references('id')->on('agencia')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('funcionario');
    }
}
