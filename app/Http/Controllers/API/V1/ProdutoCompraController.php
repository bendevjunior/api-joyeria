<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\ProdutoCompra;
use App\Models\Produto;
use App\Models\Fornecedor;

class ProdutoCompraController extends Controller {
    
    public function store(Request $request) {
        
        $produto    = Produto::find_uuid($request->produto_uuid);
        $fornecedor = Fornecedor::find_uuid($request->fornecedor_uuid);
        $request->merge([
            'produto_id' => $produto->id,
            'fornecedor_id' => $fornecedor->id
        ]);
        $produto_compra = ProdutoCompra::create($request->all());
        $produto->qnt = $produto->qnt + $request->qnt;
        if($request->valor_venda != null) {
            $produto->valor_venda = $request->valor_venda;
        }
        if($request->valor_bruto != null) {
            $produto->valor_bruto = $request->valor_bruto;
        }
        if($request->valor_banho != null) {
            $produto->valor_banho = $request->valor_banho;
        }
        $produto->save();
        return response()->json(compact('produto_compra'));
    }

}
