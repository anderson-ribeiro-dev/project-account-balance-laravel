<!--mensagem erro, caso inserido com sucesso-->
@if ($errors->any())
<div class="alert alert-warning">
    @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>  
    @endforeach
</div>
@endif
<!--verificar as mensagens error, success-->
@if (session('success'))
    <div class="alert alert-success">
        {{session('success')}}
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger">
        {{session('error')}}
    </div>
@endif