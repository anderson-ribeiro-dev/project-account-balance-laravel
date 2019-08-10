@extends('site.layouts.app')

@section('title', 'Meu Perfil')


@section('content')
    <h1>Meu Perfil</h1>
    <form action="">
        <div class="form-group">
            <label for="name">Nome</label>
            <input type="text" name="name" placeholder="Nome" class="form-control">
        </div>
        <div class="form-group">
            <label for="email">Email</label>            
            <input type="email" name="email" placeholder="E-mail" class="form-control">
        </div>
        <div class="form-group">
             <label for="password">Senha</label>            
            <input type="password" name="password" placeholder="Senha" class="form-control">
        </div>
        <div class="form-group">
            <label for="image">Imagem</label>           
            <input type="file" name="image" class="form-control">
        </div>
        <div class="form-group">           
            <button type="submit" class="btn btn-info">Atualizar Perfil</button>
        </div>
        
    </form>
@endsection