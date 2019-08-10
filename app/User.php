<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Balance;//chama a classe balace
use App\Models\Historic;//chama a classe histórico


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //método par balanço
    public function balance(){
        //relacionamento 1/1
        return $this->hasOne(Balance::class);
    }
    //método histórico 1/*
    public function historics(){
        //1 usuário e muito histórico
        return $this->hasMany(Historic::class);
    }

    //retorna o usuário da transferência, tosql(debuga querys)
    public function getSender($sender ){
        return $this->where('name', 'LIKE', "%$sender%")//pesquisar usuário
                    ->orWhere('email', $sender)//for igual ao email informado
                    ->get()//dados do usuário
                    ->first();//primeia ocorrência
    }
}
