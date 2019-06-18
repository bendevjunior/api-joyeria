<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Venda;
use App\Models\Produto;
use App\User;

use App\Service\Juno\JunoService;
use App\Service\Juno\Support\Charge;
use App\Service\Juno\Support\Payer;
use App\Models\FluxoFinanceiro;
use App\Models\ProdutoVenda;
use Uuid;
use Carbon\Carbon;

class VendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function complete_cliente(Request $request, $cliente_uuid)
    {
        $cliente = User::find_uuid($cliente_uuid);
        $venda = Venda::where('cliente_id', $cliente->id)->get();
        if($request->meio_pagamento == 0) {
            $this->generate_boletos($venda, $request);
        } else {

        }
        
    }

    
    public function update(Request $request)
    {
        $venda = Venda::find_uuid($request->venda_uuid);
        $venda->update($request->all());
        return response()->json(compact($venda));
    }

    /**
     * Store a mew venda.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->venda;
        $produto = Produto::find_uuid($data['produto_uuid']);
        if(isset($data['cliente_uuid']) && $data['cliente_uuid']) {
            $cliente = User::find_uuid($data['cliente_uuid']);
            $cliente_id = $cliente->id;
        } else {
            $cliente_id = auth()->user()->id;
            $cliente = auth()->user();
        }
        
        if(auth()->user() != null && auth()->user()->role != 1) {
            $data['preco_do_desconto'] = 0;
        }

        $preco_desconto = $data['preco_do_desconto'] ?? 0;
        $existVenda = Venda::where('cliente_id', $cliente_id)->where('status', 0)->get();
        if ($existVenda->count() == 0) {
            $venda = Venda::create([
                'cliente_id' => $cliente_id,
                'preco' => 0,
                'preco_final' => 0,
                'preco_do_desconto' => 0,
                'status' => 0
            ]);
        } else {
            $venda = $existVenda[0];
        }
        ProdutoVenda::create([
            'qnt' => $request->qnt,
            'venda_id' => $venda->id,
            'qnt' => $data['qnt'],
            'cliente_id' => $cliente_id,
            'valor_desconto' => $preco_desconto,
            'valor' => $produto->valor_venda * $data['qnt']
        ]);
        $venda->calcula_valor();
        $venda = Venda::find($venda->id);
        return response()->json(compact('venda'));
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        $venda = Venda::find_uuid($uuid);
        $venda->delete();
        return response()->json(compact($venda));
    }

    //update boletos e rotorna os boletos
    private function generate_boletos($venda, $request)
    {
        $venda = $venda[0];
        $produto_venda = $venda->produto_venda;
        $cliente = $venda->cliente;
        $valor_total = $venda->preco_final;
        $valor = $valor_total/$request->parcelas;
        //$payer = new Payer($cliente->nome, $cliente->cpf_cnpj);
        $payer = new Payer($cliente->nome, '428.338.578-61');
        $charge = new Charge('Boleto de cobrança Joyeria da venda #'. $venda->id, (string) Uuid::generate(4), null, $request->data_vencimento);
        $charge->amount = $valor;
        $charge->installments = $request->parcelas;
        $juno = new JunoService();
        $response = $juno->create_charge($payer, $charge);
        $response = $juno->generate_boleto();
        $i=1;
        foreach($response->data->charges as $charge) {
            FluxoFinanceiro::create([
                'cliente_id'=>$cliente->id,
                'venda_id'=>$venda->id,
                'descricao' => 'Venda #'.$venda->id,
                'data_vencimento'=>Carbon::parse($charge->dueDate)->format('Y-m-d'),
                'valor_da_parcela'=>$valor,
                'valor_total_venda'=>$valor_total,
                'parcela_atual' => $i,
                'total_parcelas' => $request->parcelas,
                'bf_code'=>$charge->code,
                'bf_reference'=>$charge->reference,
                'bf_link' => $charge->link,
                'bf_barcode' => $charge->billetDetails->barcodeNumber,
                'status' => 0
            ]);
            $i++;
        }
        $venda->status = 1;
        $venda->save();
        return response()->json(['Venda encerrada com sucesso']);
        
        
    }
}
