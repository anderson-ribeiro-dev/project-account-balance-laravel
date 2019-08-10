@extends('adminlte::page')

@section('title', 'Nova Recarga')

@section('content_header')
    <h1>Fazer Recarga</h1>
    <!--migalhas de pão-->
    <ol class="breadcrumb">
        <li><a href="">Dashboard</a></li>
        <li><a href="">Saldo</a></li>
        <li><a href="">Depositar</a></li>
        
     </ol>
@stop

@section('content')
<div class="box">
        <div class="box-header">
            <h3>Fazer Recarga</h3>                
        </div>
        <div class="box-body">
             <!--mensagem de erro, só exibe  caso tenha com any-->
            @include('admin.includes.alerts')
        <form method="POST" action="{{ route('deposit.store')}}">
            {!! csrf_field() !!}<!--deixar o token oculto-->
                <div class="form-group">
                    <input type="text" name="value" placeholder="Valor Recarga" class="form-control">
                </div>
                <div class="form-group">
                        <button type="submit"class="btn btn-success">Recarregar</button>
                </div>
            </form>
        </div>
    </div>
@stop