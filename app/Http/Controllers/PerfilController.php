<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        return view('editaperfil');
    }

    public function atualizaPerfil(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|sometimes|string|max:191|',
                'sobrenome' => 'required|sometimes|string|max:191|',
                'rm' => ['required',
                            'string',
                            'min:10',
                            'max:10',
                            'sometimes',
                            Rule::unique('users')->ignore(Auth::user()->id)],
                'telefone' => ['required',
                                'max:15',
                                Rule::unique('users')->ignore(Auth::user()->id)],
                'email' => ['required',
                            'string',
                            'email',
                            'max:191',
                            Rule::unique('users')->ignore(Auth::user()->id)],
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            
            if(Auth::user()->tipo == 'Secretário') {
                Auth::user()
                ->update([
                    'name' => $request['name'],
                    'sobrenome' => $request['sobrenome'],
                    'rm' => $request['rm'],
                    'telefone' => $request['telefone'],
                    'email' => $request['email'],
                ]);

                return redirect()->back()->with('message', 'Dados atualizados com sucesso.');
            } else {
                Auth::user()
                ->update([
                    'telefone' => $request['telefone'],
                    'email' => $request['email'],
                ]);

                return redirect()->back()->with('message', 'Dados atualizados com sucesso.');
            }
        } catch(\Exception $e) {
            $mensagem = 'O sistema encontrou um erro inesperado.';
            
            return redirect()->back()->with('error', $mensagem);
        }
    }

    public function indexMudaSenha() {
        return view('mudasenha');
    }

    public function mudaSenha(Request $request)
    {
        try {
            //Aqui nós verificamos se o usuário digitou corretamente sua senha atual. Caso não esteja
            //correta, retornamos uma mensagem de erro.
            if (!Hash::check($request['currentPassword'], Auth::user()->password)) {
                return redirect()->back()->with('erro-senha-atual', "Senha inválida.");
            }
    
            $validator = Validator::make($request->all(), [
                'password' => 'required|string|min:6|confirmed',
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator);
            }
    
            Auth::user()->update([
                'password' => Hash::make($request['password']),
            ]);
    
            return redirect()->back()->with('message', "Senha alterada com sucesso!");
        } catch (\Exceptiion $e) {
            return redirect()->back()->with('message-erro', "O sistema encontrou um erro grave ao executar sua ação. 
                                                            Por favor, tente novamente.");
        }
    }
}
