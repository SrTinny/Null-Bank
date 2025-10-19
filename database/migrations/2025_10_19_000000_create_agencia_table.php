<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgenciaTable extends Migration
{
    public function up()
    {
        Schema::create('agencia', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome', 100);
            $table->decimal('salario_montante_total', 10, 2)->default(0.00);
            $table->string('cidade', 45);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('agencia');
    }
}
