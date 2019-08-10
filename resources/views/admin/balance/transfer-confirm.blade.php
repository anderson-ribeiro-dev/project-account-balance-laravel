@extends('adminlte::page')

@section('title', 'Confirmar Transferência Saldo')

@section('content_header')
    <h1>Confirmar Transferência</h1>
    <!--migalhas de pão-->
    <ol class="breadcrumb">
        <li><a href="">Dashboard</a></li>
        <li><a href="">Saldo</a></li>
        <li><a href="">Transferir</a></li>
        <li><a href="">Confirmação</a></li>
        
        
     </ol>
@stop

@section('content')
<div class="box">
        <div class="box-header">
            <h3>Confirmar Transferência Saldo</h3>                
        </div>
        <div class="box-body">
             <!--mensagem de erro, só exibe  caso tenha com any-->
            @include('admin.includes.alerts')
            <!--usuário que vai receber, nome-->
        <p><strong>Recebedor: </strong>{{ $sender->name }}</p>
        <p><strong>Seu Saldo Atual: </strong>{{ number_format($balance->amount, 2, ',', '') }}</p><!--saldo -->
        

        <form method="POST" action="{{ route('transfer.store')}}">
            {!! csrf_field() !!}<!--deixar o token oculto-->
        <!--valor do id(oculto)-->
        <input type="hidden" name="sender_id" value="{{ $sender->id }}">

                <div class="form-group">
                    <input type="text" name="value" placeholder="valor:" class="form-control">
                </div>
                <div class="form-group">
                        <button type="submit"class="btn btn-success">Transferir</button>
                </div>
            </form>
        </div>
    </div>
@stop