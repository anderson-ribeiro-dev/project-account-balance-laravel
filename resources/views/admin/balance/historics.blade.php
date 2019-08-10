@extends('adminlte::page')

@section('title', 'Histórico de Movimentações')

@section('content_header')
    <h1>Histórico de Movimentações</h1>
    <!--migalhas de pão-->
    <ol class="breadcrumb">
        <li><a href="">Dashboard</a></li>
        <li><a href="">Histórico </a></li>
    </ol>
@stop

@section('content')
    <div class="box">
        <div class="box-header">
            <!--formulário de pesquisa-->
            <form action="{{route('historic.search')}}" method="POST" class="form form-inline">
                {!! csrf_field() !!}<!--token-->
                <input type="text" name="id" class="form-control" placeholder="ID">
                <input type="date" name="date" class="form-control">
                <select name="type" class="form-control">
                    <option value="">--Selecione o Tipo--</option>
                    <!--passa o tipo através, recuperado pelo type(historics), posição e valor-->
                    @foreach ($types as $key => $type )
                      <option value="{{ $key }}">{{ $type }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">Pesquisar</button>
            </form>    
        </div>
        <div class="box-body">
            <!--tabela de historico-->
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                      <th>#</th>
                      <th>Valor</th>
                      <th>Tipo</th> 
                      <th>Data</th>
                      <th>?Sender?</th>  
                    </tr>
                </thead>
                <tbody>
                    @forelse($historics as $historic)
                        <tr>
                        <td>{{ $historic->id}}</td>
                        <td>{{ number_format($historic->amount, 2, ',', '.')}}</td>
                        <td>{{ $historic->type($historic->type) }}</td> 
                        <td>{{ $historic->date }}</td> 
                        <td>
                            
                           @if($historic->user_id_transaction)
                                <!--exibir o nome do usuário transação-->
                                {{ $historic->userSender->name }}
                           @else
                                -
                           @endif
                        
                        </td>  
                        </tr>
                    @empty
                    @endForelse    
                </tbody>
            </table>
            <!--paginação, manter a paginação -->
            @if(isset($dataForm))
                {!! $historics->appends($dataForm)->links() !!}
            @else
                {!! $historics->links() !!}
            @endif
        </div>
    </div>

@stop