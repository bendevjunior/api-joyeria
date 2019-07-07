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
use DB;

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
        $venda = Venda::where('cliente_id', $cliente->id)->first();
        if ($request->meio_pagamento == 0) {
            $this->generate_boletos($venda, $request);
        } else if ($request->meio_pagamento == 1 || $request->meio_pagamento == 2) { //apenas envia para o fluxo financeiro
            FluxoFinanceiro::create([
                'cliente_id' => $cliente->id,
                'venda_id' => $venda->id,
                'descricao' => 'Venda #' . $venda->id,
                'data_vencimento' => now()->format('Y-m-d'),
                'valor_da_parcela' => $venda->preco_final,
                'valor_total_venda' => $venda->preco_final,
                'parcela_atual' => 1,
                'total_parcelas' => 1,
                'status' => 0
            ]);
        }
    }


    public function update(Request $request)
    {
        $venda = Venda::find_uuid($request->venda_uuid);
        $venda->update($request->all());
        return response()->json(compact($venda));
    }

    //verifique que permite 
    public function verifique_se_tem_no_estoque($produto, $qnt)
    {
        return $produto->qnt < $qnt ? false : true;
    }
    /**
     * Store a mew venda.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
        $valor = $valor_total / $request->parcelas;
        $payer = new Payer($cliente->nome, $cliente->cpf_cnpj);
        //$payer = new Payer($cliente->nome, '428.338.578-61');
        $charge = new Charge('Boleto de cobrança Joyeria da venda #' . $venda->id, (string) Uuid::generate(4), null, $request->data_vencimento);
        $charge->amount = $valor;
        $charge->installments = $request->parcelas;
        $juno = new JunoService();
        $response = $juno->create_charge($payer, $charge);
        $response = $juno->generate_boleto();
        $i = 1;
        foreach ($response->data->charges as $charge) {
            FluxoFinanceiro::create([
                'cliente_id' => $cliente->id,
                'venda_id' => $venda->id,
                'descricao' => 'Venda #' . $venda->id,
                'data_vencimento' => Carbon::parse($charge->dueDate)->format('Y-m-d'),
                'valor_da_parcela' => $valor,
                'valor_total_venda' => $valor_total,
                'parcela_atual' => $i,
                'total_parcelas' => $request->parcelas,
                'bf_code' => $charge->code,
                'bf_reference' => $charge->reference,
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
    public function show(Request $rq)
    {
        $venda = Venda::with('cliente')
        ->where('uuid', $rq->uuid)
        ->first();

        // uuid = venda => cliente , produtos..
        // object 
        // 3 = 3 (  )

        $produtos = ProdutoVenda::select('produto_id',
            DB::raw('SUM(valor) as valor'), 
            DB::raw('SUM(qnt) as quantidade_total'))
            ->groupBy('produto_id')
            ->where('venda_id', $venda->id)
            ->with('produto')
            ->get();

      //  $produtos = Produto::where('id',)->get();
      //  foreach($venda->produto_venda as $produto){
        //    $p = Produto::find($produto->produto_id);
          //  $produtos[] = $p;
        //}
        
        return response()->json(compact('venda', 'produtos'));
    }

    public function remove_da_venda(Request $request)
    {
        $venda = Venda::where('uuid',$request->venda['uuid'])->first();
        foreach ($request->venda["produtos"] as $produto) {
            $produto_obj = Produto::find($produto['produto_id']);
            
            $produto_venda = ProdutoVenda::where('venda_id', $venda->id)
                ->where('produto_id', $produto_obj->id)
                ->first();
            

            if($request->acao == 0) { //remove o produto da venda
                Produto::adicionar_ao_estoque($produto['produto_id'], $produto_venda->qnt);
                $produto_venda->delete();
            } else {

                if($produto_venda->qnt > $produto['quantidade_add'] ){
                    Produto::adicionar_ao_estoque($produto['produto_id'], $produto['quantidade_add']);
                    $produto_venda->qnt = $produto_venda->qnt - $produto['quantidade_add'];
                    $produto_venda->save();
                }



            }
        }
        $venda->calcula_valor();
        $venda = Venda::with('produto_venda')->find($venda->id);
        return response()->json(compact('venda'));
    }
}
