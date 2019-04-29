<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Produto;

class ProdutoController extends Controller {
    
    
    public function store(Request $request) {
        $produto = Produto::create($request["produto"]);
        $produto->numero_codigo_de_barras = str_pad($produto->id, 13, '0', STR_PAD_LEFT);
        $produto->save();
        $produto = Produto::find($produto->id);
        return response()->json(compact('produto')); 
    }

}
