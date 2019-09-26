@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header text-center"><h4>Alterar senha</h4></div>

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
                        Altere sua senha 
                    </div>

                    <form method="post" class="col-md-10 offset-1" action="{{route('mudasenha.submit')}}"">
                        @csrf

                        <div class="form-group row">
                            <div class="col">
                                <label for="currentPassword">Senha atual</label>
                                <input type="password" class="form-control{{ session()->has('erro-senha-atual') ? ' is-invalid' : '' }}"
                                id="currentPassword" name="currentPassword"
                                required>

                                @if(session()->has('erro-senha-atual'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{session()->get('erro-senha-atual')}}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <label for="password">Nova senha</label>
                                <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                id="password" name="password"
                                required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <label for="password-confirm">Confirmar nova senha</label>
                                <input type="password" class="form-control"
                                id="password-confirm" name="password_confirmation"
                                required>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Alterar senha</button>
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
