@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center"><h2>Usuários cadastrados</h2></div>

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

                    <div class="row">
                        <div class="alert alert-primary col-md-9 offset-1 col">
                            Crie, visualize, edite ou exclua usários no sistema<br>
                        </div>
    
                        <button id="cadastra" class="col-md-2 text-center btn-link btn" style="color:#00285B">
                            <i class="fas fa-user-plus fa-2x"></i><br>
                            Cadastrar novo usuário
                        </button>
                    </div>
                    
                    <table id="datatable" class="ui celled table" cellspacing="0" width="100%">
                        <thead class="table">
                            <tr>
                                <th class="text-center border-left">Data de cadastro</th>
                                <th class="text-center border-left">Nome</th>
                                <th class="text-center border-left">Tipo</th>			
                                <th class="text-center border-left border-right">Opções</th>
                            </tr>
                        </thead>

                        @foreach($users as $user)
                            <tr class="text-center">
                                <td class="text-center border-left">{{date('d/m/Y', strtotime($user->created_at))}}</td>
                                <td class="text-center border-left">{{$user->name.' '.$user->sobrenome}}</td>
                                <td class="text-center border-left">{{$user->tipo}}</td>
                                <td class="actions text-center border-left border-right">
                                    <button id="detalhes" type="button" value="{{$user->id}}" class="btn btn-success btn-sm detalhes">Visualizar detalhes</button>
                                    <button id="delete" type="button" value="{{$user->id}}" class="btn btn-danger btn-sm delete">Excluir</button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('modals.modaladminusuarios')

<script>
    //Script que busca no banco os detalhes do usuário para jogar no modal
    $('.detalhes').on("click", function () {
        var id = $(this).val();
        var route = "{{route('infousuario', 'id')}}".replace('id', id);
        
        $.post(route, function(user){
            $('#infoUsuario #id').val(user.id);
            $('#infoUsuario #name').val(user.name);
            $('#infoUsuario #sobrenome').val(user.sobrenome);
            $('#infoUsuario #telefone').val(user.telefone);
            $('#infoUsuario #rm').val(user.rm);
            $('#infoUsuario #tipo').val(user.tipo);
            $('#infoUsuario #email').val(user.email);
            if (user.tipo == 'Aluno') {
                $('#infoUsuario #curso').val(user.curso);
                $('#infoUsuario #disciplina').val(user.disciplina);
                $('#infoUsuario #reunioes_agendadas').text(user.reunioes_agendadas);
                $('#infoUsuario #em_espera').text((user.em_espera) ? "Sim" : "Não" );
                $('#infoUsuario #inptReunioes_agendadas').val(user.reunioes_agendadas);
                $('#infoUsuario #inptEm_espera').val(user.em_espera);

                $('#infoUsuario #exibecurso').show();
                $('#infoUsuario #curso').attr('required', true);
                $('#infoUsuario #curso').attr('disabled', false);
                $('#infoUsuario #exibedisciplina').show();
                $('#infoUsuario #disciplina').attr('required', true);
                $('#infoUsuario #disciplina').attr('disabled', false);
                $('#infoUsuario #orientador').attr('required', true);
                $('#infoUsuario #orientador').attr('disabled', false);
                $('#infoUsuario #exibeAgendada_EmEspera').show();
                $('#infoUsuario #zerarReuniao').attr('required', true);
                $('#infoUsuario #zerarReuniao').attr('disabled', false);
                $('#infoUsuario #zerarEmEspera').attr('required', true);
                $('#infoUsuario #zerarEmEspera').attr('disabled', false);
                $('#infoUsuario #inptReunioes_agendadas').attr('required', true);
                $('#infoUsuario #inptReunioes_agendadas').attr('disabled', false);
                $('#infoUsuario #inptEm_espera').attr('required', true);
                $('#infoUsuario #inptEm_espera').attr('disabled', false);
                if(user.disciplina == 'TCC II') {
                    $('#infoUsuario #orientador').val(user.orientador_id);

                    $('#infoUsuario #exibeorientador').show();
                    $('#infoUsuario #orientador').attr('required', true);
                    $('#infoUsuario #orientador').attr('disabled', false);
                } else {
                    $('#infoUsuario #orientador').val("");

                    $('#infoUsuario #exibeorientador').hide();
                    $('#infoUsuario #orientador').val('').attr('required', false);
                    $('#infoUsuario #orientador').attr('disabled', true);
                }
            } else {
                $('#infoUsuario #curso').val("");
                $('#infoUsuario #disciplina').val("");
                $('#infoUsuario #orientador').val("");

                $('#infoUsuario #exibecurso').hide();
                $('#infoUsuario #curso').val('').attr('required', false);
                $('#infoUsuario #curso').attr('disabled', true);
                $('#infoUsuario #exibedisciplina').hide();
                $('#infoUsuario #disciplina').val('').attr('required', false);
                $('#infoUsuario #disciplina').attr('disabled', true);
                $('#infoUsuario #exibeorientador').hide();
                $('#infoUsuario #orientador').val('').attr('required', false);
                $('#infoUsuario #orientador').attr('disabled', true);
                $('#infoUsuario #exibeAgendada_EmEspera').hide();
                $('#infoUsuario #zerarReuniao').val('nao').attr('required', false);
                $('#infoUsuario #zerarReuniao').attr('disabled', true);
                $('#infoUsuario #zerarEmEspera').val('nao').attr('required', false);
                $('#infoUsuario #zerarEmEspera').attr('disabled', true);
                $('#infoUsuario #inptReunioes_agendadas').val('').attr('required', false);
                $('#infoUsuario #inptReunioes_agendadas').attr('disabled', true);
                $('#infoUsuario #inptEm_espera').val('').attr('required', false);
                $('#infoUsuario #inptEm_espera').attr('disabled', true);
            }

            console.log(user);

            $('#infoUsuario').modal();
        });
        
    });

    //Script que chama o modal de cadastro de usuário
    $('#cadastra').on("click", function () {
        //Limpa os campos toda vez que o modal de cadastro é exibido
        $('#cadUsuario #name').val('').removeClass("is-invalid");
        $('#cadUsuario #sobrenome').val('').removeClass("is-invalid");
        $('#cadUsuario #telefone').val('').removeClass("is-invalid");
        $('#cadUsuario #rm').val('').removeClass("is-invalid");
        $('#cadUsuario #tipo').val('').removeClass("is-invalid");
        $('#cadUsuario #email').val('').removeClass("is-invalid");
        $('#cadUsuario #exibecurso').hide();
        $('#cadUsuario #curso').val('').attr('required', false).removeClass("is-invalid");
        $('#cadUsuario #curso').attr('disabled', true);
        $('#cadUsuario #exibedisciplina').hide();
        $('#cadUsuario #disciplina').val('').attr('required', false).removeClass("is-invalid");
        $('#cadUsuario #disciplina').attr('disabled', true);
        $('#cadUsuario #exibeorientador').hide();
        $('#cadUsuario #orientador').val('').attr('required', false).removeClass("is-invalid");
        $('#cadUsuario #orientador').attr('disabled', true);

        $('#cadUsuario').modal();
    });

    $(".menu > a").click(function () { // when clicking any of these links
        $(".menu > a").removeClass("active"); // remove highlight from all links
        $(this).addClass("active"); // add highlight to clicked link
    })
    
    $(document).ready(function () {
        //Código serve para ordenar os usuários pela data
        jQuery.extend( jQuery.fn.dataTableExt.oSort, {
            "date-br-pre": function ( a ) {
                if (a == null || a == "") {
                    return 0;
                }
                var brDatea = a.split('/');
                return (brDatea[2] + brDatea[1] + brDatea[0]) * 1;
            },

            "date-br-asc": function ( a, b ) {
                return ((a < b) ? -1 : ((a > b) ? 1 : 0));
            },

            "date-br-desc": function ( a, b ) {
                return ((a < b) ? 1 : ((a > b) ? -1 : 0));
            }
        });

        $('#datatable').DataTable({            
            //Aqui nós definimos o tipo da primeira coluna como uma data brasileira
            "aoColumns": [
                { "sType": "date-br" },
                null,
                null,
                null
            ],

            //Ordenamos os usuários dos mais rescentes até as mais antigos
            "order": [[ 1, "asc" ]],
            
            "aLengthMenu": [[5, 10, 15, 20], [5, 10, 15, 20]],
            "pageLength": 5,

            "language": {
                "lengthMenu": "Exibindo _MENU_ registros por página",
                "zeroRecords": "Nenhum Registro Encontrado",
                "info": "Total:  _TOTAL_ registros",
                "infoEmpty": "Nenhum Registro Encontrado",
                "sSearch": "Pesquisar",
                "sProcessing": "Processando...",

                "paginate": {
                    "first": "Primeiro",
                    "last": "Último",
                    "next": "Próximo",
                    "previous": "Anterior"
                },
                "infoFiltered": "(Pesquisado a partir de um total de _MAX_ registros)"
            },
        });
    });

    $(function () {
        $("#cadUsuario #telefone").mask("(99) 99999-9999");
        $("#cadUsuario #telefone").on("blur", function () {
            var last = $(this).val().substr($(this).val().indexOf("-") + 1);
            if (last.length == 5) {
                var move = $(this).val().substr($(this).val().indexOf("-") + 1, 1);
                var lastfour = last.substr(1, 4);
                var first = $(this).val().substr(0, 9);
                $(this).val(first + move + '-' + lastfour);
            }
        });
    });

    $(function () {
        $("#infoUsuario #telefone").mask("(99) 99999-9999");
        $("#infoUsuario #telefone").on("blur", function () {
            var last = $(this).val().substr($(this).val().indexOf("-") + 1);
            if (last.length == 5) {
                var move = $(this).val().substr($(this).val().indexOf("-") + 1, 1);
                var lastfour = last.substr(1, 4);
                var first = $(this).val().substr(0, 9);
                $(this).val(first + move + '-' + lastfour);
            }
        });
    });

    $(document).on('click', '#cadUsuario #disciplina', function() {
        if($('#cadUsuario #disciplina').val() == 'TCC II') {
            $('#cadUsuario #exibeorientador').show();
            $('#cadUsuario #orientador').attr('required', true);
            $('#cadUsuario #orientador').attr('disabled', false);
        } else {
            $('#cadUsuario #exibeorientador').hide();
            $('#cadUsuario #orientador').val('').attr('required', false);
            $('#cadUsuario #orientador').attr('disabled', true);
        }
    })

    $(document).on('click', '#cadUsuario #tipo', function() {
        if($('#cadUsuario #tipo').val() == 'Aluno') {
            $('#cadUsuario #exibecurso').show();
            $('#cadUsuario #curso').attr('required', true);
            $('#cadUsuario #curso').attr('disabled', false);
            $('#cadUsuario #exibedisciplina').show();
            $('#cadUsuario #disciplina').attr('required', true);
            $('#cadUsuario #disciplina').attr('disabled', false);
            $('#cadUsuario #orientador').attr('required', true);
            $('#cadUsuario #orientador').attr('disabled', false);
        } else {
            $('#cadUsuario #exibecurso').hide();
            $('#cadUsuario #curso').val('').attr('required', false);
            $('#cadUsuario #curso').attr('disabled', true);
            $('#cadUsuario #exibedisciplina').hide();
            $('#cadUsuario #disciplina').val('').attr('required', false);
            $('#cadUsuario #disciplina').attr('disabled', true);
            $('#cadUsuario #exibeorientador').hide();
            $('#cadUsuario #orientador').val('').attr('required', false);
            $('#cadUsuario #orientador').attr('disabled', true);
        }
    })

    $(document).on('click', '#infoUsuario #disciplina', function() {
        if($('#infoUsuario #disciplina').val() == 'TCC II') {
            $('#infoUsuario #exibeorientador').show();
            $('#infoUsuario #orientador').attr('required', true);
            $('#infoUsuario #orientador').attr('disabled', false);
        } else {
            $('#infoUsuario #exibeorientador').hide();
            $('#infoUsuario #orientador').val('').attr('required', false);
            $('#infoUsuario #orientador').attr('disabled', true);
        }
    })

    $(document).on('click', '#infoUsuario #tipo', function() {
        if($('#infoUsuario #tipo').val() == 'Aluno') {
            $('#infoUsuario #exibecurso').show();
            $('#infoUsuario #curso').attr('required', true);
            $('#infoUsuario #curso').attr('disabled', false);
            $('#infoUsuario #exibedisciplina').show();
            $('#infoUsuario #disciplina').attr('required', true);
            $('#infoUsuario #disciplina').attr('disabled', false);
            $('#infoUsuario #orientador').attr('required', true);
            $('#infoUsuario #orientador').attr('disabled', false);
            $('#infoUsuario #exibeAgendada_EmEspera').show();
            $('#infoUsuario #zerarReuniao').attr('required', true);
            $('#infoUsuario #zerarReuniao').attr('disabled', false);
            $('#infoUsuario #zerarEmEspera').attr('required', true);
            $('#infoUsuario #zerarEmEspera').attr('disabled', false);
        } else {
            $('#infoUsuario #exibecurso').hide();
            $('#infoUsuario #curso').val('').attr('required', false);
            $('#infoUsuario #curso').attr('disabled', true);
            $('#infoUsuario #exibedisciplina').hide();
            $('#infoUsuario #disciplina').val('').attr('required', false);
            $('#infoUsuario #disciplina').attr('disabled', true);
            $('#infoUsuario #exibeorientador').hide();
            $('#infoUsuario #orientador').val('').attr('required', false);
            $('#infoUsuario #orientador').attr('disabled', true);
            $('#infoUsuario #exibeAgendada_EmEspera').hide();
            $('#infoUsuario #zerarReuniao').attr('required', false);
            $('#infoUsuario #zerarReuniao').attr('disabled', true);
            $('#infoUsuario #zerarEmEspera').attr('required', false);
            $('#infoUsuario #zerarEmEspera').attr('disabled', true);
        }
    })

    $('.delete').on("click", function () {
        $('#excluir #id').val($(this).val());
        $('#excluir').modal();
    });

    @if(session()->has('erroCadastro'))
        //Se houver algum erro no cadastro, nós chamamos o modal de cadastro novamente
        $(document).ready(function () {
            $('#cadUsuario').modal();
        });
    @endif

    @if(session()->has('erroUpdate'))
        //Se houver algum erro no cadastro, nós chamamos o modal de cadastro novamente
        $(document).ready(function () {
            $('#infoUsuario').modal();
        });
    @endif
</script>
@endsection
