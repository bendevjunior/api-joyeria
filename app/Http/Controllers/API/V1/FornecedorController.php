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

}
