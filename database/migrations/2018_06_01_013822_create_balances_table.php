<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balances', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();//chave primária
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');//chave primária, deleta de todas a tabelas
            $table->double('amount',10 , 2)->default(0);//total usuário, passo o valor 0 padrão
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('balances');
    }
}
