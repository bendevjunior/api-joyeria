<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;


use App\User;
use App\Models\Endereco;

class authController extends Controller {
	

    /**
     * Register .
     *
     * @param
     * @return json
     */
    //se user registrado mas empresa bloqueada bloquear acesso
    public function register (Request $request) {
        //$role = 1-admin | 2-revendedor | 3 - usuario do e-comerce
        if(!is_null(auth()->user())) {
            $request->merge(['email_verified_at' => Carbon::now()->format('Y-m-d')]);
        }
        
        if(User::where('email', $request->email)->get()->count() > 0) {
            return response()->json(['error' => 'Email ja utilizado']);
        }
        $endereco = Endereco::create($request->all());
        $request->merge(['endereco_id'=>$endereco->id]);
        $pass_generate = rand(3333333, 7777777);
        if($request->password == null) {
            $request->merge(['passwors'=>bcrypt($pass_generate)]);
        } else {
            $request->merge(['password'=> bcrypt($request->password)]);
        }
        if($request->ativo == 1) {
            $request->merge(['status'=>1]);
        }
        $user = User::create($request->all());
        $user = User::find($user->id);
        $endereco = $user->endereco;
        $endereco_cidade = $user->endereco->cidade->nome;
        $endereco_estado = $user->endereco->estado->nome;


        return response()->json(compact('user'));
        
    }

    public function ativar_conta (Request $request) {
        $user = User::find_uuid($request->uuid);
        $user->status = 1;
        $user->save();
        return response()->json(['success'=>'Conta ativada com sucesso'], 200);
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

    
  
    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        
        
        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'user' => $user,
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }
  
    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
  
    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }





}
