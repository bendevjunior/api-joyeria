<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Consignado;
use App\User;
use App\Models\Produto;
use App\Models\Venda;

class ConsignadoController extends Controller
{
    public function index () {
        $consignados = Consignado::where('status', 0)
            //->groupBy('cliente_id')
            ->with('cliente', 'produto')
            ->get();
        return response()->json(compact('consignados'));
    }

    public function store (Request $request) {
        
        foreach($request->all() as $r) {
            $cliente = User::find_uuid($r['cliente_uuid']);
            $produto = Produto::find_uuid($r['uuid']);
            $r['cliente_id'] = $cliente->id;
            $r['produto_id'] = $produto->id;
            Consignado::create($r);
            Produto::remover_do_estoque($produto->id, $r['qnt']);
        }
        return response()->compact(['mensagem'=>'Consignado criado com sucesso']);
    }
    
    public function venda_consignado (Request $request) {
        $consignado = Consignado::find_uuid($request->consignado_uuid);
        //valor_venda
        $valor_total = $consignado->produto->valor_venda * $request->qnt;
        $valor_final = $valor_total - $request->preco_do_desconto;
        Venda::create([
            'produto_id' => $consignado->produto->id, 
            'cliente_id' => $consignado->cliente->id,
            'consignado_id' => $consignado->id,
            'qnt' => $request->qnt, 
            'preco' => $valor_total, 
            'preco_final' => $valor_final, 
            'preco_do_desconto' => $request->preco_do_desconto == null ? 0 : $request->preco_do_desconto, 
            //'data_pagamento' => $request->data_pagamento == null ? Carbon::now()->format('Y-m-d') : $request->data_pagamento,
            'status' => 0 // sempre sera zero pois ora gerar boleto no final
        ]);
        $consignado->qnt_vendido = $request->qnt;
        $consignado->data_devolucao = Carbon\Carbon::now()->format('Y-m-d');
        $consignado->status = 1;
        $consignado->save();
        Produto::adicionar_ao_estoque($consignado->produto->id, ($consignado->qnt - $request->qnt)); // retorna  ao estoque
        //aqui salva toda venda para gerar depois tudo unido
        return response()->json(['mensagem'=>'Consignado finalizado com sucesso']);
    }
}
