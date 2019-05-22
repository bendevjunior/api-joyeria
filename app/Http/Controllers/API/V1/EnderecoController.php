<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Endereco;
use App\Models\SysEstadoBR;
use App\Models\SysCidadeBR;

class EnderecoController extends Controller {
    
    public function busca_estado(Request $request) {
        //$estado = SysEstadoBR::where('nome', $request->nome)->first();
        $estado = SysEstadoBR::orderby('nome', 'asc')->get();
        return response()->json(compact('estado'));
    }

    public function busca_cidade (Request $request) {
        if($request->nome == null) {
            $list = SysCidadeBR::where('estado_id', $request->estado_id)->orderBy('nome', 'asc')->get();
            return response()->json(compact('list'));
        } else {
            $list = SysCidadeBR::where('estado_id', $request->estado_id)->where('nome', $request->nome)->first();
            return response()->json(compact('list'));
        }
    }

}
