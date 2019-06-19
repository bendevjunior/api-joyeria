<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FluxoFinanceiro;
use App\User;

class FinanceiroController extends Controller
{
    public function store(Request $request)
    {
        if($request->cliente_uuid) {
            $cliente = User::find_uuid($request->cliente_uuid);
            $request->merge([
                'cliente_id' => $cliente->id
            ]);
        }
        $fluxo_financeiro =  FluxoFinanceiro::create($request->all());
        return response()->json($fluxo_financeiro);
    }

    public function update(Request $request, $fluxo_financeiro_uuid)
    {
        $fluxo_financeiro = FluxoFinanceiro::find_uuid($fluxo_financeiro_uuid);
        $fluxo_financeiro->update($request->all());
        return response()->json($fluxo_financeiro);
    }

    public function index($inicio, $fim)
    {
        $fluxoFinanceiro = FluxoFinanceiro::where('created_at', '>=', $inicio)
            ->where('created_at', '<=', $fim)
            ->with('cliente', 'venda')->get();
        return response()->json($fluxoFinanceiro);
    }
}
