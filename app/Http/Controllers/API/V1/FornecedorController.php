<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Fornecedor;
use App\Models\Endereco;

class FornecedorController extends Controller {
    
    public function store (Request $request) {
        //status = 0-desativado | 1-ativado        
        $endereco = Endereco::create($request->all());
        $request->merge([
            'endereco_id'=>$endereco->id,
            'status' => $request->ativo
        ]);
        $fornecedor = Fornecedor::create($request->all());
        $fornecedor = Fornecedor::find($fornecedor->id);
        $endereco = $fornecedor->endereco;
        $endereco_cidade = $fornecedor->endereco->cidade->nome;
        $endereco_estado = $fornecedor->endereco->estado->nome;

        return response()->json(compact('fornecedor')); 
    }

    public function show(Request $request) {
        //se passar uuid retorna apenas o fornecedor especifico
        if($request->uuid == null) {
            $fornecedor = Fornecedor::orderBy('nome', 'asc')->get();
        } else {
            $fornecedor = Fornecedor::find_uuid($request->uuid);
            $endereco = $fornecedor->endereco;
            $endereco_cidade = $fornecedor->endereco->cidade->nome;
            $endereco_estado = $fornecedor->endereco->estado->nome;
        }
        return response()->json(compact('fornecedor'));
    }

    public function update (Request $request, $uuid) {
        //status = 0-desativado | 1-ativado
        $fornecedor = Fornecedor::find_uuid($uuid);  
        $endereco = Endereco::find($fornecedor->endereco_id);
        
        $endereco->update($request->all());
        $request->merge([
            'endereco_id'=>$endereco->id,
            'status' => $request->ativo
        ]);
        $fornecedor->update($request->all());
        $fornecedor = Fornecedor::find($fornecedor->id);
        $endereco = $fornecedor->endereco;
        $endereco_cidade = $fornecedor->endereco->cidade->nome;
        $endereco_estado = $fornecedor->endereco->estado->nome;

        return response()->json(compact('fornecedor')); 
    }

}
