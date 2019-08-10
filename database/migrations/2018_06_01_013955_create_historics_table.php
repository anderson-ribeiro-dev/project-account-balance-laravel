<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoricsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historics', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();//chave primária
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');//chave primária, deleta de todas a tabelas    
            $table->enum('type', ['I', 'O', 'T']);//entrada/saida/transação
            $table->double('amount',10 ,2);//saldo atual
            $table->double('total_before',10 ,2);//saldo anterior
            $table->double('total_after',10 ,2);//próximo saldo
            $table->integer('user_id_transaction')->nullable();//transação opcional
            $table->date('date');
            $table->timestamps();//create e update automático, hora/data que foi inserido
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historics');
    }
}
