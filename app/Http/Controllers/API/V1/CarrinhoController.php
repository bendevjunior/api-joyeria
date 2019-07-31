<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Carrinho;
use App\Models\Produto;
use App\Models\CarrinhoProduto;

class CarrinhoController extends Controller
{
    public function show()
    {
        $carrinho = Carrinho::where('cliente_id', auth()->user()->id)
            ->where('status', 0)->first()->with;
        return response()->json($carrinho);
    }

    public function store (Request $request)
    {
        $carrinho = Carrinho::where('cliente_id', auth()->user()->id)
            ->where('status', 0)->first()->with('produtos');
        
        //verifica se existe um carrinho aberto
        if($carrinho == null) {
            //cria carrinho
            $carrinho = $this->create_carrinho();
        }

        foreach($request->produtos as $produto_uuid) {
            $produto = Produto::find_uuid($produto_uuid['uuid']);
            //verifica se tem ja o produto no carrinho
            $carrinho_produto = CarrinhoProduto::where('produto_id', $produto->id)->first();
            if($carrinho_produto == null) {
                CarrinhoProduto::create([
                    'carrinho_id' => $carrinho->id,
                    'produto_id'  => $produto->id,
                    'qnt'         => $produto_uuid['qnt']
                ]);
            } else {
                $carrinho_produto->qnt = $produto_uuid['qnt'];
                $carrinho_produto->save();
            }
        }
        Carrinho::calcula_valor($carrinho->id);
        return response()->json($carrinho);
    }

    public function remove_produto(Request $request)
    {
        $carrinho = Carrinho::where('cliente_id', auth()->user()->id)
            ->where('status', 0)->first();
        $produto = Produto::find_uuid($request->produto_uuid);
        if($carrinho != null) {
            CarrinhoProduto::where('carrinho_id', $carrinho->id)
                ->where('produto_id', $produto->id)
                ->delete();
        }
        return response()->json($carrinho);
    }
    
    public function destroy(Request $request)
    {
        $carrinho = Carrinho::where('cliente_id', auth()->user()->id)
            ->where('status', 0)->first();
        if($carrinho != null) {
            $carrinho->delete();
        }
        return response()->json([], 204);
    }

    //## Funcao de finaliwr venda com abater n estoque e enviar para o fluxo financeiro

    private function create_carrinho()
    {
        return Carrinho::create(['cliente_id'=>auth()->user()->id]);
    }
}
