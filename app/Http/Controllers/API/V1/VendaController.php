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

class VendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function complete_cliente(Request $request, $cliente_uuid)
    {
        $venda = Venda::where('cliente_id', auth()->user()->id)->get();
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

        $venda = Venda::create([
            'produto_id' => $produto->id, 
            'cliente_id' => $cliente_id,
            'qnt' => $data['qnt'], 
            'preco' => $produto->valor_venda * $data['qnt'], 
            'preco_final' => ($produto->valor_venda * $data['qnt']) - $data['preco_do_desconto'], 
            'preco_do_desconto' => $data['preco_do_desconto'], 
            'status' => 0
        ]);

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
    private function generate_boletos($vendas, $request)
    {
        $cliente = $vendas[0]->cliente;
        $valor = $vendas->sum('preco_final');
        $payer = new Payer($cliente->nome, $cliente->cpf_cnpj);
        $charge = new Charge('Descricao', 'referencia', 10.00, $request->data_vencimento);
        $charge->totalAmount = $valor;
 
        $juno = new JunoService();
        //$response = $juno->create_charge($payer, $charge);
        //$response = $juno->generate_boleto();
        
        //dd($response->data->charges);

        foreach($vendas as $venda) {
            $venda->data_pagamento = $request->data_vencimento;
            FluxoFinanceiro::create([
                'cliente_id' => $cliente->id,
                'venda_id' => $venda->id,
                'descricao' => "Venda",
                'data_vencimento' => $request->data_vencimento,
                'valor_da_parcela' => $valor/$request->parcelas,
                'valor_total_venda'=>$valor,
                //'parcela_atual' => ,
                'total_parcelas' => $request->parcelas,
            'status'
            ]);
        }
    }
}
