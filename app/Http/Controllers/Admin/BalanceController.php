<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Http\Requests\MoneyValidationFormRequest;
use App\User;
use App\Models\Historic;


class BalanceController extends Controller
{
    private $totalpage = 5;//total de página


    //boleto externo implementar classe
    //exibir o saldo do usuário
    public function index(){
        //dd( auth()->user()->name);//fazer debug, pegar os dados do usuário
        //dd( auth()->user()->balance;//registro do balance, histórico financeira
        $balance = auth()->user()->balance;//passa o valor na variável
        $amount = $balance ? $balance->amount : 0; //saldo atual do usuário, teste se(saldo)senão(0)
        return view('admin.balance.index', compact('amount'));//passa para view, saldo atual
        
    }

    //método deposito
    public function deposit(){
        return view('admin.balance.deposit');
    }

    //método recarga, passando parametro,classe de validação
    public function depositStore(MoneyValidationFormRequest $request){
        //dd($request->all());//debug
        
        $balance = auth()->user()->balance()->firstOrCreate([]);//se existe retorna,senão(cria)
        $response = $balance->deposit($request->value);//pegar valor, mostrar na tela
        //rota se caso inserir com sucesso 
        if($response['success'])
        //se
          return redirect()
            ->route('admin.balance')
            ->with('success', $response['message']);//passa mensagem
          //senão
          return redirect() 
            ->back()
            ->with('error', $response['message']);
          
    }


    public function withdraw(){
        return view('admin.balance.withdraw');
    } 


    //método de saque
    public function withdrawStore(MoneyValidationFormRequest $request){
        //dd($request->all());//debug
        
        $balance = auth()->user()->balance()->firstOrCreate([]);//se existe retorna,senão(cria)
        $response = $balance->withdraw($request->value);//pegar valor, mostrar na tela
        //rota se caso inserir com sucesso 
        if($response['success'])
        //se
          return redirect()
            ->route('admin.balance')
            ->with('success', $response['message']);//passa mensagem
          //senão
          return redirect() 
            ->back()
            ->with('error', $response['message']);
          
    }

    //método transferência
    public function transfer(){
        return view('admin.balance.transfer');
    }
    //metodo de transferência
    public function confirmTransfer(Request $request, User $user){
        //dd($request->all());
        //dd($sender);
        //verifica se há usuário ou senão 
        if(!$sender = $user->getSender($request->sender))//recuperar o usuário
            return redirect()
                   ->back()
                   ->with('error', 'Usuário informado não encontrado!'); 

        //verifica se o usuário está transferindo para ele mesmo 
        if($sender->id === auth()->user()->id)           
                return redirect()
                    ->back()
                    ->with('error', 'Não pode transferir para você mesmo!'); 

         //mostar o saldo do usuário logado
         $balance = auth()->user()->balance;           


        return view('admin.balance.transfer-confirm', compact('sender', 'balance'));//view de confirmação           
    }

    //método confirmação de transferência 
    public function transferStore(MoneyValidationFormRequest $request,User $user){
       // dd($request->all());
       //recuperar o usuário pelo id, se existir retorna
       if(!$sender = $user->find($request->sender_id))
                return redirect()
                    ->route('balance.transfer')
                    ->with('success', 'Recebedor não encontrado');//passa mensagem
   

        $balance = auth()->user()->balance()->firstOrCreate([]);//se existe retorna,senão(cria)
        $response = $balance->transfer($request->value, $sender);//pegar valor, mostrar na tela, passando o usuário que irá receber
        //rota se caso inserir com sucesso 
        if($response['success'])
        //se
          return redirect()
            ->route('admin.balance')
            ->with('success', $response['message']);//passa mensagem
          //senão
          return redirect() 
            ->route('balance.transfer')
            ->with('error', $response['message']);
    }

    //rota historicos
    public function historic(Historic $historic){
         //dd($historics);
        //recuperar os dados do usuário logado,with(['user'])facilitar consulta do bd
        $historics = auth()->user()
                           ->historics()
                           ->with(['userSender'])
                           ->paginate($this->totalpage);
       

        $types = $historic->type();//passa o type para views(filtro)                   
        //passa o historico pela view 
        return view('admin.balance.historics', compact('historics', 'types'));
    }
    //metodo de filtro
    public function searchHistoric(Request $request, Historic $historic){
        $dataForm = $request->except('_token');

        //passa o itens do filtro
        $historics = $historic->search($dataForm, $this->totalpage);
        $types = $historic->type();//recupera os tipos 
         //passa o historico pela view 
         return view('admin.balance.historics', compact('historics', 'types', 'dataForm'));
    }
}
