@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center"><h2>Calendário do professor</h2></div>

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

                    {{-- Aqui vai os erros do Validator --}}
                    @if($errors->has('titulo') || $errors->has('start') || $errors->has('end'))
                    <div class="alert alert-danger">
                        @if($errors->has('titulo'))
                            - {{ $errors->first('titulo') }}<br>
                        @endif

                        @if($errors->has('start'))
                            - {{ $errors->first('start') }}<br>
                        @endif

                        @if($errors->has('end'))
                            - {{ $errors->first('end') }}<br>
                        @endif

                        @if($errors->has('id_orientador'))
                            - {{ $errors->first('id_orientador') }}<br>
                        @endif
                    </div>
                    @endif 

                    @if(Auth::user()->tipo == 'Secretário')
                        <div>Teste</div>
                    @else   
                        <h5 class="text-center">Este é o calendário do seu professor orientador</h5>
                        <div class="offset-3">
                            - Selecione um dos horários disponíveis no calendário para agendar uma reunião.<br>
                            - Você só pode agendar até duas reuniões com o seu orientador.<br>
                            - A segunda reunião só poderá ser marcada após a conclusão da primeira reunião.
                        </div>
                    @endif
                    <div id='calendar'></div>
                </div>

                
            </div>
        </div>
    </div>
</div>
@include('modals.modals')

<script>
    $('.btnEditar').on("click", function () {
        $('.form').slideToggle();
        $('.visualizar').slideToggle();
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
        $('#calendar').fullCalendar({

            //Current date
            defaultDate: Date(),
            navLinks: true, // can click day/week names to navigate views
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            // Make the day selectable
            selectable: true,
            //Select the time on the day view
            selectHelper: true,

            //Can click in a event to view their data
            eventClick: function (event) {
                $('#visualizar #id').text(event.id);
                $('#visualizar #id').val(event.id);
                $('#visualizar #titulo').text(event.title);
                $('#visualizar #curso').text(event.curso);
                $('#visualizar #curso').val(event.curso);
                $('#visualizar #disciplina').text(event.disciplina);
                $('#visualizar #disciplina').val(event.disciplina);
                $('#visualizar #professor').text(event.professor);
                $('#visualizar #professor').val(event.professor);
                $('#visualizar #aluno').text(event.aluno);
                $('#visualizar #aluno').val(event.aluno);
                $('#visualizar #contato').text(event.contato);
                $('#visualizar #contato').val(event.contato);
                $('#visualizar #status').text(event.status);
                $('#visualizar #secretario').text(event.secretario);
                $('#visualizar #secretario').val(event.secretario);
                $('#visualizar #status').val(event.status);
                $('#visualizar #start').text(event.start.format('DD/MM/YYYY HH:mm'));
                $('#visualizar #start').val(event.start.format('DD/MM/YYYY HH:mm'));
                $('#visualizar #end').text(event.end.format('DD/MM/YYYY HH:mm'));
                $('#visualizar #end').val(event.end.format('DD/MM/YYYY HH:mm'));
                $('#visualizar #agenda_edita').text(event.agenda_edita),
                $('#visualizar #cancela_reuniao').hide(),
                $('#excluir #id').text(event.id);
                $('#excluir #id').val(event.id);
                $('#visualizar').modal();

            },

             @if(Auth::user()->tipo == 'Secretário')
                // Can select a date or a group of dates
                select: function (start, end, event) {
                    var today = moment();
                    start.set({
                        hours: today.hours(),
                        minute: 00
                    });
                    end.set({
                        days: today.days(),
                        hours: today.hours(),
                        minute: 30
                    });


                    $("#cadastrar #start").val(start.format('DD/MM/YYYY HH:mm'));
                    $("#cadastrar #end").val(end.subtract(1, 'days').format('DD/MM/YYYY HH:mm'));
                    $('#cadastrar').modal();
                },
            @endif

            // Events from the Database
            events: [
                @foreach($eventos as $evento)
                
                // O if serve para esconder o botão de cancelar evento
                // caso ele seja uma disponibilidade de agendamento
                @if($evento->id_aluno == $evento->id_orientador)
                $('#visualizar #cancela_reuniao').hide(),
                @else
                $('#visualizar #cancela_reuniao').show(),
                @endif

                {
                    id: '{{$evento->id}}',
                    title: '{{$evento->titulo}}',
                    curso: '{{$evento->aluno_curso}}',
                    disciplina: '{{$evento->aluno_disciplina}}',
                    professor: '{{$evento->orientador_name}} {{$evento->orientador_sobrenome}}',
                    @if($evento->id_aluno == $evento->id_orientador)
                        aluno: 'Nenhum aluno agendado',
                        contato: 'Nenhum aluno agendado',
                    @else
                        aluno: '{{$evento->aluno_name}} {{$evento->aluno_sobrenome}}',
                        contato: '{{$evento->aluno_telefone}}',
                    @endif
                    status: '{{$evento->status}}',
                    secretario: '{{$evento->secretario_nome}} {{$evento->secretario_sobrenome}}',
                    start: '{{$evento->start}}',
                    end: '{{$evento->end}}',
                    @if($evento->titulo == 'Disponível')
                        agenda_edita: 'Agendar reunião',
                    @else
                        agenda_edita: 'Editar reunião',
                    @endif

                    color: '#00285B', // an option!
                    textColor: '#FFFFFF', // an option!
                },
                @endforeach
            ],
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
</script>
@endsection
