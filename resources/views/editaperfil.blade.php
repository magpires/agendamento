@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header text-center"><h4>Suas informações</h4></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    @if(session()->has('message'))
                        <div class="alert alert-success text-center">
                            {{ session()->get('message') }}
                        </div>
                    @endif 

                    @if(session()->has('error'))
                        <div class="alert alert-danger text-center">
                            {{ session()->get('error') }}
                        </div>
                    @endif 
                   
                    <div class="alert alert-primary col-md-10 offset-1">
                        Confira e edite suas informações de usuário.
                    </div>

                    <form method="post" class="col-md-10 offset-1" action="{{route('atualizaperfil')}}"">
                        @csrf

                        <div class="form-group row">
                            <div class="col">
                                <label for="name">Nome</label>
                                <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                id="name" name="name"
                                value="{{Auth::user()->name}}"
                                required
                                {{Auth::user()->tipo == 'Secretário' ? '' : 'disabled'}}>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col">
                                <label for="sobrenome">Sobrenome</label>
                                <input type="text" class="form-control{{ $errors->has('sobrenome') ? ' is-invalid' : '' }}"
                                id="sobrenome" name="sobrenome"
                                value="{{Auth::user()->sobrenome}}"
                                required
                                {{Auth::user()->tipo == 'Secretário' ? '' : 'disabled'}}>

                                @if ($errors->has('sobrenome'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('sobrenome') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <label for="telefone">Telefone</label>
                                <input type="text" class="form-control{{ $errors->has('telefone') ? ' is-invalid' : '' }}
                                col-md-6"
                                id="telefone" name="telefone"
                                value="{{Auth::user()->telefone}}"
                                required>
                            </div>

                            @if ($errors->has('telefone'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('telefone') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <label for="rm">RM</label>
                                <input type="rm" class="form-control{{ $errors->has('rm') ? ' is-invalid' : '' }}"
                                id="rm"name="rm"
                                value="{{Auth::user()->rm}}"
                                required
                                {{Auth::user()->tipo == 'Secretário' ? '' : 'disabled'}}>

                                @if ($errors->has('rm'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('rm') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col">
                                <label for="tipo">Tipo</label>
                                <select name="tipo" id="tipo" class="form-control{{ $errors->has('tipo') ? ' is-invalid' : '' }}"
                                required
                                disabled>
                                    <option value="">Selecione</option>
                                    <option value="Aluno" title="Aluno">Aluno</option>
                                    <option value="Orientador" title="Orientador">Orientador</option>
                                    <option value="Secretário" title="Secretário">Secretário</option>
                                </select>

                                @if ($errors->has('tipo'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('tipo') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <label for="email">E-Mail</label>
                                <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                id="email" name="email"
                                value="{{Auth::user()->email}}"
                                required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        @if(Auth::user()->tipo == 'Aluno')
                            <div class="form-group row">
                                <div class="col">
                                    <label for="curso">Curso</label>
                                    <select name="curso" id="curso" class="form-control{{ $errors->has('curso') ? ' is-invalid' : '' }}" required disabled>
                                        <option value="">Selecione o Curso</option>
                                        <option value="Administração - Matutino" title="Administração - Matutino" >Administração - Matutino</option>
                                        <option value="Administração - Noturno" title="Administração - Noturno" >Administração - Noturno</option>
                                        <option value="Análise de Sistemas" title="Análise de Sistemas" >Análise de Sistemas</option>
                                        <option value="Arquitetura e Urbanismo - Matutino" title="Arquitetura e Urbanismo - Matutino" >Arquitetura e Urbanismo - Matutino</option>
                                        <option value="Arquitetura e Urbanismo - Noturno" title="Arquitetura e Urbanismo - Noturno" >Arquitetura e Urbanismo - Noturno</option>
                                        <option value="Ciências Biológicas - Matutino" title="Ciências Biológicas - Matutino" >Ciências Biológicas - Matutino</option>
                                        <option value="Ciências Biológicas - Noturno" title="Ciências Biológicas - Noturno" >Ciências Biológicas - Noturno</option>
                                        <option value="Ciências Contábeis" title="Ciências Contábeis" >Ciências Contábeis</option>
                                        <option value="Direito - Matutino" title="Direito - Matutino" >Direito - Matutino</option>
                                        <option value="Direito - Noturno" title="Direito - Noturno" >Direito - Noturno</option>
                                        <option value="Educação Física - Matutino" title="Educação Física - Matutino" >Educação Física - Matutino</option>
                                        <option value="Educação Física - Noturno" title="Educação Física - Noturno" >Educação Física - Noturno</option>
                                        <option value="Enfermagem - Matutino" title="Enfermagem - Matutino" >Enfermagem - Matutino</option>
                                        <option value="Enfermagem - Noturno" title="Enfermagem - Notuno" >Enfermagem - Noturno</option>
                                        <option value="Engenharia Civil - Matutino" title="Engenharia Civil - Matutino" >Engenharia Civil - Matutino</option>
                                        <option value="Engenharia Civil - Noturno" title="Engenharia Civil - Noturno" >Engenharia Civil - Noturno</option>
                                        <option value="Engenharia de Computação" title="Engenharia de Computação" >Engenharia de Computação</option>
                                        <option value="Engenharia de Produção - Matutino" title="Engenharia de Produção - Matutino" >Engenharia de Produção - Matutino</option>
                                        <option value="Engenharia de Produção - Noturno" title="Engenharia de Produção - Notuno" >Engenharia de Produção - Notuno</option>
                                        <option value="Engenharia de Software" title="Engenharia de Software" >Engenharia de Software</option>
                                        <option value="Engenharia Mecânica" title="Engenharia Mecânica" >Engenharia Mecânica</option>
                                        <option value="Farmácia - Matutino" title="Farmácia - Matutino" >Farmácia - Matutino</option>
                                        <option value="Farmácia - Notuno" title="Farmácia - Noturno" >Farmácia - Notuno</option>
                                        <option value="Filosofia" title="Filosofia" >Coord. Curso - Serviço Social</option>
                                        <option value="Fisioterapia - Matutino" title="cFisioterapia - Matutino" >Fisioterapia - Matutino</option>
                                        <option value="Fisioterapia - Noturno" title="Fisioterapia - Noturno" >Fisioterapia - Noturno</option>
                                        <option value="Nutrição - Matutino" title="Nutrição - Matutino" >Nutrição - Matutino</option>
                                        <option value="Nutrição - Noturno" title="Nutrição - Noturno" >Nutrição - Notuno</option>
                                        <option value="Psicologia" title="Psicologia" >Psicologia</option>
                                        <option value="Serviços Sociais - Matutino" title="Serviços Sociais - Matutino" >Serviços Sociais - Matutino</option>
                                        <option value="Serviços Sociais - Notuno" title="Serviços Sociais - Noturno" >Serviços Sociais - Notuno</option>
                                        <option value="Sistemas de Informação - Noturno"
                                        title="Sistemas de Informação - Noturno" >Sistemas de Informação - Noturno</option>
                                        <option value="Tecnologia e Analise em Desenvolvimento de Sistemas" title="TADS - Noturno" >TADS - Noturno</option> 
                                        <option value="Tecnologia em Design de Interiores" title="Tecnologia em Design de Interiores" >Tecnologia em Design de Interiores</option>
                                        <option value="Tecnologia em Logística" title="Tecnologia em Logística" >Tecnologia em Logística</option>
                                        <option value="Tecnologia em Redes de Computadores - Noturno"
                                        title="Tecnologia em Redes de Computadores - Noturno" >Redes de Computadores - Noturno</option>
                                    </select>

                                    @if ($errors->has('curso'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('curso') }}</strong>
                                    </span>
                                @endif
                                </div>

                                <div class="col">
                                    <label for="disciplina">Disciplina</label>
                                    <select name="disciplina" id="disciplina"
                                    class="form-control{{ $errors->has('disciplina') ? ' is-invalid' : '' }}"
                                    required
                                    disabled>
                                        <option value="">Selecione uma disciplina</option>
                                        <option value="TCC I" title="TCC I">TCC I</option>
                                        <option value="TCC II" title="TCC II">TCC II</option>
                                    </select>

                                    @if ($errors->has('disciplina'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('disciplina') }}</strong>
                                    </span>
                                @endif
                                </div>
                            </div>
                        @endif

                        @if(Auth::user()->tipo == 'Aluno') 
                            <div class="form-group row">
                                <div class="col">
                                    <b>Reuniões agendadas: </b>{{Auth::user()->reunioes_agendadas}}/2</label><br>
                                    <b>Reunião em espera: </b>{{Auth::user()->em_espera ? 'Sim' : 'Não'}}</label>
                                </div>
                            </div>
                        @endif

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Salvar alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $("#telefone").mask("(99) 99999-9999");
        $("#telefone").on("blur", function () {
            var last = $(this).val().substr($(this).val().indexOf("-") + 1);
            if (last.length == 5) {
                var move = $(this).val().substr($(this).val().indexOf("-") + 1, 1);
                var lastfour = last.substr(1, 4);
                var first = $(this).val().substr(0, 9);
                $(this).val(first + move + '-' + lastfour);
            }
        });
    });

    //Script serve para passar os valores dos selects
    $(document).ready(function () {
        $('#tipo').val('{{Auth::user()->tipo}}');
        $('#curso').val('{{Auth::user()->curso}}');
        $('#disciplina').val('{{Auth::user()->disciplina}}');
    });
</script>
@endsection
