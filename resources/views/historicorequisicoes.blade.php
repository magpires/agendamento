@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center"><h2>Histórico de requisições</h2></div>

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
                            - Acompanhe o histórico de todas as requisições enviadas ao sistema.<br>
                        </div>
                    @else
                        <div class="row">
                            <div class="alert alert-primary col-md-9 offset-1">
                                - Acompanhe o histórico de todas as requisições enviadas por você ao sistema.<br>
                            </div>
    
                            <button id="cadastraRequisicao" class="col-md-2 text-center btn-link btn" style="color:#00285B">
                                <i class="fas fa-plus-circle fa-2x"></i><br>
                                Cadastrar nova requisição
                            </button>
                        </div>
                    @endif
                    
                    <table id="datatable" class="ui celled table" cellspacing="0" width="100%">
                        <thead class="table">
                            <tr>
                                <th class="text-center border-left">Data de envio</th>
                                <th class="text-center border-left">Título</th>
                                @if(Auth::user()->tipo == 'Secretário')
                                    <th class="text-center border-left">Nome do professor</th>
                                @endif
                                <th class="text-center border-left">Status</th>			
                                <th class="text-center border-left border-right">Opções</th>
                            </tr>
                        </thead>

                        @foreach($requisicoes as $requisicao)
                        <tr class="text-center">
                            <td class="text-center border-left">{{date('d/m/Y', strtotime($requisicao->created_at))}}</td>
                            <td class="text-center border-left">{{$requisicao->titulo}}</td>
                            @if(Auth::user()->tipo == 'Secretário')
                                <td class="text-center border-left">{{$requisicao->requisitante_name}} {{$requisicao->requisitante_sobrenome}}</td>
                            @endif
                            <td class="text-center border-left">{{$requisicao->status}}</td>
                            <td class="actions text-center border-left border-right">
                                <button id="detalhes" value="{{$requisicao->id}}" class="btn btn-link detalhes">Visualizar detalhes</button>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>

                
            </div>
        </div>
    </div>
</div>

@include('modals.modalsrequisicao')

<script>
    //Chamamos o modal de cadastro de requisição
    $('#cadastraRequisicao').on("click", function () {
        $('#requisicao').modal();
    });
    
    //Script que busca no banco os detalhes da requisição para jogar no modal
    $('.detalhes').on("click", function () {
        var id = $(this).val();
        var route = "{{route('inforequisicao', 'id')}}".replace('id', id)
        
        $.post(route, function(requisicao){
            $('#infoRequisicao #id').val(requisicao.id);
            $('#infoRequisicao #titulo').val(requisicao.titulo);
            $('#infoRequisicao #descricao').val(requisicao.descricao);
            $('#infoRequisicao #requisitante').val(requisicao.requisitante_name+' '+requisicao.requisitante_sobrenome);
            if(requisicao.id_secretario == null) {
                $('#infoRequisicao #secretario').val('Esta requisição ainda não foi avaliada por um secretário');
            } else {
                $('#infoRequisicao #secretario').val(requisicao.secretario_name+' '+requisicao.secretario_sobrenome);
            }
            @if(Auth::user()->tipo == 'Secretário')
                if(requisicao.status == 'Confirmada') {
                    $('#infoRequisicao #status').val(requisicao.status).attr('disabled', true);
                    $('#infoRequisicao #salvar').attr('disabled', true);
                } else {
                    $('#infoRequisicao #status').val(requisicao.status).attr('disabled', false);;
                    $('#infoRequisicao #salvar').attr('disabled', false);
                }
            @else
                $('#infoRequisicao #status').val(requisicao.status).attr('disabled', true);
                $('#infoRequisicao #salvar').hide();
            @endif
            $('#infoRequisicao').modal();
        });
    });

    $(".menu > a").click(function () { // when clicking any of these links
        $(".menu > a").removeClass("active"); // remove highlight from all links
        $(this).addClass("active"); // add highlight to clicked link
    })
    
    $(document).ready(function () {
        //Código serve para ordenar as requisições pela data
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
                @if(Auth::user()->tipo == 'Secretário')
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

    @if(session()->has('erroCadastro'))
        //Se houver algum erro no cadastro, nós chamamos o modal de cadastro novamente
        $(document).ready(function () {
            $('#requisicao').modal();
        });
    @endif

    @if(session()->has('erroUpdate'))
        //Se houver algum erro no cadastro, nós chamamos o modal de cadastro novamente
        $(document).ready(function () {
            $('#infoRequisicao').modal();
        });
    @endif
</script>
@endsection
