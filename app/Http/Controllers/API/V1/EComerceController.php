<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EComercePedido;
use App\Models\Produto;
use App\User;
use App\Models\Venda;
use App\Models\ProdutoVenda;

class EComerceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ecomercepedido = EComercePedido::all();
        return response()->json($ecomercepedido);
    }

    //verifique que permite 
    public function verifique_se_tem_no_estoque($produto, $qnt)
    {
        return $produto->qnt < $qnt ? false : true;
    }
    
    public function store(Request $request)
    {
        foreach ($request->venda["produtos"] as $produto) {
            $produto_obj = Produto::find_uuid($produto['uuid']);
            if (!$this->verifique_se_tem_no_estoque($produto_obj, $produto['qnt'])) {
                return response()->json(['Existe produtos que nao tem no estoque']);
            }
        }
        $data = $request->venda;
        if (isset($data['cliente_uuid']) && $data['cliente_uuid']) {
            $cliente = User::find_uuid($data['cliente_uuid']);
            $cliente_id = $cliente->id;
        } else {
            $cliente_id = auth()->user()->id;
            $cliente = auth()->user();
        }

        if (auth()->user() != null && auth()->user()->role != 1) {
            $data['preco_do_desconto'] = 0;
        }

        $preco_desconto = $data['preco_do_desconto'] ?? 0;

        $venda = Venda::create([
            'cliente_id' => $cliente_id,
            'preco' => 0,
            'preco_final' => 0,
            'preco_do_desconto' => $request->venda['preco_do_desconto'],
            'preco_do_acrescimo' => $request->venda['preco_do_acrescimo'],
            'status' => 0
        ]);
        
        foreach ($request->venda["produtos"] as $produto) {
            $produto_obj = Produto::find_uuid($produto['uuid']);
            Produto::remover_do_estoque($produto['id'], $produto['qnt']);
            ProdutoVenda::create([
                'venda_id' => $venda->id,
                'produto_id' => $produto_obj->id,
                'qnt' => $produto['qnt'],
                'cliente_id' => $cliente_id,
                'valor_desconto' => $produto['valor_desconto'],
                'valor_acrescimo' => $produto['valor_acrescimo'],
                'valor' => $produto_obj->valor_venda
            ]);
        }
        $venda->calcula_valor();

        $ecomerce_pedido = EComercePedido::create([
            'venda_id' => $venda->id, 
            'cliente_id' => $cliente_id,
            'metodo_correio' => $request->venda["metodo_correio"], 
            'status' => 1,
            'data_envio' => null, 
            'codigo_correio' => null
        ]);

        $venda = Venda::with('produto_venda')->find($venda->id);
        return response()->json(compact('venda', 'ecomerce_pedido'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(EComercePedido $ecomerce_pedido)
    {
        return response()->json($ecomerce_pedido);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
