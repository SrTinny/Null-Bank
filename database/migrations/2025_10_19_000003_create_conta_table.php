<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContaTable extends Migration
{
    public function up()
    {
        Schema::create('conta', function (Blueprint $table) {
            $table->integer('numero')->primary();
            $table->decimal('saldo', 10, 2)->default(0.00);
            $table->unsignedInteger('agencia_id');
            $table->unsignedInteger('funcionario_matricula');
            $table->timestamps();

            $table->foreign('agencia_id')->references('id')->on('agencia')->onUpdate('cascade');
            $table->foreign('funcionario_matricula')->references('matricula')->on('funcionario')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('conta');
    }
}
