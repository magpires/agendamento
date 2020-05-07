
{{-- Modal Cadastrar disponibilidade --}}
{{-- Disponível apenas para secretários --}}
{{-- Verificamos se se o ID do orientador foi passado. O modal só vai ser gerado, caso o ID exista --}}
@if(Auth::user()->tipo == 'Secretário')
    @if(isset($id))
        <div class="modal fade" id="cadastrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-center">Cadastrar Horário Disponível</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                    </div>

                    <div class="modal-body">
                        <form method="post" action="{{route('criardisponibilidade')}}">
                            @csrf                    
                            <input type="" hidden value="{{$id}}" name="id_orientador" id="id_orientador">

                            <div class="form-group">
                                <label for="start">Data e Hora Inicial</label>
                                <input type="text" class="form-control{{ $errors->has('start') ? ' is-invalid' : '' }}"
                                id="start" name="start"
                                    onkeypress="DataHora(event, this)"
                                    maxlength="16"
                                    value="{{ old('start') }}"
                                    required>

                                @if ($errors->has('start'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('start') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="end">Data e Hora Final</label>
                                <input type="text" class="form-control" id="end" name="end"
                                    onkeypress="DataHora(event, this)"
                                    maxlength="16"
                                    required
                                    value="{{ old('end') }}"
                                    readonly>
                            </div>
                            <button type="submit" class="btn btn-primary">Cadastrar disponibilidade</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif

{{-- Modal Visualizar --}}
<div class="modal fade" id="visualizar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">Dados da Reunião</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">
                  &times;</span></button>
            </div>

            <div class="modal-body">

                <div class="visualizar">
                    <dl class="dl-horizontal">
                        <dt>ID Reunião</dt>
                        <dd id="id"></dd>

                        <dt>Titulo</dt>
                        <dd id="titulo"></dd>

                        <dt>Curso</dt>
                        <dd id="curso"></dd>

                        <dt>Disciplina</dt>
                        <dd id="disciplina"></dd>

                        <dt>Professor</dt>
                        <dd id="professor"></dd>

                        <dt>Aluno</dt>
                        <dd id="aluno"></dd>

                        <dt>RM do aluno</dt>
                        <dd id="rm"></dd>

                        <dt>Contato do aluno</dt>
                        <dd id="contato"></dd>

                        <dt>Status da reunião</dt>
                        <dd id="status"></dd>

                        <dt>Nome do atual secretário responsável pelo agendamento</dt>
                        <dd id="secretario"></dd>

                        <dt>Inicio do Evento</dt>
                        <dd id="start"></dd>

                        <dt>Fim do Evento</dt>
                        <dd id="end"></dd>
                    </dl>                   
                   
                    {{-- Se o aluno já marcou 2 reuniões ou está esperando por uma reunião --}}
                    {{-- o botão para criar ou editar uma nova reunião ficará indisponível --}}
                    {{-- Esta verificação só acontece no calendário de algum orientador --}}
                    @if(Auth::user()->tipo == 'Aluno' && isset($selecionou_prof))
                        @if(Auth::user()->em_espera == true || Auth::user()->reunioes_agendadas >= 2)
                            <button type="button" class="btn btn-primary btnEditar" id="agenda_edita" disabled></button>
                            <button type="button" class="btn btn-danger btnExcluir" id="cancela_reuniao"></button>
                            @if(Auth::user()->reunioes_agendadas >= 2)
                                <div class="text-danger" id="erro_agenda_reuniao">Você excedeu o limite máximo de reuniões agendadas.</div>
                            @else
                                <div class="text-danger" id="erro_agenda_reuniao">Você já tem uma reunião em espera em seu calendário para ser concluída.</div>
                            @endif
                        @else
                            <button type="button" class="btn btn-primary btnEditar" id="agenda_edita"></button>
                            <button type="button" class="btn btn-danger btnExcluir" id="cancela_reuniao"></button>
                        @endif
                    @else
                        <button type="button" class="btn btn-primary btnEditar" id="agenda_edita"></button>
                        <button type="button" class="btn btn-danger btnExcluir" id="cancela_reuniao"></button>
                    @endif
                </div>

                @if(Auth::user()->tipo == 'Secretário')
                    <div class='form'>
                        <form method="post" action="{{route('agendareuniao')}}"">
                            @csrf
                            <input type="text" hidden name="id" id="id" required
                            value="{{ old('id') }}">

                            <div class="form-group">
                                <label for="titulo">Titulo</label>
                                <input type="text" class="form-control{{ $errors->has('titulo') ? ' is-invalid' : '' }}"
                                id="titulo" name="titulo"
                                required
                                value="{{ old('titulo') }}">

                                @if ($errors->has('titulo'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('titulo') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="rm">RM do aluno</label>
                                <input type="text" class="form-control{{ $errors->has('rm') ? ' is-invalid' : '' }}"
                                id="rm" name="rm"
                                required
                                maxlength="10"
                                value="{{ old('rm') }}">

                                @if ($errors->has('rm'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('rm') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="aluno">Aluno</label>
                                <input type="text" class="form-control" id="aluno" name="aluno" readonly
                                required
                                value="{{ old('aluno') }}">
                            </div>

                            <div class="form-group">
                                <label for="titulo">Curso</label>
                                <input type="text" class="form-control" id="curso" name="curso" readonly
                                required
                                value="{{ old('curso') }}">
                            </div>


                            <div class="form-group">
                                <label for="cor">Disciplina</label>
                                <input type="text" class="form-control" id="disciplina" name="disciplina" readonly
                                required
                                value="{{ old('disciplina') }}">
                            </div>

                            <div class="form-group">
                                <label for="cor">Professor</label>
                                <input type="text" class="form-control" id="professor" name="professor" readonly
                                required
                                value="{{ old('professor') }}">
                            </div>

                            <div class="form-group">
                                <label for="cor">Atual secretário responsável</label>
                                <input type="text" class="form-control" id="secretario" name="secretario" readonly
                                required
                                value="{{ old('secretario') }}">
                            </div>

                            <div class="form-group">
                                <label for="cor">Contato</label>
                                <input type="text" class="form-control contato" id="contato" name="contato" readonly
                                required
                                value="{{ old('contato') }}">
                            </div>

                            <div class="form-group" id="exibeStatus">
                                <label for="cor">Status</label>
                                <select id="novoStatus" class="form-control{{ $errors->has('novoStatus') ? ' is-invalid' : '' }}"
                                name="novoStatus" required>
                                    <option value="">Selecione</option>
                                    <option value="Em espera">Em espera</option>
                                    <option value="Marcada">Marcada</option>
                                    <option value="Concluída">Concluída</option>
                                </select>

                                @if ($errors->has('novoStatus'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('novoStatus') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="start">Data e Hora Inicial</label>
                                <input type="text" class="form-control{{ $errors->has('start') ? ' is-invalid' : '' }}"
                                id="start" name="start"
                                onkeypress="DataHora(event, this)"
                                maxlength="16"
                                required
                                value="{{ old('start') }}"
                                {{Auth::user()->tipo != 'Secretário' ? "readoly" : ""}}>
                            
                                @if ($errors->has('start'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('start') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                            <div class="form-group">
                                <label for="end">Data e Hora Final</label>
                                <input type="datetime" class="form-control" id="end" name="end"
                                    onkeypress="DataHora(event, this)"
                                    maxlength="16"
                                    required
                                    value="{{ old('end') }}"
                                    readonly>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-success">Salvar Alterações</button>
                                <button type="button" class="btn btn-danger btnCancEditar">Cancelar</button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="form">               
                        <form method="post" action="{{route('agendareuniao')}}">
                            @csrf
                            <input type="text" hidden name="id" id="id"
                            required
                            value="{{ old('rm') }}">
                            
                            <div class="form-group">
                                <label for="titulo">Titulo</label>
                                <input type="text" class="form-control{{ $errors->has('titulo') ? ' is-invalid' : '' }}" id="titulo" name="titulo"
                                required
                                value="{{ old('titulo') }}">

                                @if ($errors->has('titulo'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('titulo') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <input type="hidden" class="form-control" id="rm" name="rm"
                            required
                            value="{{ old('rm') }}"
                            maxlength="10">

                            <div class="form-group">
                                <label for="titulo">Curso</label>
                                <input type="text" class="form-control" id="curso" name="curso" readonly
                                required
                                value="{{ old('curso') }}">
                            </div>


                            <div class="form-group">
                                <label for="cor">Disciplina</label>
                                <input type="text" class="form-control" id="disciplina" name="disciplina" readonly
                                required
                                value="{{ old('disciplina') }}">
                            </div>

                            <div class="form-group">
                                <label for="cor">Professor</label>
                                <input type="text" class="form-control" id="professor" name="professor" readonly
                                required
                                value="{{ old('professor') }}">
                            </div>

                            <div class="form-group">
                                <label for="cor">Atual secretário responsável</label>
                                <input type="text" class="form-control" id="secretario" name="secretario" readonly
                                required
                                value="{{ old('secretario') }}">
                            </div>

                            <div class="form-group">
                                <label for="cor">Contato</label>
                                <input type="text" class="form-control contato" id="contato" name="contato" readonly
                                required
                                value="{{ old('contato') }}">
                            </div>

                            <div class="form-group">
                                <label for="start">Data e Hora Inicial</label>
                                <input type="text" class="form-control" id="start" name="start"
                                    onkeypress="DataHora(event, this)"
                                    maxlength="16"
                                    required
                                    value="{{ old('start') }}"
                                    {{Auth::user()->tipo != 'Secretário' ? "readonly" : ""}}>

                            @if ($errors->has('start'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('start') }}</strong>
                                </span>
                            @endif
                            </div>
                            <div class="form-group">
                                <label for="end">Data e Hora Final</label>
                                <input type="datetime" class="form-control" id="end" name="end"
                                    onkeypress="DataHora(event, this)"
                                    maxlength="16"
                                    required
                                    value="{{ old('end') }}"
                                    readonly>
                            </div>

                            
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">Salvar Alterações</button>
                                <button type="button" class="btn btn-danger btnCancEditar">Cancelar</button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Modal Excluir --}}
<div class="modal fade" id="excluir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirmar cancelamento da reunião</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">
                  &times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{route('excluiivento')}}" method="post">
                    @csrf
                    <p class="mt-2">Tem certeza de que deseja cancelar sua reunião?</p>
                    <input type="hidden" name="id" id="id" required>
                </div>

                <div class="modal-footer">
                    <div class="form-group"> 
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Não</button>
                        <button type="submit" class="btn btn-danger" id="btnDelete">Sim</button>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- Esse commit não vai pra produção --}}