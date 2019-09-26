
{{-- Modal de cadastro de requisição --}}
@if(Auth::user()->tipo == 'Orientador')
    <div class="modal fade" id="requisicao" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title">Cadastrar Nova Requisição</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">
                    &times;</span></button>
                </div>

                <div class="modal-body">
                    <form method="post" action="{{route('cadastrarequisicao')}}"">
                        @csrf

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
                            <label for="descricao">Descrição</label>
                            <textarea type="text" class="form-control{{ $errors->has('descricao') ? ' is-invalid' : '' }}"
                            id="descricao" name="descricao"
                            required
                            value="{{ old('descricao') }}"></textarea>

                            @if ($errors->has('descricao'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('descricao') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Enviar requisição</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif

{{-- Modal dados Requisição --}}
<div class="modal fade" id="infoRequisicao" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">Dados da requisição</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">
                &times;</span></button>
            </div>

            <div class="modal-body">
                <form method="post" action="{{route('atualizarequisicao')}}"">
                    @csrf
                    <input type="text" hidden name="id" id="id">

                    <div class="form-group">
                        <label for="titulo">Titulo</label>
                        <input type="text" class="form-control{{ $errors->has('titulo') ? ' is-invalid' : '' }}"
                        id="titulo" name="titulo"
                        required
                        value="{{ old('descricao') }}"
                        readonly>
                    </div>

                    <div class="form-group">
                        <label for="descricao">Descrição</label>
                        <textarea type="text" class="form-control{{ $errors->has('descricao') ? ' is-invalid' : '' }}"
                        id="descricao" name="descricao"
                        required
                        value="{{ old('descricao') }}"
                        readonly></textarea>
                    </div>

                    <div class="form-group">
                        <label for="requisitante">Requisitante</label>
                        <input type="text" class="form-control" id="requisitante" name="requisitante"
                        required
                        value="{{ old('descricao') }}"
                        readonly>
                    </div>

                    <div class="form-group">
                        <label for="secretario">Atual Secretário Responsável</label>
                        <input type="text" class="form-control" id="secretario" name="secretario"
                        required
                        value="{{ old('descricao') }}"
                        readonly>
                    </div>

                    <div class="form-group" id="exibeStatus">
                        <label for="cor">Status</label>
                        <select id="status" class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}"
                        name="status" required>
                            <option value="">Selecione</option>
                            <option value="Pendente">Pendente</option>
                            <option value="Confirmada">Confirmada</option>
                            <option value="Negada">Negada</option>
                        </select>

                        @if ($errors->has('status'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('status') }}</strong>
                                </span>
                            @endif
                    </div>

                    <div class="form-group">
                        <button type="submit" id="salvar" class="btn btn-success">Salvar alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>