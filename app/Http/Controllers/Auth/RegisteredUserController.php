<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Empresa;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Mail;

class RegisteredUserController extends Controller
{
    public function validarCampo($valor, $tipo)
    {
        // Se o valor for nulo, retornar NULL
        if ($valor === null) {
            return 'NULL';
        }
        // Determinar o tipo e formatar a string SQL
        switch ($tipo) {
            case 'S':
                return "'$valor'";
            case 'N':
                return $valor;
                // Adicione mais casos conforme necessário

                // Se o tipo não for reconhecido, trate como string por padrão
            default:
                return "'$valor'";
        }
    }

    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $empresa = Empresa::create([
            'nome' => $request->nomeEmpresa,
            'cnpj' => $request->cnpj,
            'email' => $request->emailEmpresa,
            'telefone' => $request->telefone,
            'celular' => $request->celular,
            'instagram' => $request->instagram,
            'cep' => $request->cep,
            'estado' => $request->estado,
            'cidade' => $request->cidade,
            'bairro' => $request->bairro,
            'rua' => $request->rua,
            'numero' => $request->numero,
            'complemento' => $request->complemento,
        ]);
        if ($empresa) {
            $codigoEmpresa = $empresa->id;
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'tipo' => 1,
                'ativo' => 'N',
                'codEmpresa' => $codigoEmpresa,
            ]);
        }


        event(new Registered($user));

        Auth::login($user);
        
        Mail::send(new \App\Mail\emailNovoCliente());

        return redirect(RouteServiceProvider::HOME);
    }

    public function atualizarMeusDados(Request $req)
    {
        $req->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $empresa = Empresa::find(Auth::user()->codEmpresa);
        $empresa->nome = $req->nomeEmpresa;
        $empresa->cnpj = $req->cnpj;
        $empresa->email = $req->emailEmpresa;
        $empresa->telefone = $req->telefone;
        $empresa->celular = $req->celular;
        $empresa->cep = $req->cep;
        $empresa->estado = $req->estado;
        $empresa->cidade = $req->cidade;
        $empresa->bairro = $req->bairro;
        $empresa->rua = $req->rua;
        $empresa->numero = $req->numero;
        $empresa->complemento = $req->complemento;
        $empresa->save();

        $user = User::find(Auth::user()->id);
        $user->name = $req->name;
        $user->email = $req->email;
        
        if ($req->password != "" && $req->password_confirmation != "") {
            $user->password = Hash::make($req->password);
        }
        $user->save();

        // event(new Registered($user));

        // Auth::login($user);

        // return redirect(RouteServiceProvider::HOME);
    }
}
