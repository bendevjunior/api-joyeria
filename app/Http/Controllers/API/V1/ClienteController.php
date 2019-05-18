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
        $endereco = Endereco::create($request->all());
        $request->merge([
            'endereco_id' => $endereco->id,
            'password' => bcrypt($request->password)
        ]);
        $user = User::create($request->all());
        $user->endereco;
        return response()->json(compact('user'));
    }
}
