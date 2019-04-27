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
use App\Models\Material;
use App\Models\Empresa;
use App\Models\Endereco;
use App\Models\Solicitacoes;
use App\Models\TransacaoDePonto;

class enderecoController extends Controller {

    //metodo para cliente
    public function store_endereco(Request $request) {
        $endereco = Endereco::create($request->all());
        return response()->json(compact('endereco'));
    }

    //update endereco via o id
    public function update_endereco(Request $request) {
        $endereco = Endereco::find($request->id);
        $endereco->update($request->all());
        return response()->json(compact('endereco'));
    }

}
