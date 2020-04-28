@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                @if(Auth::user()->tipo == 'Secretário')
                    {{-- Vericicamos se o orientador foi selecionado e exibimos seu nome no calendário --}}
                    {{-- para que o secretário saiba em qual calendário ele está --}}
                    @if(isset($orientador))
                        <div class="card-header text-center"><h2>Calendário de Professores - {{$orientador->name}} {{$orientador->sobrenome}}</h2></div>
                    @else
                        <div class="card-header text-center"><h2>Calendário de Professores</h2></div>
                    @endif
                @elseif(Auth::user()->tipo == 'Aluno')
                    {{-- Vericicamos se o orientador foi selecionado e exibimos seu nome no calendário --}}
                    {{-- para que o aluno saiba em qual calendário ele está --}}
                    @if(isset($orientador))
                        <div class="card-header text-center"><h2>Calendário de Professores - {{$orientador->name}} {{$orientador->sobrenome}}</h2></div>
                    @elseif(isset($meu_calendario))
                        <div class="card-header text-center"><h2>Meu calendário</h2></div>
                    @else
                        <div class="card-header text-center"><h2>Calendário de Professores</h2></div>
                    @endif
                @else
                    <div class="card-header text-center"><h2>Meu calendário</h2></div>
                @endif

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
                            <div>- Para agendar um horário disponível para um determinado 
                                                orientador, selecione primeiro um orientador e em seguida, 
                                                clique em um dia livre para agendar a disponibilidade.<br>

                                                - Selecione un dos horários disponíveis no calendário para agendar uma 
                                                reunião entre um professor e aluno ou fechar o horário.<br>

                                                - Selecione uma reunião para ser editada ou cancelada.<br>
                            </div>
                        </div>
                        

                        <div class="offset-1">
                            <div class="form-group row">
                                <label for="orientador" class="col-md-2 col-form-label text-md-right">Orientador</label>
                                <select name="select_orientador" id="select_orientador" class="form-control col-md-6" required>
                                    <option value="">Selecione o Orientador</option>
                                    @foreach($orientadores as $orientador)
                                        <option value="{{$orientador->id}}" title="{{$orientador->name}} {{$orientador->sobrenome}}">{{$orientador->name}} {{$orientador->sobrenome}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('orientador'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('orientador') }}</strong>
                                    </span>
                                @endif

                                <a href="" id="btn-select_orientador" class="btn btn-primary offset-1eMeio">Selecionar orientador</a>
                            </div>
                        </div>
                    @elseif(Auth::user()->tipo != 'Orientador' && Auth::user()->disciplina == 'TCC I')
                        @if(isset($meu_calendario))
                            <div class="alert alert-primary col-md-10 offset-1" role="alert">
                                <h5>Este é seu calendário</h5>
                                <p> - Selecione uma das reuniões no calendário para 
                                                        obter mais detalhes sobre o evento.<br>

                                                        - Você pode editar ou cancelar uma reunião logo após selecioná-la.<br>
                                </p>
                            </div>
                        @else
                            <div class="alert alert-primary col-md-10 offset-1">
                                <div>- Para agendar um horário disponível para um determinado 
                                                    orientador, selecione primeiro um orientador e em seguida, 
                                                    selecione um horário disponível no calendário 
                                                    para agendar uma reunião com o orientador.<br>
                                </div>
                            </div>
                            

                            <div class="offset-1">
                                <div class="form-group row">
                                    <label for="orientador" class="col-md-2 col-form-label text-md-right">Orientador</label>
                                    <select name="select_orientador" id="select_orientador" class="form-control col-md-6" required>
                                        <option value="">Selecione o Orientador</option>
                                        @foreach($orientadores as $orientador)
                                            <option value="{{$orientador->id}}" title="{{$orientador->name}} {{$orientador->sobrenome}}">{{$orientador->name}} {{$orientador->sobrenome}}</option>
                                        @endforeach
                                    </select>
    
                                    @if ($errors->has('orientador'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('orientador') }}</strong>
                                        </span>
                                    @endif
    
                                    <a href="" id="btn-select_orientador" class="btn btn-primary offset-1eMeio">Selecionar orientador</a>
                                </div>
                            </div>
                        @endif
                    @elseif(Auth::user()->tipo == 'Orientador')
                        <div class="alert alert-primary col-md-10 offset-1" role="alert">
                            <h5>Este é seu calendário</h5>
                            <div>- Selecione un dos horários disponíveis ou uma das reuniões no calendário para 
                                    obter mais detalhes sobre o evento.<br>

                                    - Para fechar um horário ou cancelar uma reunião, favor enviar uma 
                                    requisição para a secretaria através da página <br>
                                      "Histórico de Requisições".<br>
                            </div>
                        </div>
                    @elseif(Auth::user()->tipo == 'Aluno')
                        @if(isset($meu_calendario))
                            <div class="alert alert-primary col-md-10 offset-1">
                                <h5>Este é seu calendário</h5>
                                <div>- Selecione uma das reuniões no calendário para 
                                        obter mais detalhes sobre o evento.<br>

                                        - Você pode editar ou cancelar uma reunião logo após selecioná-la.<br>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-primary col-md-10 offset-1">
                                <h5>Este é o calendário do seu orientador</h5>
                                <div>- Selecione um horário disponível no calendário 
                                                                        para agendar uma reunião com o seu orientador.<br>
                                </div>
                            </div>
                        @endif
                    @endif
                    
                    @if(Auth::user()->tipo == 'Secretário')
                        {{-- O calendário apenas será carregado caso um orientador tenha sido selecionado --}}
                        @if($selecionou_prof)
                            <div id='calendar'></div>
                        @endif
                    @else            
                        @if(isset($meu_calendario))
                            <div id='calendar'></div>
                        @elseif($selecionou_prof)
                            <div id='calendar'></div>
                        @endif
                    @endif
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
            // themeSystem: 'bootstrap4',
            header: {
                right: 'today,prev,next,month,listMonth'
            },
            
            //Current date
            defaultDate: Date(),
            navLinks: true, // can click day/week names to navigate views
            editable: false,
            eventLimit: true, // allow "more" link when too many events
            // Make the day selectable
            selectable: true,
            //Select the time on the day view
            selectHelper: true,
            eventStartEditable: false,
            eventDurationEditable: false,

            //Can click in a event to view their data
            eventClick: function (event) {
                $('#visualizar #id').text(event.id);
                $('#visualizar #id').val(event.id);

                $('#visualizar #titulo').text(event.title);
                
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
                    $('#visualizar #titulo').val(event.title);
                    $('#visualizar #rm').val(event.rm);
                    $('#visualizar #rm').prop("readonly", true);
                }
                
                $('#visualizar #curso').text(event.curso);
                $('#visualizar #curso').val(event.curso);

                $('#visualizar #disciplina').text(event.disciplina);
                $('#visualizar #disciplina').val(event.disciplina);

                $('#visualizar #professor').text(event.professor);
                $('#visualizar #professor').val(event.professor);

                $('#visualizar #aluno').text(event.aluno);
                $('#visualizar #aluno').val(event.aluno);

                $('#visualizar #rm').text(event.rm);

                $('#visualizar #contato').text(event.contato);
                $('#visualizar #contato').val(event.contato);

                $('#visualizar #status').text(event.status);
                $('#visualizar #novoStatus').val(event.status);

                if(event.status == 'Disponível') {
                    $('#visualizar #cancela_reuniao').show();
                    $('#visualizar #agenda_edita').show();
                    $('#visualizar #exibeStatus').hide();
                    $('#visualizar #novoStatus').attr('required', false);
                } else if(event.status == 'Concluída') {
                    $('#visualizar #cancela_reuniao').hide();
                    $('#visualizar #agenda_edita').hide();
                } else {
                    $('#visualizar #cancela_reuniao').show();
                    $('#visualizar #agenda_edita').show();
                    $('#visualizar #exibeStatus').show();
                    $('#visualizar #novoStatus').attr('required', true);
                }

                $('#visualizar #secretario').text(event.secretario);
                $('#visualizar #secretario').val(event.secretario);

                $('#visualizar #start').text(event.start.format('DD/MM/YYYY HH:mm'));
                $('#visualizar #start').val(event.start.format('DD/MM/YYYY HH:mm'));
                $('#visualizar #end').text(event.end.format('DD/MM/YYYY HH:mm'));
                $('#visualizar #end').val(event.end.format('DD/MM/YYYY HH:mm'));

                $('#visualizar #agenda_edita').text(event.agenda_edita);
                $('#visualizar #cancela_reuniao').text(event.cancela_reuniao);
                
                @if(Auth::user()->tipo == 'Orientador')
                    $('#visualizar #cancela_reuniao').hide();
                    $('#visualizar #agenda_edita').hide();
                @endif

                @if(!Auth::user() == 'Secretário')
                    if(event.id_aluno != {{Auth::user()->id}}) {
                        $('#visualizar #cancela_reuniao').hide();
                    } else {
                        $('#visualizar #cancela_reuniao').show();
                    }
                @endif

                $('#excluir #id').text(event.id);
                $('#excluir #id').val(event.id);
                $('#visualizar').modal();
            },

            // Somente secretários podem criar disponibilidade
            @if(Auth::user()->tipo == 'Secretário')
                //Verificamos se o secretário selecionou o professor e assim exibimos o modal de
                //cadastro de disponibilidade
                @if($selecionou_prof)
                    // Can select a date or a group of dates
                    select: function (start, end, event) {
                        var today = moment();
                        start.set({
                            hours: today.hours(),
                        });

                        $("#cadastrar #start").val(start.format('DD/MM/YYYY HH:mm'));
                        $("#cadastrar #end").val(start.add(30, 'minute').format('DD/MM/YYYY HH:mm'));
                        $('#cadastrar').modal();

                        //Esta função serve para adicionar 30 minutos ao tempo final da reunião
                        // toda vez que o usuário altera alguma coisa no campo de data inicial
                        $(document).on('change', '#cadastrar #start', function() {
                            var startModal = moment($('#cadastrar #start').val());
                            console.log(startModal);

                            start.set({
                                hours: startModal.hours(),
                                minutes: startModal.minutes(),
                            });

                            $("#cadastrar #end").val(start.add(30, 'minute').format('DD/MM/YYYY HH:mm'));
                            console.log($("#cadastrar #end").val());
                        })
                    },
                @endif
            @endif

            // Events from the Database
            events: [
                @foreach($eventos as $evento)
                    
                    //Verificamos se o usuário está no calendário do orientador,
                    //mas isso só vai acontecer, caso ele não seja um secretário
                    @if(Auth::user()->tipo != 'Secretário')
                        @if(isset($orientador))
                            // O if serve para esconder o botão de cancelar evento
                            // caso ele seja uma disponibilidade de agendamento
                            @if($evento->status == 'Disponível')
                                $('#visualizar #cancela_reuniao').hide(),
                            @else
                                $('#visualizar #cancela_reuniao').show(),
                            @endif
                        @endif
                    @endif

                    {
                        id: '{{$evento->id}}',
                        id_aluno: '{{$evento->id_aluno}}',
                        title: '{{$evento->titulo}}',
                        professor: '{{$evento->orientador_name}} {{$evento->orientador_sobrenome}}',
                        @if($evento->status == 'Disponível')
                            rm: 'Nenhum aluno agendado',
                            curso: 'Nenhum aluno agendado',
                            disciplina: 'Nenhum aluno agendado',
                            aluno: 'Nenhum aluno agendado',
                            contato: 'Nenhum aluno agendado',
                            cancela_reuniao: 'Fechar horário',
                        @else
                            rm: '{{$evento->aluno_rm}}',
                            curso: '{{$evento->aluno_curso}}',
                            disciplina: '{{$evento->aluno_disciplina}}',
                            aluno: '{{$evento->aluno_name}} {{$evento->aluno_sobrenome}}',
                            contato: '{{$evento->aluno_telefone}}',
                            cancela_reuniao: 'Cancelar reunião',
                        @endif
                        status: '{{$evento->status}}',
                        secretario: '{{$evento->secretario_nome}} {{$evento->secretario_sobrenome}}',
                        start: '{{$evento->start}}',
                        end: '{{$evento->end}}',
                        @if($evento->status == 'Disponível')
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

    //Script para atribuir link para o calendário de um professor
    $(document).on('click', '#select_orientador', function() {
        var id = $(this).val();
        if(id == 0) {
            $('#btn-select_orientador').attr('href', 'http://localhost/agendamento/calendarioprofessores/');
        } else {
            $('#btn-select_orientador').attr('href', 'http://localhost/agendamento/calendarioprofessor/'+ id);
        }
    })

    //Aqui vem a máscara do RM
    $(document).on('keypress', '#rm', function(e) {
        var square = document.getElementById("rm");
        var key = (window.event)?event.keyCode:e.which;
        if((key > 47 && key < 58)) {
            return true;  
        } else {
            return (key == 8 || key == 0)?true:false;          
        }
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

    @if(session()->has('erroCadastro'))
        //Se houver algum erro no cadastro, nós chamamos o modal de cadastro novamente
        $(document).ready(function () {
            $('#cadastrar').modal();
        });
    @endif

    @if(session()->has('erroUpdate'))
        //Se houver algum erro no cadastro, nós chamamos o modal de cadastro novamente
        $(document).ready(function () {
            $('#visualizar').modal();
            $('.visualizar').slideToggle();
            $('.form').slideToggle();
        });
    @endif
</script>
{{-- Teste staging area - Esse vai pra staging area --}}
@endsection
