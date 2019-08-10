@extends('adminlte::page')

@section('title', 'Saldo')

@section('content_header')
    <h1>Saldo</h1>
    <!--migalhas de pão-->
    <ol class="breadcrumb">
        <li><a href="">Dashboard</a></li>
        <li><a href="">Saldo</a></li>
    </ol>
@stop

@section('content')
    <div class="box">
        <div class="box-header">
        <a href="{{ route('balance.deposit') }}" class="btn btn-primary"><i class="fa fa-cart-plus" arial-hidden="true"></i>Recarregar</a>
        
        <!--só exixibi se for maior que zero-->
        @if($amount > 0)
            <a href="{{route('balance.withdraw')}}" class="btn btn-danger"><i class="fa fa-cart-arrow-down" arial-hidden="true"></i>Sacar</a>
         @endif

         @if($amount > 0)
            <a href="{{route('balance.transfer')}}" class="btn btn-info"><i class="fa fa-exchange" arial-hidden="true"></i>Transação</a>
        @endif
                        
        </div>
        <div class="box-body">
              <!--mensagem de erro, só exibe  caso tenha com any-->
              @include('admin.includes.alerts')
              
            <div class="small-box bg-green">
                <div class="inner">
                    <!--passa o saldo-->
                  <h3>R$ {{ number_format($amount, 2, ',', '') }} </h3>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">Histórico<i class="fa fa-arrow-circle-right"></i></a>
              </div>
        </div>
    </div>

@stop