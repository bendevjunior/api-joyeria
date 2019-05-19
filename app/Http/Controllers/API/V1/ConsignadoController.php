<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Consignado;
use App\User;
use App\Models\Produto;

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
            $produto = Produto::find_uuid($r['produto_uuid']);
            $r['cliente_id'] = $cliente->id;
            $r['produto_id'] = $produto->id;
            Consignado::create($r);
            Produto::remover_do_estoque($produto->id, $r['qnt']);
        }
        return response()->compact(['mensagem'=>'Consignado criado com sucesso']);
    }
}
