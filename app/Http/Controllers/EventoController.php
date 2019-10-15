<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class EventoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //Função para converter as datas para o formato do banco
    public function converteData($data)
    {
        //Converter a data e hora do formato brasileiro para o formato do Bando de Dados
        $dataAux = explode(" ", $data);

        //Cria uma Array de datas
        list($dataAux, $hora) = $dataAux;

        //Inverter a data de DD/MM/YYY para YYY/MM/DD e tirar o "/" usando explode
        $data_invertida = array_reverse(explode("/", $dataAux));

        //Adicionar o "-" no Banco de Dados
        $data_invertida = implode("-", $data_invertida);

        //Adicionando a hora na nova variavel data
        $data_invertida = $data_invertida . " " . $hora;

        return $data_invertida;
    }

    //Função responsável por criar um horário disponível no calendário do professor.
    public function criaDisponibilidade(Request $request)
    {

        $orientador = User::findOrFail($request['id_orientador']);
        
        if (Auth::user()->tipo == 'Secretário') {

            //Verificamos se o orientador informado é realmente um orientador. Caso contrário,
            //retornamos uma mensagem de erro
            if($orientador->tipo != 'Orientador') {
                return redirect()->back()->with('error', "O usuário informado não é um orientador.");
            }

            $validator = Validator::make($request->all(), [
                'id_orientador' => 'required|',
                'start' => 'required|',
                'end' => 'required|',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->with('erroCadastro', '') //É retornado para a view saber qual modal deve ser
                                                            //exibido
                    ->withErrors($validator)
                    ->withInput();
            }

            //Converte as data inicial e final para o formato do banco
            $start_invertida = $this->converteData($request['start']);
            $end_invertida = $this->converteData($request['end']);

            Evento::create([
                'id_orientador' => $request['id_orientador'],
                'id_aluno' => $request['id_orientador'],
                'id_secretario' => Auth::user()->id,
                'titulo' => 'Disponível',
                'start' => $start_invertida,
                'end' => $end_invertida,
            ]);

            return redirect()->back()->with('message', "Disponibilidade cadastrada com sucesso");
        } else {
            return redirect()->back()->with('error', "Você não tem permissão para fazer esta operação.");
        }
    }

    //Função responsável por agendar ou alterar uma reunião com o professor
    public function agendaReuniao(Request $request)
    {       
        try {
            $mensagem; //É por ela que vamos informar ao usuário o que acontece no sistema

            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'titulo' => 'required|string|max:255|',
                'rm' => 'required|string|max:10|sometimes|',
                'novoStatus' => 'required|sometimes|',
                'start' => 'required|sometimes|',
                'end' => 'required|sometimes|',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->with('erroUpdate', '') //É retornado para a view saber qual modal deve ser
                                                            //exibido
                    ->withErrors($validator)
                    ->withInput();
            }

            //Converte as data inicial e final para o formato do banco
            $start_invertida = $this->converteData($request['start']);
            $end_invertida = $this->converteData($request['end']);

            //Somente secretários podem alterar a data de uma reunião ou de uma disponibilidade
            if (Auth::user()->tipo == 'Secretário') {
                $evento = Evento::findOrFail($request['id']);
                
                //Precisamos saber se o secretário está cadastrando uma reunião ou alterando o título de uma reunnião.
                //para não alterarmos seus campos "em_espera" e "reunioes_agendadas" quando ele apenas atualizar
                //o título de sua reunião.
                if($evento->status == 'Disponível') {
                    //Antes de agendar uma reunião, vamos procurar o aluno pelo seu RM
                    $aluno = User::query()
                            ->where('users.rm', $request['rm'])
                            ->first();

                    //Se o RM digitado for incorreto, falamos que o aluno não foi encontrado
                    if($aluno == null) {
                        $mensagem = 'Aluno não encontrado.';
                        return redirect()->back()->with('error', $mensagem);
                    }

                    //Antes de agendarmos a reunião do aluno, verificamos se ele já não 
                    //excedeu o limite máximo de agendamentos permitidos
                    if($aluno->reunioes_agendadas >= 2) {
                        $mensagem = 'O aluno informado não pode mais agendar reuniões, 
                                        pois ele excedeu o limite máximo de reuniões 
                                        marcadas.';
                        
                        return redirect()->back()->with('error', $mensagem);
                    }

                    //Verificamos também se ele já não está esperando pela primeira reunião.
                    //com o seu orientador. Caso ele já tenha uma reunião marcada, ele ficará
                    //impossibilitado de realizar a segunda reunião
                    if($aluno->em_espera) {
                        $mensagem = 'O aluno informado não pode agendar reuniões, pois 
                                        já existe uma reunião para ser realizada 
                                        em seu calendário.';

                        return redirect()->back()->with('error', $mensagem);
                    }

                    //Se o RM pertencer a um aluno que faz TCC II, vamos verificar primeiro se ele escolheu 
                    // o professor dono do calendário do qual o secretário está e deppis vamos retornar outra mensagem
                    //de erro, caso esse aluno não tenha escolhido este professor
                    if($aluno->disciplina == 'TCC II') {
                        if($aluno->id_orientador != $evento->id_orientador) {
                            $mensagem = 'O aluno informado faz a disciplina TCC II e 
                                            este não é o seu orientador.';
                            
                            return redirect()->back()->with('error', $mensagem);
                        }
                    }

                    //Quando o aluno agenda uma reunião, nós atualizamos sua quantidade
                    //de agendamentos feitos no sistema
                    $reunioes_agendadas = $aluno->reunioes_agendadas + 1;

                    Evento::findOrFail($request['id'])
                    ->update([
                        'titulo' => $request['titulo'],
                        'id_aluno' => $aluno->id,
                        'id_secretario' => Auth::user()->id,
                        'status' => "Em espera",
                    ]);

                    User::findOrFail($aluno->id)
                    ->update([
                        'reunioes_agendadas' => $reunioes_agendadas,
                        'em_espera' => true,
                    ]);

                    $mensagem = 'Reunião agendada com sucesso.';
                } else if($evento->status == 'Em espera' || $evento->status == 'Marcada') {
                    //Só vamos atualizar o status do evento caso ele seja informado
                    if($request['novoStatus'] == '') {
                        Evento::findOrFail($request['id'])
                        ->update([
                            'titulo' => $request['titulo'],
                            'start' => $start_invertida,
                            'end' => $end_invertida,
                        ]);
                    } else {
                        Evento::findOrFail($request['id'])
                        ->update([
                            'titulo' => $request['titulo'],
                            'status' => $request['novoStatus'],
                            'start' => $start_invertida,
                            'end' => $end_invertida,
                        ]);

                        $evento = Evento::findOrFail($request['id']);

                        if($request['novoStatus'] == 'Concluída') {
                            User::findOrFail($evento->id_aluno)
                            ->update([
                                'em_espera' => false,
                            ]);
                        }
                    }

                    $mensagem = 'Reunião alterada com sucesso.';
                } else {
                    $mensagem = 'Você está tentando alterar uma reunião já concluída.';
                    
                    return redirect()->back()->with('error', $mensagem);
                }
            } else if (Auth::user()->tipo == 'Aluno') {
                $evento = Evento::findOrFail($request['id']);
                
                //Precisamos saber se o usuário está cadastrando uma reunião ou alterando o título de uma reunnião.
                //para não alterarmos seus campos "em_espera" e "reunioes_agendadas" quando ele apenas atualizar
                //o título de sua reunião.
                if($evento->status == 'Disponível') {
                    //Antes de agendarmos a reunião do aluno, verificamos se ele já não 
                    //excedeu o limite máximo de agendamentos permitidos
                    if(Auth::user()->reunioes_agendadas >= 2) {
                        $mensagem = 'Você não pode mais agendar reuniões, pois excedeu o limite máximo de reuniões 
                                        marcadas.';
                        
                        return redirect()->back()->with('error', $mensagem);
                    }

                    //Verificamos também se ele já não está esperando pela primeira reunião.
                    //com o seu orientador. Caso ele já tenha uma reunião marcada, ele ficará
                    //impossibilitado de realizar a segunda reunião
                    if(Auth::user()->em_espera) {
                        $mensam = 'Você não pode agendar reuniões, pois já existe uma reunião para ser realizada 
                                    em seu calendário.';
                        
                        return redirect()->back()->with('error', $mensagem);
                    }

                    //Quando o aluno agenda uma reunião, nós atualizamos sua quantidade
                    //de agendamentos feitos no sistema
                    $reunioes_agendadas = Auth::user()->reunioes_agendadas + 1;
                    
                    Evento::findOrFail($request['id'])
                    ->update([
                        'titulo' => $request['titulo'],
                        'id_aluno' => Auth::user()->id,
                        'status' => "Em espera",
                    ]);

                    User::findOrFail(Auth::user()->id)
                    ->update([
                        'reunioes_agendadas' => $reunioes_agendadas,
                        'em_espera' => true,
                    ]);

                    $mensagem = 'Reunião agendada com sucesso.';
                } else if($evento->status == 'Em espera') {
                    Evento::findOrFail($request['id'])
                    ->update([
                        'titulo' => $request['titulo'],
                    ]);

                    $mensagem = 'Reunião alterada com sucesso.';
                } else {
                    $mensagem = 'Você está tentando alterar uma reunião já concluída';
                    
                    return redirect()->back()->with('error', $mensagem);
                }
            } else {
                $mensagem = 'Você não tem permissão para fazer esta operação';
                
                return redirect()->back()->with('error', $mensagem);
            }
            return redirect()->back()->with('message', $mensagem);
        } catch (\Exception $e) {
            $mensagem = 'O sistema encontrou um erro inesperado.';
            
            return redirect()->back()->with('error', $mensagem);
        }
    }

    //Mostra o calendário de todos os professores
    public function calendarioProfessores() {
        $orientadores = User::query()
                        ->where('users.tipo', 'Orientador')
                        ->orderBy('name')
                        ->orderBy('sobrenome')
                        ->get(['users.name',
                                'users.sobrenome',
                                'users.id']);
        
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
                    'secretario.name AS secretario_nome',
                    'secretario.sobrenome AS secretario_sobrenome',
                    'aluno.rm AS aluno_rm',
                    'orientador.telefone AS orientador_telefone',
                    'aluno.telefone AS aluno_telefone',
                    'secretario.telefone AS secretario_telefone',
                    'aluno.curso AS aluno_curso',
                    'aluno.disciplina AS aluno_disciplina']);

            if(Auth::user()->disciplina == 'TCC II') {
                $orientador = User::find(Auth::user()->id_orientador);
                $id = $orientador->id;
                return view('home', compact('eventos', 'orientador', 'orientadores', 'selecionou_prof'));
            }

            //Informamos que o professor não foi selecionado para que então
            //o modal de cadastro de horário disponível não seja exibido
            $selecionou_prof = false;

            return view('home', compact('eventos', 'orientadores', 'selecionou_prof'));
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
                    'aluno.rm AS aluno_rm',
                    'orientador.telefone AS orientador_telefone',
                    'aluno.telefone AS aluno_telefone',
                    'secretario.telefone AS secretario_telefone',
                    'aluno.curso AS aluno_curso',
                    'aluno.disciplina AS aluno_disciplina']);
        }

        if (Auth::user()->tipo == 'Secretário') {
            $orientadores = User::query()
                        ->where('users.tipo', 'orientador')
                        ->orderBy('name')
                        ->orderBy('sobrenome')
                        ->get(['users.name',
                                'users.sobrenome',
                                'users.id']);
            
            $eventos = Evento::query()
                ->join('users AS aluno', 'eventos.id_aluno', 'aluno.id')
                ->join('users AS orientador', 'eventos.id_orientador', 'orientador.id')
                ->join('users AS secretario', 'eventos.id_secretario', 'secretario.id')
                ->get(['eventos.*',
                    'orientador.name AS orientador_name',
                    'orientador.sobrenome AS orientador_sobrenome',
                    'aluno.name AS aluno_name',
                    'aluno.sobrenome AS aluno_sobrenome',
                    'secretario.name AS secretario_nome',
                    'secretario.sobrenome AS secretario_sobrenome',
                    'aluno.rm AS aluno_rm',
                    'orientador.telefone AS orientador_telefone',
                    'aluno.telefone AS aluno_telefone',
                    'secretario.telefone AS secretario_telefone',
                    'aluno.curso AS aluno_curso',
                    'aluno.disciplina AS aluno_disciplina']);

                
                //Informamos que o professor não foi selecionado para que então
                //o modal de cadastro de horário disponível não seja exibido
                $selecionou_prof = false;

                return view('home', compact('eventos', 'orientadores', 'selecionou_prof'));
        }

        $orientador = User::find(Auth::user()->id_orientador);
        $id = $orientador->id;

        return view('home', compact('eventos', 'orientador'));
    }

    //Mostra o calendário de um professor específico
    public function calendarioProfessor($id) {
        if(Auth::user()->tipo == 'Aluno') {
            $orientador = User::findOrFail($id);

            //Se o id do orientador passado não for o orientador do aluno e o aluno estiver
            //fazendo TCC II, retornamos uma mensagem de erro
            if(Auth::user()->disciplina == 'TCC II' && Auth::user()->id_orientador != $id) {
                return redirect()->back()->with('error', "O ID não pertence ao seu orientador.");
            }
            
            $eventos = Evento::query()
                ->join('users AS aluno', 'eventos.id_aluno', 'aluno.id')
                ->join('users AS orientador', 'eventos.id_orientador', 'orientador.id')
                ->join('users AS secretario', 'eventos.id_secretario', 'secretario.id')
                ->where('eventos.status', 'Disponível')
                ->where('eventos.id_orientador', $id)
                ->get(['eventos.*',
                    'orientador.name AS orientador_name',
                    'orientador.sobrenome AS orientador_sobrenome',
                    'aluno.name AS aluno_name',
                    'aluno.sobrenome AS aluno_sobrenome',
                    'secretario.name AS secretario_nome',
                    'secretario.sobrenome AS secretario_sobrenome',
                    'aluno.rm AS aluno_rm',
                    'orientador.telefone AS orientador_telefone',
                    'aluno.telefone AS aluno_telefone',
                    'secretario.telefone AS secretario_telefone',
                    'aluno.curso AS aluno_curso',
                    'aluno.disciplina AS aluno_disciplina']);


            $orientadores = User::query()
                        ->where('users.tipo', 'Orientador')
                        ->orderBy('name')
                        ->orderBy('sobrenome')
                        ->get(['users.name',
                                'users.sobrenome',
                                'users.id']);
    
            //Informamos que o professor foi selecionado para que então
            //o modal de cadastro de horário disponível seja exibido
            $selecionou_prof = true;
            
            return view('home', compact('eventos', 'orientador', 'orientadores', 'selecionou_prof'));
        } else if (Auth::user()->tipo == 'Secretário') {
            $orientador = User::findOrFail($id);

            // //Se o id do orientador passado não for de um orientador, retornamos uma mensagem de erro
            if($orientador->tipo != 'Orientador') {
                return redirect()->back()->with('error', "O ID não pertence a um orientador válido");
            }
            
            $eventos = Evento::query()
                ->join('users AS aluno', 'eventos.id_aluno', 'aluno.id')
                ->join('users AS orientador', 'eventos.id_orientador', 'orientador.id')
                ->join('users AS secretario', 'eventos.id_secretario', 'secretario.id')
                ->where('eventos.id_orientador', $id)
                ->get(['eventos.*',
                    'orientador.name AS orientador_name',
                    'orientador.sobrenome AS orientador_sobrenome',
                    'aluno.name AS aluno_name',
                    'aluno.sobrenome AS aluno_sobrenome',
                    'secretario.name AS secretario_nome',
                    'secretario.sobrenome AS secretario_sobrenome',
                    'aluno.rm AS aluno_rm',
                    'orientador.telefone AS orientador_telefone',
                    'aluno.telefone AS aluno_telefone',
                    'secretario.telefone AS secretario_telefone',
                    'aluno.curso AS aluno_curso',
                    'aluno.disciplina AS aluno_disciplina']);

            $orientadores = User::query()
                            ->where('users.tipo', 'Orientador')
                            ->orderBy('name')
                            ->orderBy('sobrenome')
                            ->get(['users.name',
                                    'users.sobrenome',
                                    'users.id']);
            
            //Informamos que o professor foi selecionado para que então
            //o modal de cadastro de horário disponível seja exibido
            $selecionou_prof = true;

            return view('home', compact('eventos', 'id', 'orientadores', 'selecionou_prof', 'orientador'));
        }else {
            return redirect('home');
        }
    }

    //Função responsável por exibir o histórico de todas as reuniões cadastradas no sistema para os
    //usuários.
    public function historicoReunioes() {     
        //Só secretários podem ver o histórico de reuniões de todo mundo.
        if(Auth::user()->tipo == 'Secretário') {
            $eventos = Evento::query()
                ->join('users AS aluno', 'eventos.id_aluno', 'aluno.id')
                ->join('users AS orientador', 'eventos.id_orientador', 'orientador.id')
                ->join('users AS secretario', 'eventos.id_secretario', 'secretario.id')
                ->where('eventos.status', '!=', 'Disponível')
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
        } else if (Auth::user()->tipo == 'Aluno'){
            $eventos = Evento::query()
                ->join('users AS aluno', 'eventos.id_aluno', 'aluno.id')
                ->join('users AS orientador', 'eventos.id_orientador', 'orientador.id')
                ->join('users AS secretario', 'eventos.id_secretario', 'secretario.id')
                ->where('eventos.status', '!=', 'Disponível')
                ->where('eventos.id_aluno', Auth::user()->id)
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
        } else {
            $eventos = Evento::query()
                ->join('users AS aluno', 'eventos.id_aluno', 'aluno.id')
                ->join('users AS orientador', 'eventos.id_orientador', 'orientador.id')
                ->join('users AS secretario', 'eventos.id_secretario', 'secretario.id')
                ->where('eventos.id_orientador', Auth::user()->id)
                ->where('eventos.status', '!=', 'Disponível')
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

        return view('historicoreunioes', compact('eventos'));
    }

    //Método que,junto com um jQuery, retorna os dados de um evento instantaneamente para um modal
    public function infoReuniao($id) {
        $evento = Evento::query()
                ->join('users AS aluno', 'eventos.id_aluno', 'aluno.id')
                ->join('users AS orientador', 'eventos.id_orientador', 'orientador.id')
                ->join('users AS secretario', 'eventos.id_secretario', 'secretario.id')
                ->where('eventos.id', $id)
                ->where('eventos.status', '!=', 'Disponível')
                ->firstOrFail(['eventos.*',
                    'orientador.name AS orientador_name',
                    'orientador.sobrenome AS orientador_sobrenome',
                    'aluno.name AS aluno_name',
                    'aluno.sobrenome AS aluno_sobrenome',
                    'aluno.rm AS aluno_rm',
                    'secretario.name AS secretario_nome',
                    'secretario.sobrenome AS secretario_sobrenome',
                    'aluno.telefone AS aluno_telefone',
                    'aluno.curso AS aluno_curso',
                    'aluno.disciplina AS aluno_disciplina']);

        return $evento;
    }

    //Método que, junto com o jQuery, retorna de forma dinâmica os dados do aluno quando o secretário informa o seu
    //RM
    public function infoAluno($rm) {
        //Antes de agendar uma reunião, vamos procurar o aluno pelo seu RM
        $aluno = User::query()
                ->where('users.rm', $rm)
                ->first(['users.name',
                    'users.sobrenome',
                    'users.curso',
                    'users.disciplina',
                    'users.telefone']);

        //Se o RM digitado for incorreto, retornamos null para o script em forma de string
        if($aluno == null) {
            $mensagem = 'null';
            return $mensagem;
        }

        return $aluno;
    }

    //Esta função cancela uma reunião ou fecha um horário
    public function delete(Request $request)
    {
        //Antes de mais nada, verificamos se o usuário logado é um orientador, pois os orientadores
        //não podem cancelar reuniões ou fechar horários. Logo, retornaremos uma mensagem de erro, caso
        //ele consiga, de alguma forma, entrar nesta função do sistema
        if(Auth::user()->tipo == 'Orientador') {
            return redirect()->back()->with('error', "Você não tem permissão para fazer esta operação");
        }

        $evento = Evento::findOrFail($request['id']);

        //Verificamos se o evento é uma reunião ou se é apenas um horário disponível
        if($evento->status == 'Disponível') {
            //Antes de fechar um horário, verificamos se o usuário é um secretário
            if(Auth::user()->tipo != 'Secretário') {
                return redirect()->back()->with('error', "Você não tem permissão para fazer esta operação");
            }

            Evento::destroy($request['id']);
            return redirect()->back()->with('message', "Horário fechado com sucesso.");
        }

        
        //Antes de cancelar a reunião, verificamos se o usuário logado é um aluno, para
        //que possamos fazer controle do que ele pode cancelar ou não
        if(Auth::user()->tipo == 'Aluno') {
            //Antes de cancelar uma reunião, verificamos se a reunião pertence ao aluno,
            //caso ele tente, de alguma forma, cancelar o agendamento de outro aluno
            if($evento->id_aluno != Auth::user()->id) {
                return redirect()->back()->with('error', "Você não tem permissão para fazer esta operação");
            }
        }
        
        Evento::findOrFail($request['id'])
        ->update([
            'titulo' => 'Disponível',
            'id_aluno' => $evento->id_orientador,
            'status' => "Disponível",
        ]);

        //Como o aluno cancelou a reunião, colocamos como falso o campo
        //em espera
        User::findOrFail($evento->id_aluno)
        ->update([
            'em_espera' => false,
        ]);

        return redirect()->back()->with('message', "Reunião cancelada com sucesso.");
    }
}
