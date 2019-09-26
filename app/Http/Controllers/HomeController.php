<?php

namespace App\Http\Controllers;

use App\Evento;
use App\User;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        if (Auth::user()->tipo == 'Aluno') {
            $eventos = Evento::query()
                ->join('users AS aluno', 'eventos.id_aluno', 'aluno.id')
                ->join('users AS orientador', 'eventos.id_orientador', 'orientador.id')
                ->join('users AS secretario', 'eventos.id_secretario', 'secretario.id')
                ->where('eventos.id_aluno', Auth::user()->id)
                ->get(['eventos.*',
                    'orientador.name AS orientador_name',
                    'orientador.sobrenome AS orientador_sobrenome',
                    'aluno.name AS aluno_name',
                    'aluno.sobrenome AS aluno_sobrenome',
                    'aluno.rm AS aluno_rm',
                    'secretario.name AS secretario_nome',
                    'secretario.sobrenome AS secretario_sobrenome',
                    'orientador.telefone AS orientador_telefone',
                    'aluno.telefone AS aluno_telefone',
                    'secretario.telefone AS secretario_telefone',
                    'aluno.curso AS aluno_curso',
                    'aluno.disciplina AS aluno_disciplina']);

            if(Auth::user()->disciplina == 'TCC I') {
                $orientadores = User::query()
                        ->where('users.tipo', 'orientador')
                        ->get();

                //Exibimos o calendário do usuário logado
                $meu_calendario = true;
                
                return view('home', compact('eventos', 'orientadores', 'meu_calendario'));
            }
        }

        if (Auth::user()->tipo == 'Orientador') {
            $eventos = Evento::query()
                ->join('users AS aluno', 'eventos.id_aluno', 'aluno.id')
                ->join('users AS orientador', 'eventos.id_orientador', 'orientador.id')
                ->join('users AS secretario', 'eventos.id_secretario', 'secretario.id')
                ->where('eventos.id_orientador', Auth::user()->id)
                ->get(['eventos.*',
                    'orientador.name AS orientador_name',
                    'orientador.sobrenome AS orientador_sobrenome',
                    'aluno.name AS aluno_name',
                    'aluno.sobrenome AS aluno_sobrenome',
                    'secretario.name AS secretario_nome',
                    'secretario.sobrenome AS secretario_sobrenome',
                    'orientador.telefone AS orientador_telefone',
                    'aluno.telefone AS aluno_telefone',
                    'secretario.telefone AS secretario_telefone',
                    'aluno.curso AS aluno_curso',
                    'aluno.disciplina AS aluno_disciplina']);
        }

        if (Auth::user()->tipo == 'Secretário') {
            return redirect(route('historicoreunioes'));
        }

        //Exibimos o calendário do usuário logado
        $meu_calendario = true;

        return view('home', compact('eventos', 'meu_calendario'));
    }
}
