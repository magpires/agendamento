<?php 
    $users = DB::table('users')
            ->where('tipo', 'Orientador')
            ->orderBy('name')
            ->orderBy('sobrenome')
            ->get(['users.name',
                    'users.sobrenome',
                    'users.id']);
?>

@extends('layouts.app2')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">Cadastre-se</div>

                <div class="card-body">
                    @if(session()->has('error'))
                    <div class="alert alert-danger text-center">
                        {{ session()->get('error') }}
                    </div>
                    @endif

                    <div class="alert alert-primary col-md-10 offset-1">
                        Insira os dados solicitados para se cadastrar no sistema
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Nome</label>

                            <div class="col-md-6">
                                <input id="name" type="text"
                                class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                name="name" value="{{ old('name') }}"
                                required autofocus
                                placeholder="Ex: João"
                                title="Informe o seu nome">

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sobrenome" class="col-md-4 col-form-label text-md-right">Sobrenome</label>

                            <div class="col-md-6">
                                <input id="sobrenome" type="text"
                                class="form-control{{ $errors->has('sobrenome') ? ' is-invalid' : '' }}"
                                name="sobrenome" value="{{ old('sobrenome') }}"
                                required autofocus
                                placeholder="Ex: Da Silva"
                                title="Informe o seu sobrenome">

                                @if ($errors->has('sobrenome'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('sobrenome') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="rm" class="col-md-4 col-form-label text-md-right">RM</label>

                            <div class="col-md-6">
                                <input id="rm" type="text"
                                class="form-control{{ $errors->has('rm') ? ' is-invalid' : '' }}"
                                name="rm" value="{{ old('rm') }}" maxlength="10"
                                required autofocus
                                placeholder="Ex: 6920100321"
                                title="Informe a sua matrícula">

                                @if ($errors->has('rm'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('rm') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="telefone" class="col-md-4 col-form-label text-md-right">Telefone</label>

                            <div class="col-md-6">
                                <input id="telefone" type="text"
                                class="form-control{{ $errors->has('telefone') ? ' is-invalid' : '' }}"
                                name="telefone" value="{{ old('telefone') }}" maxlength="15"
                                required autofocus
                                onkeypress="mascara(this, mtel)"
                                placeholder="Ex: (99) 99999-9999"
                                title="Informe o seu telefone">

                                @if ($errors->has('telefone'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('telefone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email"
                                class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                name="email" value="{{ old('email') }}" required
                                placeholder="Ex: exemplo@exemplo.com"
                                title="Informe o seu E-Mail">

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="curso" class="col-md-4 col-form-label text-md-right">Curso</label>

                            <div class="col-md-6">
                                <select name="curso" id="cursos" class="form-control" required
                                title="Informe o seu curso">
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
                        </div>
                        
                        <div class="form-group row">
                            <label for="disciplina" class="col-md-4 col-form-label text-md-right">Disciplina</label>

                            <div class="col-md-6">
                                <select name="disciplina" id="disciplina" class="form-control" required
                                title="Informe a sua disciplina">
                                    <option value="">Selecione uma disciplina</option>
                                    <option value="TCC I" title="TCC I">TCC I</option>
                                    <option value="TCC II" title="TCC II">TCC II</option>
                                </select>

                                @if ($errors->has('orientador'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('orientador') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row" id="exibeorientador" style="display: none;">
                            <label for="orientador" class="col-md-4 col-form-label text-md-right">Orientador</label>

                            <div class="col-md-6">
                                <select name="orientador" id="orientador" class="form-control{{$errors->has('orientador') ? ' is-invalid' : '' }}" required
                                        title="Informe o seu orientador">
                                    <option value="">Selecione seu professor orientador</option>
                                    @foreach($users as $orientador)
                                        <option value="{{$orientador->id}}" title="{{$orientador->name}} {{$orientador->sobrenome}}">{{$orientador->name}} {{$orientador->sobrenome}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('orientador'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('orientador') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Senha</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required
                                placeholder="Informe sua senha"
                                title="Mínimo de 6 caractéres">

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirmar senha</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                                placeholder="Confirme sua senha">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Registrar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function mascara(o, f) {
        v_obj = o;
        v_fun = f;
        setTimeout("execmascara()", 1);
    }
    function execmascara() {
        v_obj.value = v_fun(v_obj.value);
    }
    function mtel(v) {
        v = v.replace(/\D/g, "");             //Remove tudo o que não é dígito
        v = v.replace(/^(\d{2})(\d)/g, "($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
        v = v.replace(/(\d)(\d{4})$/, "$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
        return v;
    }
    function id(el) {
        return document.getElementById(el);
    }
    window.onload = function () {
        id('telefone').onkeyup = function () {
            mascara(this, mtel);
        };
    }

    $(document).on('click', '#disciplina', function() {
        if($('#disciplina').val() == 'TCC II') {
            $('#exibeorientador').show();
            $('#orientador').attr('required', true);
            $('#orientador').attr('disabled', false);
        } else {
            $('#exibeorientador').hide();
            $('#orientador').val('').attr('required', false);
            $('#orientador').attr('disabled', true);
        }
    })
</script>
@endsection
