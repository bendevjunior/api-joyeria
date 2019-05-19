<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Models\Endereco;

class ClienteController extends Controller
{
    public function index() {
        $clientes = User::where('role', 2)
            ->orWhere('role',  3)
            ->orderBy('nome', 'asc')
            ->with('endereco')
            ->get();
        return response()->json(compact('clientes'));
    }

    public function store(Request $request) {
        $endereco = Endereco::create($request->endereco);
        $cliente = $request->cliente;
        $cliente['endereco_id'] = $endereco->id;
        $cliente["password"] = is_null($request->cliente["password"]) ? bcrypt(rand(333333, 777777)) : bcrypt($request->cliente["password"]);
        
        $user = User::create($cliente);
        $user->endereco;
        return response()->json(compact('user'));
    }

    public function update(Request $request) {
        $user = User::find_uuid($request->cliente['uuid']);
        $cliente = $request->cliente;
        $cliente["password"] = is_null($request->cliente["password"]) ? $user->password : bcrypt($request->cliente["password"]);
        $endereco = $user->endereco;
        $endereco->update($request->endereco);
        $user->update($cliente);
        return response()->json(compact('user'));
    }
}
