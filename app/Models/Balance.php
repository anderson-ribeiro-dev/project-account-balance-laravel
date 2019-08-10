<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use PhpParser\Node\Expr\Cast\Array_;
use App\User;

class Balance extends Model
{
  
    public $timestamps = false;//não trabalhar com created e update automático

    //pegar valor de recarga, retorna um array
    public function deposit(float $value) : Array
    {
        DB::beginTransaction();//inicia a transação
            
        //variável saldo anterior
        $totalBefore = $this->amount ? $this->amount :0;//passa zero por default


        //fazer recarga 
      $this->amount += number_format($value, 2, '.', '');//saldo atual do usuário(incrementando valor)
      $deposit = $this->save();//salvar valor, variável de retorno, variável deposito
      //pegar usuário logado, variável de retorno
       $historic = auth()->user()->historics()->create([
           //dados que podem ser inseridos
           'type'         => 'I',//entrada
           'amount'       => $value,//valor 
           'total_before' => $totalBefore,//total anterior
           'total_after'  => $this->amount, //próximo saldo
           'date'         => date('Ymd'),//ano,mês,dia

       ]); 


      if($deposit && $historic)
      {//se
        DB::commit();//insere os dois caso certo
        return[
            'success' => true,
            'message' => 'Sucesso ao fazer a retirada'
        ];
    }else{
        BD::roolback();//caso erro, volta ao estado anterior
        //senão
        return[
            'success' => false,
            'message' => 'Erro ao fazer retirada'
        ];


      } 


    }

    //método saque 
    public function withdraw(float $value) : Array
    {
        //verifica se há saldo suficiente 
        if($this->amount < $value)
            return [
                'success' => false,
                'message' => 'Saldo Insuficiente',
            ];

        DB::beginTransaction();//inicia a transação
            
        //variável saldo anterior
        $totalBefore = $this->amount ? $this->amount :0;//passa zero por default


        //fazer recarga 
      $this->amount -= number_format($value, 2, '.', '');//saldo atual do usuário(incrementando valor)
      $withdraw = $this->save();//salvar valor, variável de retorno
      //verificar se foi inserido com sucesso 
      //pegar usuário logado, variável de retorno
       $historic = auth()->user()->historics()->create([
           //dados que podem ser inseridos
           'type'         => 'O',//entrada
           'amount'       => $value,//valor 
           'total_before' => $totalBefore,//total anterior
           'total_after'  => $this->amount, //próximo saldo
           'date'         => date('Ymd'),//ano,mês,dia

       ]); 


      if($withdraw && $historic)
      {//se
        DB::commit();//insere os dois caso certo
        return[
            'success' => true,
            'message' => 'Saque com sucesso'
        ];
    }else{
        BD::roolback();//caso erro, volta ao estado anterior
        //senão
        return[
            'success' => false,
            'message' => 'Erro ao sacar'
        ];


      } 

    }

    //método transferência,passando objeto de usuário
    public function transfer(float $value, User  $sender) : Array
    {

         //verifica se há saldo suficiente 
         if($this->amount < $value)
         return [
             'success' => false,
             'message' => 'Saldo Insuficiente',
         ];

         DB::beginTransaction();//inicia a transação
         /********************************************************
          * Atualizar o próprio saldo
          ********************************************************/
        //variável saldo anterior
        $totalBefore = $this->amount ? $this->amount :0;//passa zero por default
       //fazer recarga 
       $this->amount -= number_format($value, 2, '.', '');//saldo atual do usuário(decrementando valor)
       $transfer = $this->save();//salvar valor, variável de retorno
       //verificar se foi inserido com sucesso 
       //pegar usuário logado, variável de retorno
        $historic = auth()->user()->historics()->create([
        //dados que podem ser inseridos
        'type'                => 'T',//entrada
        'amount'              => $value,//valor 
        'total_before'        => $totalBefore,//total anterior
        'total_after'         => $this->amount, //próximo saldo
        'user_id_transaction' => $sender->id,//usuário que irá receber a transferência
        'date'                => date('Ymd'),//ano,mês,dia

    ]); 

        /********************************************************
          * Atualizar o saldo do recebedor
          ********************************************************/
        $senderBalance = $sender->balance()->firstOrCreate([]);//recuperar o saldo do usuário, criar registro com first 
        //variável saldo anterior
        $totalBeforeSender = $senderBalance->amount ? $senderBalance->amount :0;//retorna o próprio valor
        //fazer recarga 
        $senderBalance->amount += number_format($value, 2, '.', '');//saldo atual do usuário(incrementando valor)
        $transferSender = $senderBalance->save();//salvar valor, variável de retorno
        //verificar se foi inserido com sucesso 
        //pegar usuário logado, variável de retorno
        $historicSender = $sender->historics()->create([
        //dados que podem ser inseridos
        'type'                => 'I',//entrada
        'amount'              => $value,//valor 
        'total_before'        => $totalBeforeSender,//total anterior
        'total_after'         => $senderBalance->amount, //próximo saldo
        'user_id_transaction' => auth()->user()->id,//passa o id do usuário logado
        'date'                => date('Ymd'),//ano,mês,dia

    ]); 


        if($transfer && $historic && $transferSender && $historicSender)
        {//se
            DB::commit();//insere os dois caso certo
            return[
                'success' => true,
                'message' => 'Transferência com sucesso'
            ];
        }
            BD::roolback();//caso erro, volta ao estado anterior
            //senão
            return[
                'success' => false,
                'message' => 'Erro ao Transferir'
            ];

    }

}
