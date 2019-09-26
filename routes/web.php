<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::prefix('/home')->group(function(){
    Route::get('/', 'HomeController@index')->name('home');

    //Rotas para eventos
    Route::post('/criadisponibilidade', 'EventoController@criaDisponibilidade')->name('criardisponibilidade');
    Route::post('/agendareuniao', 'EventoController@agendaReuniao')->name('agendareuniao');
    Route::post('/excluievento', 'EventoController@delete')->name('excluiivento');
});

Route::post('/infoaluno/{rm}', 'EventoController@infoAluno', 'infoaluno')->name('infoaluno');

Route::get('/calendarioprofessores', 'EventoController@calendarioProfessores')->name('calendarioprofessores');
Route::get('/calendarioprofessor/{id}', 'EventoController@calendarioProfessor')->name('calendarioprofessor');

//Rota para histórico de reuniões
Route::get('/historicoreunioes', 'EventoController@historicoReunioes')->name('historicoreunioes');
Route::post('/inforeuniao/{id}', 'EventoController@infoReuniao')->name('inforeuniao');

//Rotas para requisições
Route::post('/cadastrarequisicao', 'RequisicaoController@criaRequisicao')->name('cadastrarequisicao');
Route::get('/historicorequisicoes', 'RequisicaoController@historicoRequisicoes')->name('historicorequisicoes');
Route::post('/inforequisicao/{id}', 'RequisicaoController@infoRequisicao')->name('inforequisicao');
Route::post('/atualizarequisicao', 'RequisicaoController@atualizaRequisicao')->name('atualizarequisicao');

//Aqui teremos as rotas de atualização do perfil dos usuários
Route::get('/meuperfil', 'PerfilController@index')->name('meuperfil');
Route::post('/atualizaperfil', 'PerfilController@atualizaPerfil')->name('atualizaperfil');
Route::get('/mudasenha', 'PerfilController@indexMudaSenha')->name('mudasenha');
Route::post('/mudasenha', 'PerfilController@mudaSenha')->name('mudasenha.submit');

//Rotas para gerenciar usuários
Route::get('/gerenciarusuarios', 'AdminController@index')->name('gerenciarusuarios');
Route::post('/cadastrarusuario', 'AdminController@cadastraUsuario')->name('cadastrarusuario');
Route::post('/infousuario/{id}', 'AdminController@infoUsuario')->name('infousuario');
Route::post('/atualizausuario', 'AdminController@atualizaUsuario')->name('atualizausuario');
Route::post('/excluiusuario', 'AdminController@delete')->name('excluiusuario');

//Caso o usuário não passe um ID para o orientador, mandamos ele de volta para a Home
Route::get('/calendarioprofessor', function () {
    return redirect('home');
});
