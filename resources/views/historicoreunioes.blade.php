@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center"><h2>Histórico de reuniões</h2></div>

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

                    @if(Auth::user()->tipo == 'Secretário')
                        <div class="alert alert-primary col-md-10 offset-1">
                            - Acompanhe o histórico de todas as reuniões cadastradas no sistema.<br>
                        </div>
                    @else
                    <div class="alert alert-primary col-md-10 offset-1" role="alert">
                            <h5>Este é seu calendário</h5>
                            <p> - Selecione uma das reuniões no calendário para 
                                                    obter mais detalhes sobre o evento.<br>

                                                    - Você pode editar ou cancelar uma reunião logo após selecioná-la.<br>
                                                    - Para criar uma nova reunião, clique <a href="#">aqui</a> ou na guia "Calendário de Professores" 
                                                    na barra de navegação que fica na parte superior do site.
                            </p>
                        </div>
                    @endif
                    
                    <table id="datatable" class="ui celled table" cellspacing="0" width="100%">
                        <thead class="table">
                            <tr>
                                <th class="text-center border-left">Data da reunião</th>
                                <th class="text-center border-left">Título</th>
                                @if(Auth::user()->tipo == 'Aluno' || Auth::user()->tipo == 'Secretário')
                                    <th class="text-center border-left">Nome do professor</th>
                                @endif
                                @if(Auth::user()->tipo == 'Orientador' || Auth::user()->tipo == 'Secretário')
                                    <th class="text-center border-left">Nome do aluno</th>
                                @endif
                                <th class="text-center border-left">Status</th>			
                                <th class="text-center border-left border-right">Opções</th>
                            </tr>
                        </thead>

                        @foreach($eventos as $evento)
                        <tr class="text-center">
                            <td class="text-center border-left">{{date('d/m/Y', strtotime($evento->start))}}</td>
                            <td class="text-center border-left">{{$evento->titulo}}</td>
                            @if(Auth::user()->tipo == 'Aluno' || Auth::user()->tipo == 'Secretário')
                                <td class="text-center border-left">{{$evento->orientador_name}} {{$evento->orientador_sobrenome}}</td>
                            @endif
                            @if(Auth::user()->tipo == 'Orientador' || Auth::user()->tipo == 'Secretário')
                                <td class="text-center border-left">{{$evento->aluno_name}} {{$evento->aluno_sobrenome}}</td>
                            @endif
                            <td class="text-center border-left">{{$evento->status}}</td>
                            <td class="actions text-center border-left border-right">
                                <button id="detalhes" value="{{$evento->id}}" class="btn btn-link detalhes">Visualizar detalhes</button>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>

                
            </div>
        </div>
    </div>
</div>

@include('modals.modalscalendario')

<script>
    $('.btnEditar').on("click", function () {
        $('.form').slideToggle();
        $('.visualizar').slideToggle();
    });

    // Mascara de data e hora
    //Mascara de Data e Hora
    function DataHora(evento, objeto) {
        var keypress = (window.event) ? event.keyCode : evento.which;
        campo = eval(objeto);
        if (campo.value == '00/00/0000 00:00:00') {
            campo.value = ""
        }

        caracteres = '0123456789';
        separacao1 = '/';
        separacao2 = ' ';
        separacao3 = ':';
        conjunto1 = 2;
        conjunto2 = 5;
        conjunto3 = 10;
        conjunto4 = 13;
        conjunto5 = 16;
        if ((caracteres.search(String.fromCharCode(keypress)) != -1) && campo.value.length < (19)) {
            if (campo.value.length == conjunto1)
                campo.value = campo.value + separacao1;
            else if (campo.value.length == conjunto2)
                campo.value = campo.value + separacao1;
            else if (campo.value.length == conjunto3)
                campo.value = campo.value + separacao2;
            else if (campo.value.length == conjunto4)
                campo.value = campo.value + separacao3;
            else if (campo.value.length == conjunto5)
                campo.value = campo.value + separacao3;
        } else
            event.returnValue = false;
    }

    //Script que busca no banco os detalhes do evento para jogar no modal
    $('.detalhes').on("click", function () {
        var id = $(this).val();
        var route = "{{route('inforeuniao', 'id')}}".replace('id', id)
        
        $.post(route, function(event){
            $('#visualizar #id').text(event.id);
                $('#visualizar #id').val(event.id);

                $('#visualizar #titulo').text(event.titulo);

                $('#visualizar #rm').text(event.aluno_rm);
                
                //Se não houver aluno agendado, o campo de RM ficará limpo e 
                //disponível para edição.
                //Além disso, o campo título ficará em branco, caso não haja aluno agendado
                if(event.status == 'Disponível') {
                    //O rm só terá o valor vazio caso um secretário esteja cadastrando um aluno.
                    //Se for aluno, automaticamente receberar o RM do aluno logado
                    @if(Auth::user()->tipo == 'Secretário')
                        $('#visualizar #rm').val('');
                    @else
                        $('#visualizar #rm').val('{{Auth::user()->rm}}');
                    @endif
                    $('#visualizar #titulo').val('');
                    $('#visualizar #rm').prop("readonly", false);
                } else {
                    $('#visualizar #titulo').val(event.titulo);
                    $('#visualizar #rm').val(event.aluno_rm);
                    $('#visualizar #rm').prop("readonly", true);
                }
                
                $('#visualizar #curso').text(event.aluno_curso);
                $('#visualizar #curso').val(event.aluno_curso);

                $('#visualizar #disciplina').text(event.aluno_disciplina);
                $('#visualizar #disciplina').val(event.aluno_disciplina);

                $('#visualizar #professor').text(event.orientador_name+' '+event.orientador_sobrenome);
                $('#visualizar #professor').val(event.orientador_name+' '+event.orientador_sobrenome);

                $('#visualizar #aluno').text(event.aluno_name+ ' '+event.aluno_sobrenome);
                $('#visualizar #aluno').val(event.aluno_name+ ' '+event.aluno_sobrenome);

                $('#visualizar #contato').text(event.aluno_telefone);
                $('#visualizar #contato').val(event.aluno_telefone);

                $('#visualizar #status').text(event.status);
                $('#visualizar #novoStatus').val(event.status);

                if(event.status == 'Disponível') {
                    $('#visualizar #exibeStatus').hide();
                } else if(event.status == 'Concluída') {
                    $('#visualizar #cancela_reuniao').hide();
                    $('#visualizar #agenda_edita').hide();
                } else {
                    $('#visualizar #cancela_reuniao').show();
                    $('#visualizar #agenda_edita').show();
                    $('#visualizar #exibeStatus').show();
                }

                $('#visualizar #secretario').text(event.secretario_nome+' '+event.secretario_sobrenome);
                $('#visualizar #secretario').val(event.secretario_nome+' '+event.secretario_sobrenome   );

                $('#visualizar #start').text(moment(event.start).format('DD/MM/YYYY HH:mm'));
                $('#visualizar #start').val(moment(event.start).format('DD/MM/YYYY HH:mm'));
                $('#visualizar #end').text(moment(event.end).format('DD/MM/YYYY HH:mm'));
                $('#visualizar #end').val(moment(event.end).format('DD/MM/YYYY HH:mm'));

                if(event.status == 'Disponível') {
                    $('#visualizar #agenda_edita').text('Agendar reunião');
                } else {
                    $('#visualizar #agenda_edita').text('Editar reunião');
                }
                
                $('#visualizar #cancela_reuniao').text('Cancelar reunião'),

                @if(Auth::user()->tipo == 'Orientador')
                    $('#visualizar #cancela_reuniao').hide();
                    $('#visualizar #agenda_edita').hide();
                @endif               

                $('#excluir #id').text(event.id);
                $('#excluir #id').val(event.id);
                $('#visualizar').modal();
        });
    });

    $('.btnCancEditar').on("click", function () {
        $('.visualizar').slideToggle();
        $('.form').slideToggle();
    });

    $('.btnExcluir').on("click", function () {
        $('#visualizar').modal('hide');
        $('#excluir').modal();
    });

    $(".menu > a").click(function () { // when clicking any of these links
        $(".menu > a").removeClass("active"); // remove highlight from all links
        $(this).addClass("active"); // add highlight to clicked link
    })

    // Mascara de data e hora
    //Mascara de Data e Hora
    function DataHora(evento, objeto) {
        var keypress = (window.event) ? event.keyCode : evento.which;
        campo = eval(objeto);
        if (campo.value == '00/00/0000 00:00:00') {
            campo.value = ""
        }

        caracteres = '0123456789';
        separacao1 = '/';
        separacao2 = ' ';
        separacao3 = ':';
        conjunto1 = 2;
        conjunto2 = 5;
        conjunto3 = 10;
        conjunto4 = 13;
        conjunto5 = 16;
        if ((caracteres.search(String.fromCharCode(keypress)) != -1) && campo.value.length < (19)) {
            if (campo.value.length == conjunto1)
                campo.value = campo.value + separacao1;
            else if (campo.value.length == conjunto2)
                campo.value = campo.value + separacao1;
            else if (campo.value.length == conjunto3)
                campo.value = campo.value + separacao2;
            else if (campo.value.length == conjunto4)
                campo.value = campo.value + separacao3;
            else if (campo.value.length == conjunto5)
                campo.value = campo.value + separacao3;
        } else
            event.returnValue = false;
    }
    
    $(document).ready(function () {
        //Código serve para ordenar os eventos pela data
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
                @if(Auth::user()->tipo == 'Aluno' || Auth::user()->tipo == 'Secretário')
                    null,
                @endif
                @if(Auth::user()->tipo == 'Orientador' || Auth::user()->tipo == 'Secretário')
                    null,
                @endif
                null
            ],

            //Ordenamos as reuniões das mais rescentes até as mais antigas
            "order": [[ 0, "desc" ]],
            
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
        $("#contato").mask("(99) 9 9999-9999");
        $("#contato").on("blur", function () {
            var last = $(this).val().substr($(this).val().indexOf("-") + 1);
            if (last.length == 5) {
                var move = $(this).val().substr($(this).val().indexOf("-") + 1, 1);
                var lastfour = last.substr(1, 4);
                var first = $(this).val().substr(0, 9);
                $(this).val(first + move + '-' + lastfour);
            }
        });
    });

    @if(session()->has('erroUpdate'))
        //Se houver algum erro no cadastro, nós chamamos o modal de cadastro novamente
        $(document).ready(function () {
            $('#visualizar').modal();
            $('.visualizar').slideToggle();
            $('.form').slideToggle();
        });
    @endif
</script>
@endsection
