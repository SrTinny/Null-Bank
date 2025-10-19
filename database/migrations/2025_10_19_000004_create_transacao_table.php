<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransacaoTable extends Migration
{
    public function up()
    {
        Schema::create('transacao', function (Blueprint $table) {
            $table->increments('numero');
            $table->enum('tipo', ['saque','deposito','pagamento','estorno','transferencia']);
            $table->dateTime('data_hora');
            $table->decimal('valor', 10, 2);
            $table->unsignedInteger('conta_numero');
            $table->unsignedInteger('conta_destino')->nullable();
            $table->timestamps();

            $table->foreign('conta_numero')->references('numero')->on('conta')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transacao');
    }
}
