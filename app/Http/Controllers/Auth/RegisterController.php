<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    protected $orientador;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redurectTo = '/home';
    
    protected function redirectTo() {
        return '/register';
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:191',
            'sobrenome' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'rm' => 'required|unique:users|string|min:10|max:10',
            'telefone' => 'required|unique:users|string|min:14|max:15',
            'disciplina' =>'required|string',
            'curso' => 'required|string',
            'orientador' => 'required|string|sometimes',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        //Se ao registrar o usuário e por algum motivo ele consiga passar um ID
        //inválido para um orientador, o cadastro é interrompido e uma mensagem de erro
        //é exibida
        if($data['disciplina'] == 'TCC II') {
            $orientador = User::findOrFail($data['orientador']);

            //Se ao registrar o usuário e por algum motivo ele consiga passar um ID
            //de um usuário que não seja um orientador, o sistema retorna para a página
            //de cadastro informando o erro ocorrido
            if ($orientador->tipo != 'Orientador') {
                $this->redirectTo();
            }

            return User::create([
                'name' => $data['name'],
                'sobrenome' =>$data['sobrenome'],
                'email' => $data['email'],
                'rm' => $data['rm'],
                'telefone' => $data['telefone'],
                'curso' => $data['curso'],
                'disciplina' => $data['disciplina'],
                'id_orientador' => $data['orientador'],
                'password' => Hash::make($data['password']),
            ]);
        } else {
            return User::create([
                'name' => $data['name'],
                'sobrenome' =>$data['sobrenome'],
                'email' => $data['email'],
                'rm' => $data['rm'],
                'telefone' => $data['telefone'],
                'curso' => $data['curso'],
                'disciplina' => $data['disciplina'],
                'password' => Hash::make($data['password']),
            ]);
        }
    }
}
