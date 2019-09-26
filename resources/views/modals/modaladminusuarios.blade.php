
{{-- Modal de cadastro de usuário --}}
<div class="modal fade" id="cadUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">Cadastrar Novo Usuário</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">
                &times;</span></button>
            </div>

            <div class="modal-body">
                <form method="post" action="{{route('cadastrarusuario')}}">
                    @csrf
                    <div class="form-group row">
                        <div class="col">
                            <label for="name">Nome</label>
                            <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                            id="name" name="name"
                            value="{{ old('name') }}"
                            required>

                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="col">
                            <label for="sobrenome">Sobrenome</label>
                            <input type="text" class="form-control{{ $errors->has('sobrenome') ? ' is-invalid' : '' }}"
                            id="sobrenome" name="sobrenome"
                            value="{{ old('sobrenome') }}"
                            required>

                            @if ($errors->has('sobrenome'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('sobrenome') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col">
                            <label for="telefone">Telefone</label>
                            <input type="text" class="form-control{{ $errors->has('telefone') ? ' is-invalid' : '' }}
                            col-md-6"
                            id="telefone" name="telefone"
                            value="{{ old('telefone') }}"
                            maxlengmaxth="15"
                            required>

                            @if ($errors->has('telefone'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('telefone') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col">
                            <label for="rm">RM</label>
                            <input type="rm" class="form-control{{ $errors->has('rm') ? ' is-invalid' : '' }}"
                            id="rm"name="rm"
                            value="{{ old('rm') }}"
                            maxlength="10"
                            required maxlengmaxth="10">

                            @if ($errors->has('rm'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('rm') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="col">
                            <label for="tipo">Tipo</label>
                            <select name="tipo" id="tipo" class="form-control{{ $errors->has('tipo') ? ' is-invalid' : '' }}"
                            required>
                                <option value="">Selecione</option>
                                <option value="Aluno" title="Aluno">Aluno</option>
                                <option value="Orientador" title="Orientador">Orientador</option>
                                <option value="Secretário" title="Secretário">Secretário</option>
                            </select>

                            @if ($errors->has('tipo'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('tipo') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col">
                            <label for="email">E-Mail</label>
                            <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                            id="email" name="email"
                            value="{{ old('email') }}"
                            required>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row" id="exibecurso" style="display: none;">
                        <div class="col">
                            <label for="curso">Curso</label>
                            <select name="curso" id="curso" class="form-control{{ $errors->has('curso') ? ' is-invalid' : '' }}"
                            required>
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

                        <div class="col" id="exibedisciplina" style="display: none;">
                            <label for="disciplina">Disciplina</label>
                            <select name="disciplina" id="disciplina"
                            class="form-control{{ $errors->has('disciplina') ? ' is-invalid' : '' }}"
                            required>
                                <option value="">Selecione uma disciplina</option>
                                <option value="TCC I" title="TCC I">TCC I</option>
                                <option value="TCC II" title="TCC II">TCC II</option>
                            </select>

                            @if ($errors->has('disciplina'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('disciplina') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row" id="exibeorientador" style="display: none;">
                        <div class="col">
                            <label for="orientador">Orientador</label>
                            <select name="orientador" id="orientador"
                            class="form-control{{$errors->has('orientador') ? ' is-invalid' : '' }} col-md-6"
                            required>
                                <option value="">Selecione seu professor orientador</option>
                                @foreach($orientadores as $orientador)
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
                        <div class="col">
                            <label for="password">Senha</label>
                            <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                            id="password" name="password"
                            required>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="col">
                            <label for="password-confirm">Confirmar senha</label>
                            <input type="password" class="form-control"
                            id="password-confirm" name="password_confirmation"
                            required>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Cadastrar uauário</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal dados usuário --}}
<div class="modal fade" id="infoUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">Dados do Usuário</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">
                &times;</span></button>
            </div>

            <div class="modal-body">
                <form method="post" action="{{route('atualizausuario')}}">
                    @csrf
                    <input type="text" hidden name="id" id="id" required>

                    <div class="form-group row">
                        <div class="col">
                            <label for="name">Nome</label>
                            <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                            id="name" name="name"
                            value="{{ old('name') }}"
                            required
                            readonly>

                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="col">
                            <label for="sobrenome">Sobrenome</label>
                            <input type="text" class="form-control{{ $errors->has('sobrenome') ? ' is-invalid' : '' }}"
                            id="sobrenome" name="sobrenome"
                            value="{{ old('sobrenome') }}"
                            required
                            readonly>

                            @if ($errors->has('sobrenome'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('sobrenome') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col">
                            <label for="telefone">Telefone</label>
                            <input type="text" class="form-control{{ $errors->has('telefone') ? ' is-invalid' : '' }}
                            col-md-6"
                            id="telefone" name="telefone"
                            value="{{ old('telefone') }}"
                            maxlengmaxth="15"
                            required
                            readonly>
                        </div>

                        @if ($errors->has('telefone'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('telefone') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group row">
                        <div class="col">
                            <label for="rm">RM</label>
                            <input type="rm" class="form-control{{ $errors->has('rm') ? ' is-invalid' : '' }}"
                            id="rm"name="rm"
                            value="{{ old('rm') }}"
                            required
                            maxlength="10"
                            readonly>

                            @if ($errors->has('rm'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('rm') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="col">
                            <label for="tipo">Tipo</label>
                            <select name="tipo" id="tipo" class="form-control{{ $errors->has('tipo') ? ' is-invalid' : '' }}"
                            required>
                                <option value="">Selecione</option>
                                <option value="Aluno" title="Aluno">Aluno</option>
                                <option value="Orientador" title="Orientador">Orientador</option>
                                <option value="Secretário" title="Secretário">Secretário</option>
                            </select>

                            @if ($errors->has('tipo'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('tipo') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col">
                            <label for="email">E-Mail</label>
                            <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                            id="email" name="email"
                            value="{{ old('email') }}"
                            required
                            readonly>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="form-group row" id="exibecurso">
                        <div class="col">
                            <label for="curso">Curso</label>
                            <select name="curso" id="curso" class="form-control{{ $errors->has('curso') ? ' is-invalid' : '' }}"
                            required>
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

                        <div class="col" id="exibedisciplina">
                            <label for="disciplina">Disciplina</label>
                            <select name="disciplina" id="disciplina"
                            class="form-control{{ $errors->has('disciplina') ? ' is-invalid' : '' }}"
                            required>
                                <option value="">Selecione uma disciplina</option>
                                <option value="TCC I" title="TCC I">TCC I</option>
                                <option value="TCC II" title="TCC II">TCC II</option>
                            </select>

                            @if ($errors->has('disciplina'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('disciplina') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row" id="exibeorientador">
                        <div class="col">
                            <label for="orientador">Orientador</label>
                            <select name="orientador" id="orientador"
                            class="form-control{{$errors->has('orientador') ? ' is-invalid' : '' }} col-md-6"
                            required>
                                <option value="">Selecione seu professor orientador</option>
                                @foreach($orientadores as $orientador)
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

                    <div class="form-group row" id="exibeAgendada_EmEspera">
                        <div class="col-md-7">
                            <b>Reuniões agendadas: </b><a id="reunioes_agendadas"></a><br>
                            <b>Reunião em espera: </b><a id="em_espera"></a>
                        </div>

                        <input type="text" hidden name="inptReunioes_agendadas" id="inptReunioes_agendadas" required>
                        <input type="text" hidden name="inptEm_espera" id="inptEm_espera" required>

                        <div class="col-md-2">
                            <label for="zerarReuniao">Zerar reuniões agendadas</label>
                            <select name="zerarReuniao" id="zerarReuniao"
                            class="form-control{{ $errors->has('zerarReuniao') ? ' is-invalid' : '' }}"
                            required>
                                <option value="nao" title="Não">Não</option>
                                <option value="sim" title="Sim">Sim</option>
                            </select>

                            @if ($errors->has('zerarReuniao'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('zerarReuniao') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-2">
                            <label for="zerarEmEspera">Remover status em espera</label>
                            <select name="zerarEmEspera" id="zerarEmEspera"
                            class="form-control{{ $errors->has('zerarEmEspera') ? ' is-invalid' : '' }}"
                            required>
                                <option value="nao" title="Não">Não</option>
                                <option value="sim" title="Sim">Sim</option>
                            </select>

                            @if ($errors->has('zerarEmEspera'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('zerarEmEspera') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Salvar alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal Excluir --}}
<div class="modal fade" id="excluir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tem certeza que deseja excluir este usuário?</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">
                  &times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{route('excluiusuario')}}" method="post">
                    @csrf
                    <p class="mt-2">
                        Você está prestes a APAGAR um usuário do sistema. Uma vez feito isso, 
                        a ação não poderá ser desfeita. Deseja continuar?
                    </p>
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