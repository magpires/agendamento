<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>
        {{-- <script src="{{ asset('assets/jquery/jquery.min.js') }}"></script> --}}
        {{-- <script src="{{ asset('js/jquery.min.js') }}"></script> --}}
        <script src="{{ asset('js/moment.min.js') }}"></script>
        <script src="{{ asset('assets/datatables/js/dataTables.bootstrap.min.js') }}" defer></script>
        <script src="{{ asset('assets/datatables/js/jquery.dataTables.min.js') }}" defer></script>
        <script src="{{ asset('assets/datatables/js/datetime-moment.js') }}" defer></script>
        <script src="{{ asset('js/fullcalendar.min.js') }}"></script>
        <link href="{{ asset('assets/datatables/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/datatables/css/dataTables.jqueryui.css') }}" rel="stylesheet">
        
        <script src="{{ asset('js/jquery.mask.min.js') }}"></script>
        <script src="{{ asset('locale/pt-br.js') }}"></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="https://fonts.gstatic.com">
        {{-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css"> --}}
        <link href="{{asset('web-fonts-with-css/css/fontawesome-all.css')}}" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{asset('css/fullcalendar.min.css')}}" rel="stylesheet">
        <link href="{{asset('css/fullcalendar.print.min.css')}}" rel="stylesheet" media="print">
        <link href="{{asset('css/style.css')}}" rel="stylesheet">
    </head>
    <body>
        <div id="app">
            <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Agendamento Metodológico
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav">
                        @if(Auth::user()->tipo == 'Aluno')
                            <li class="nav-item">
                                <div class="menu">
                                    <a class="nav-link active" href="{{route('home')}}">Calendário do Aluno</a>
                                </div>
                            </li>
                        @endif

                        @if(Auth::user()->tipo == 'Orientador')
                            <li class="nav-item">
                                <div class="menu">
                                    <a class="nav-link active" href="{{route('home')}}">Calendário do Professor</a>
                                </div>
                            </li>
                        @endif

                        @if(Auth::user()->tipo == 'Secretário')
                            <li class="nav-item">
                                <div class="menu">
                                    <a class="nav-link active" href="{{route('calendarioprofessores')}}">Calendário de Professores</a>
                                </div>
                            </li>
                        @endif
                        
                        @if(Auth::user()->tipo == 'Aluno')
                            @if(Auth::user()->id_orientador != NULL)
                                <li class="nav-item">
                                    <div class="menu">
                                        <a class="nav-link" href="{{route('calendarioprofessor', Auth::user()->id_orientador)}}">Calendário do Professor</a>
                                    </div>
                                </li>
                            @else
                                <li class="nav-item">
                                    <div class="menu">
                                    <a class="nav-link" href="{{route('calendarioprofessores')}}">Calendário de Professores</a>
                                    </div>
                                </li>
                            @endif
                        @endif

                        <li class="nav-item">
                            <div class="menu">
                                <a class="nav-link" href="{{route('historicoreunioes')}}">Histórico de Reuniões</a>
                            </div>
                        </li>

                        @if(Auth::user()->tipo == 'Orientador' || Auth::user()->tipo == 'Secretário')
                            <li class="nav-item">
                                <div class="menu">
                                    <a class="nav-link" href="{{route('historicorequisicoes')}}">Histórico de Requisições</a>
                                </div>
                            </li>
                        @endif

                        @if(Auth::user()->tipo == 'Secretário')
                            <li class="nav-item">
                                <div class="menu">
                                    <a class="nav-link" href="{{route('gerenciarusuarios')}}">Gerenciar Usuários</a>
                                </div>
                            </li>
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            <li class="nav-item">
                                @if (Route::has('register'))
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                @endif
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{Auth::user()->name}} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('meuperfil') }}">
                                        Editar perfil
                                    </a>

                                    <a class="dropdown-item" href="{{ route('mudasenha') }}">
                                        Alterar senha
                                    </a>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                        Sair
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </nav>

            <main class="py-4">
                @yield('content')
            </main>
        </div>
    </body>
</html>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //Script que autopreenche os valores do formulário quando o secretário informa um 
    //RM válido de um aluno
    $('#visualizar #rm').on("blur", function () {
        var rm = $(this).val();
        var route = "{{route('infoaluno', 'rm')}}".replace('rm', rm)

        $.post(route, function(aluno){
            //Se não encontrar aluno, exibimos uma mensagem nos campos
            if(aluno == 'null') {
                $('#visualizar #aluno').val('Nenhum aluno encontrado');
                $('#visualizar #curso').val('Nenhum aluno encontrado');
                $('#visualizar #disciplina').val('Nenhum aluno encontrado');
                $('#visualizar #contato').val('Nenhum aluno encontrado');
            } else {
                $('#visualizar #aluno').val(aluno.name+' '+aluno.sobrenome);
                $('#visualizar #curso').val(aluno.curso);
                $('#visualizar #disciplina').val(aluno.disciplina);
                $('#visualizar #contato').val(aluno.telefone);
            }
        });
    });
</script>
