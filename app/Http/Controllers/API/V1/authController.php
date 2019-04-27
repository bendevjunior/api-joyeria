<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Mail\ConfirmEmailAddress;
use Mail;


use App\User;
use App\Models\Empresa;
use App\Models\Endereco;

class authController extends Controller {
	/**
     * Attempt to log the user into the application.
     *
     * @param  email password isp_id
     * @return json
     */
    public function authenticate(Request $request) {
        // grab credentials from the request
		$credentials = $request->only('email', 'password');

		try {
			// attempt to verify the credentials and create a token for the user
			if (! $token = JWTAuth::attempt($credentials)) {
				return response()->json(['error' => 'invalid_credentials'], 401);
			}
		} catch (JWTException $e) {
			// something went wrong whilst attempting to encode the token
			return response()->json(['error' => 'could_not_create_token'], 500);
		}

		$user = auth()->user();

		//verify permission
        $user = User::find(auth()->user()->id);
		if($user->ativo == 0) {
			return response()->json(['error' => 'Você não validou o email'], 203);
        }
        if($user->role == 1 && $user->empresa->ativo != 1) {
            return response()->json(['error' => 'A empresa ainda não está liberada para operar'], 205);
        }
        $empresa = $user->empresa;
        $user->role == 1 ? $endereco = $empresa->endereco : $endereco = $user->endereco;


		//save PIND
		//$user->PNID = $request->pnid;
		//$user->save();

		return response()->json(compact('token', 'user', 'endereco', 'empresa'));
	}



	/**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard() {
        return Auth::guard('api');
	}

	/**
     * Refresh TOKEN And generate new token.
     * @param none
     * @return json
     */
	public function token_refresh() {
        $token = $this->guard()->refresh(true);
        return response()->json(compact('token'));
    }

    /**
     * Register .
     *
     * @param
     * @return json
     */
    //se user registrado mas empresa bloqueada bloquear acesso
    public function register (Request $request) {
        //$request->tipo 0=cliente 1= empresa
        if(User::where('email', $request->email)->get()->count() > 0) {
            return response()->json(['error' => 'Email ja utilizado'], 204);
        }
        if(!is_null($request->ref)) {
            $user_ref = User::where('cod_ref', $request->ref)->first();
        } else {
            $user_ref = null;
        }
        if($request->tipo == 0) {
            $user = User::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
                'convidado_por_id' => !is_null($user_ref) ? $user_ref->id : null
            ]);
            $user->cod_ref = rand(33, 77) . $user->id . rand(33, 77);
            $user->save();

        } else {

            //register empresa
            $endereco = Endereco::create($request->all());
            $empresa = Empresa::create([
                'nome'=>$request->name,
                'endereco_id' => $endereco->id
            ]);
            $user = User::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
                'role'      => 1
            ]);


        }

        $email = new ConfirmEmailAddress($user->codigo_email_verificacao, $request->email);
            $a = Mail::to($request->email)->send($email);
            return response()->json(['success'=>'Usuário cadastro com sucesso, valide o email'], 200);
    }

    public function trocar_senha (Request $request) {
        if(!Hash::check($request->senha_atual, Auth::user()->password)) {
            return response()->json(['error'=>'A senha atual não é igual'], 206);
        }
        $user = User::find(auth()->user()->id);
        $user->password = bcrypt($request->nova_senha);
        $user->save();
        return response()->json(['success'=>'Senha alterada com sucesso'], 200);
    }

    public function get_perfil() {
        $user = User::find(auth()->user()->id);
        $endereco = $user->endereco;
        if($user->role == 1) {
            $empresa = $user->empresa;
            $empresa_endereco = $user->empresa->endereco;
        } else {
            $empresa = null;
            $empresa_endereco = null;
        }
        return response()->json(compact('user', 'empresa'));
    }

    public function update_perfil() {
        $user = User::find(auth()->user()->id);
        $user->update($request->all());
        return response()->json(compact('user'));
    }





}
