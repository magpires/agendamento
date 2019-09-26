<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Requisicao;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;


class RequisicaoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function criaRequisicao(Request $request) {
        try {
            if(Auth::user()->tipo == 'Orientador') {
                $validator = Validator::make($request->all(), [
                    'titulo' => 'required|string|max:191|',
                    'descricao' => 'required|string|',
                ]);
        
                if ($validator->fails()) {
                    return redirect()->back()
                        ->with('erroCadastro', '') //É retornado para a view saber qual modal deve ser
                                                            //exibido
                        ->withErrors($validator)
                        ->withInput();
                }
        
                Requisicao::create([
                    'id_requisitante' => Auth::user()->id,
                    'titulo' => $request['titulo'],
                    'descricao' => $request['descricao'],
                ]);
    
                return redirect()->back()->with('message', "Requisição cadastrada com sucesso. Para saber o status 
                                                            de sua requisição, acesse a página Histórico de 
                                                            Requisições.");
            } else {
                return redirect()->back()->with('error', "Você não tem permissão para fazer esta operação.");
            }
        } catch(\Exception $e) {
            $mensagem = 'O sistema encontrou um erro inesperado.';
            
            return redirect()->back()->with('error', $mensagem);
        }
    }

    public function historicoRequisicoes() {
        //Só o secretário poderá ver as requisições de todo mundo
        if(Auth::user()->tipo == 'Secretário') {
            $requisicoes = Requisicao::query()
                ->join('users AS requisitante', 'requisicaos.id_requisitante', 'requisitante.id')
                ->get(['requisicaos.*',
                    'requisitante.name AS requisitante_name',
                    'requisitante.sobrenome AS requisitante_sobrenome']);
        } else if(Auth::user()->tipo == 'Orientador') {
            $requisicoes = Requisicao::query()
                ->join('users AS requisitante', 'requisicaos.id_requisitante', 'requisitante.id')
                ->where('requisicaos.id_requisitante', Auth::user()->id)
                ->get(['requisicaos.*',
                    'requisitante.name AS requisitante_name',
                    'requisitante.sobrenome AS requisitante_sobrenome']); 
        } else {
            return redirect('home');
        }

        return view('historicorequisicoes', compact('requisicoes'));
    }

    public function infoRequisicao($id) {
        //Auxiliar para ajudar a avaliar se a requisição já foi atendida pelo secretário
        //para exibirmos o nome dele nos dados da requisição
        $aux = Requisicao::findOrFail($id);

        if($aux->id_secretario == null) {
            $requisicao = Requisicao::query()
                        ->join('users AS requisitante', 'requisicaos.id_requisitante', 'requisitante.id')
                        ->where('requisicaos.id', $id)
                        ->firstOrFail(['requisicaos.*',
                                        'requisitante.name AS requisitante_name',
                                        'requisitante.sobrenome AS requisitante_sobrenome']);
        } else {
            $requisicao = Requisicao::query()
                        ->join('users AS requisitante', 'requisicaos.id_requisitante', 'requisitante.id')
                        ->join('users AS secretario', 'requisicaos.id_secretario', 'secretario.id')
                        ->where('requisicaos.id', $id)
                        ->firstOrFail(['requisicaos.*',
                                        'requisitante.name AS requisitante_name',
                                        'requisitante.sobrenome AS requisitante_sobrenome',
                                        'secretario.name AS secretario_name',
                                        'secretario.sobrenome AS secretario_sobrenome']);
        }

        return $requisicao;
    }

    public function atualizaRequisicao(Request $request) {
        try {
            if(Auth::user()->tipo == 'Secretário') {
                $validator = Validator::make($request->all(), [
                    'status' => 'required|string|',
                ]);
        
                if ($validator->fails()) {
                    return redirect()->back()
                        ->with('erroUpdate', '') //É retornado para a view saber qual modal deve ser
                                                            //exibido
                        ->withErrors($validator)
                        ->withInput();
                }
    
                Requisicao::findOrFail($request['id'])
                    ->update([
                        'id_secretario' => Auth::user()->id,
                        'status' => $request['status'],
                    ]);
    
                return redirect()->back()->with('message', "Requisição atualizada com sucesso.");
            } else {
                return redirect()->back()->with('error', "Você não tem permissão para fazer esta operação.");
            }
        } catch(\Exception $e) {
            $mensagem = 'O sistema encontrou um erro inesperado.';
            
            return redirect()->back()->with('error', $mensagem);
        }
    }
}
