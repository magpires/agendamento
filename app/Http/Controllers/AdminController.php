<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function index() {
        if(Auth::user()->tipo == 'Secretário') {
            $users = User::query()
                ->orderBy('name')
                ->where('users.id', '!=', Auth::user()->id)
                ->get(['users.id',
                        'users.name',
                        'users.sobrenome',
                        'users.tipo',
                        'users.created_at']);

            $orientadores = User::query()
                        ->where('users.tipo', 'Orientador')
                        ->orderBy('name')
                        ->orderBy('sobrenome')
                        ->get(['users.name',
                                'users.sobrenome',
                                'users.id']);

        return view('listausuarios', compact('users', 'orientadores'));
        } else {
            return redirect('home');
        }
    }

    public function cadastraUsuario(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:191',
                'sobrenome' => 'required|string|max:191',
                'telefone' => 'required|unique:users|string|min:14|max:15',
                'rm' => 'required|string|min:10|max:10|unique:users',
                'tipo' => 'required|string',
                'email' => 'required|string|email|max:255|unique:users',
                'curso' => 'required|string|sometimes',
                'disciplina' =>'required|string|sometimes',
                'orientador' => 'required|string|sometimes',
                'password' => 'required|string|min:6|confirmed',
            ]);

            // se o validator falhar, a gente joga os erros devolvidos pelo Validator de volta para nossa view.
            if ($validator->fails()) {
                return redirect()->back()
                                ->with('erroCadastro', '') //É retornado para a view saber qual modal deve ser
                                                            //exibido
                                ->withErrors($validator)
                                ->withInput();
            }

            //Se ao registrar o usuário e por algum motivo ele consiga passar um ID
            //inválido para um orientador, o cadastro é interrompido e uma mensagem de erro
            //é exibida
            if($request['disciplina'] == 'TCC II') {
                $orientador = User::findOrFail($request['orientador']);

                //Se ao registrar o usuário e por algum motivo ele consiga passar um ID
                //de um usuário que não seja um orientador, o sistema retorna para a página
                //de cadastro informando o erro ocorrido
                if ($orientador->tipo != 'Orientador') {
                    return redirect()->back()->with('error', "O id do usuário informado não pertence a um orientador.");
                }
            }
            
            //Cria usuario no banco
            User::create([
                'name' => $request['name'],
                'sobrenome' => $request['sobrenome'],
                'telefone' => $request['telefone'],
                'rm' => $request['rm'],
                'tipo' => $request['tipo'],
                'email' => $request['email'],
                'curso' => $request['curso'],
                'disciplina' => $request['disciplina'],
                'orientador' => $request['orientador'],
                'password' => Hash::make($request['password']),
            ]);

            return redirect()->back()->with('message', "Usuário cadastrado com sucesso!");;  
            
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', "O sistema encontrou um erro grave ao executar sua ação. 
                                                            Por favor, tente novamente.");
        }
    }

    public function infoUsuario($id) {
        //Auxiliar para ajudar a avaliar se o usuário tem um orientador para exibirmos seu nome nos
        //dados do aluno
        $aux = User::findOrFail($id);
        
        if($aux->id_orientador == null) {
            $usuario = User::query()
                        ->where('users.id', $id)
                        ->firstOrFail(['users.id',
                                        'users.name',
                                        'users.sobrenome',
                                        'users.telefone',
                                        'users.rm',
                                        'users.tipo',
                                        'users.email',
                                        'users.curso',
                                        'users.disciplina',
                                        'users.reunioes_agendadas',
                                        'users.em_espera']);
        } else {
            $usuario = User::query()
                        ->join('users AS orientador', 'users.id_orientador', 'orientador.id')
                        ->where('users.id', $id)
                        ->firstOrFail(['users.id',
                                        'users.name',
                                        'users.sobrenome',
                                        'users.telefone',
                                        'users.rm',
                                        'users.tipo',
                                        'users.email',
                                        'users.curso',
                                        'users.disciplina',
                                        'users.reunioes_agendadas',
                                        'users.em_espera',
                                        'orientador.id AS orientador_id',
                                        'orientador.name AS orientador_name',
                                        'orientador.sobrenome AS orientador_sobrenome']);
        }

        return $usuario;
    }

    public function atualizaUsuario(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'tipo' => 'required|string',
                'curso' => 'required|string|sometimes',
                'disciplina' =>'required|string|sometimes',
                'orientador' => 'required|string|sometimes',
                'zerarReuniao' => 'required|sometimes',
                'zerarEmEspera' => 'required|sometimes',
                'inptReunioes_agendadas' => 'required|numeric|sometimes',
                'inptEm_espera' => 'required|numeric|sometimes',
            ]);
    
            // se o validator falhar, a gente joga os erros devolvidos pelo Validator de volta para nossa view.
            if ($validator->fails()) {
                return redirect()->back()
                                ->with('erroUpdate', '') //É retornado para a view saber qual modal deve ser
                                                            //exibido
                                ->withErrors($validator)
                                ->withInput();
            }
    
            //Vamos preparar os dados para serem inseridos no update
            $curso = $request['curso'];
            $disciplina = $request['disciplina'];
            $id_orientador = $request['orientador'];
            $reunioes_agendadas = $request['inptReunioes_agendadas'];
            $em_espera = $request['inptEm_espera'];
    
            if($request['disciplina'] == 'TCC I') {
                $id_orientador = null;
            }
            
            if($request['zerarReuniao'] == 'sim') {
                $reunioes_agendadas = 0;
            }
    
            if($request['zerarEmEspera'] == 'sim') {
                $em_espera = 0;
            }
    
            if($request['tipo'] != 'Aluno') {
                $curso = null;
                $disciplina = null;
                $id_orientador = null;
                $reunioes_agendadas = 0;
                $em_espera = 0;
            }
    
            User::findOrFail($request['id'])
                ->update([
                    'tipo' => $request['tipo'],
                    'curso' => $curso,
                    'disciplina' => $disciplina,
                    'id_orientador' => $id_orientador,
                    'reunioes_agendadas' => $reunioes_agendadas,
                    'em_espera' => $em_espera,
                ]);
    
            return redirect()->back()->with('message', "Usuário atualizado com sucesso!");
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', "O sistema encontrou um erro grave ao executar sua ação. 
                                                            Por favor, tente novamente.");
        }
    }

    public function delete(Request $request) {
        //Antes de fechar um horário, verificamos se o usuário é um secretário
        if(Auth::user()->tipo != 'Secretário') {
            return redirect()->back()->with('error', "Você não tem permissão para fazer esta operação");
        }

        User::destroy($request['id']);
        return redirect()->back()->with('message', "Usuário excluido com sucesso.");
    }
}
