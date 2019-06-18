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
}
