<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Mail\ConfirmEmailAddress;
use Mail;

use App\User;
use App\Models\Empresa;

class empresaController extends Controller
{

    public function get_lista_de_empresas(Request $request) {
        $empresas = Empresa::where('ativo', 1)->orderBy('nome', 'asc')->get();
        foreach($empresas as $empresa) {
            $empresa->endereco = $empresa->endereco;
        }
        return response()->json(compact('empresas'));
    }

}
