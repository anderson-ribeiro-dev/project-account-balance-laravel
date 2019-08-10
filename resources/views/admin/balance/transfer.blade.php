@extends('adminlte::page')

@section('title', 'Transferir Saldo')

@section('content_header')
    <h1>Transferência</h1>
    <!--migalhas de pão-->
    <ol class="breadcrumb">
        <li><a href="">Dashboard</a></li>
        <li><a href="">Saldo</a></li>
        <li><a href="">Transferir</a></li>
        
     </ol>
@stop

@section('content')
<div class="box">
        <div class="box-header">
            <h3>Transferir Saldo(Informe o Recebedor)</h3>                
        </div>
        <div class="box-body">
             <!--mensagem de erro, só exibe  caso tenha com any-->
            @include('admin.includes.alerts')
        <form method="POST" action="{{ route('confirm.transfer')}}">
            {!! csrf_field() !!}<!--deixar o token oculto-->
                <div class="form-group">
                    <input type="text" name="sender" placeholder="Informação de quem vai receber o saque(Nome ou E-mail)" class="form-control">
                </div>
                <div class="form-group">
                        <button type="submit"class="btn btn-success">Próxima Etapa</button>
                </div>
            </form>
        </div>
    </div>
@stop