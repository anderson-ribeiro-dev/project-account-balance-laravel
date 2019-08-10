<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\User;

class Historic extends Model
{
    //quais campos pode ser inseridos
    protected $fillable = ['type','amount','total_before','total_after','user_id_transaction', 'date'];

    //formatar o tipo
    public function type($type = null){
        //array com tipos
        $types = [
            'I' => 'Entrada',
            'O' => 'Saque',
            'T' => 'Transferência',
        ];

        //verifica se existe o tipo
        if(!$type)
            return $types;

            //verifica se foi feita uma transferência
            if($this->user_id_transaction != null && $type == 'I')
                return 'Recebido';

            return $types[$type];

    }
    //escopo global, para pegar id do usuário
    public function scopeUserAuth($query){

        return $query->where('user_id', auth()->user()->id);
    }


    //trás os usuário do histórico
    public function user(){
        //relacionamento inverso
        return $this->belongsTo(User::class);
    }
    //trás o usuário de transferência
    public function userSender(){
        //trás o id da transação
        return $this->belongsTo(User::class, 'user_id_transaction');
    }

    //método formatar data(mutator)
    public function getDateAttribute($value){

        return Carbon::parse($value)->format('d/m/y');
    }
    //criar o filtro 
    public function search(Array $data, $totalPage){
        //filtrar o historico, callback
        $historics = $this->where(function ($query) use ($data){
            //filtro id
            if(isset($data['id']))
                $query->where('id', $data['id']);
             //filtro data
            if(isset($data['date']))
                $query->where('date', $data['date']);
            //filtro data
            if(isset($data['type']))
                $query->where('type', $data['type']);    

        })
        ->userAuth()//pegar id
        //->where('user_id', auth()->user()->id)//passar o id do usuário logado
        ->with(['userSender'])//facilita consulta
        ->paginate($totalPage);//retorna os dados em si
        //->toSql();dd($historics);
        return $historics;
    }
}
