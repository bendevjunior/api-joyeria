<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Mail\ConfirmEmailAddress;
use Mail;

use App\User;
use App\Models\Material;
use App\Models\Empresa;
use App\Models\Endereco;
use App\Models\Solicitacoes;
use App\Models\TransacaoDePonto;

class solicitacaoController extends Controller {

    //metodo para cliente

    public function get_solicitacao(Request $request) {
        $solicitacao = Solicitacoes::where('solicitacoes.cliente_id', auth()->user()->id)
            ->join('empresas', 'empresas.id', '=', 'solicitacoes.empresa_id')
            ->join('materiais', 'materiais.id', '=', 'solicitacoes.material_id')
            ->orderBy('solicitacoes.id', 'desc')
            ->select('empresas.nome AS empresa_nome', 'materiais.nome as material_nome', 'solicitacoes.*')
            ->get();
        return response()->json(compact('solicitacao'));
    }

    public function store_solicitacao(Request $request) {
        $solicitacao = Solicitacoes::create($request->all());
        return response()->json(compact('solicitacao'));
    }

    public function cliente_cancelar_solicitacao(Request $request) {
        $solicitacao = Solicitacoes::find_uuid($request->solicitacao_uuid);
        if($solicitacao->cliente_id != auth()->user()->id || $solicitacao->status != 1) {
            return response()->json(['error'=>'Você não tem permissao para essa acao'], 403);
        }
        $solicitacao->status = 0;
        $solicitacao->save();
        return response()->json(compact('solicitacao'));
    }











    //metodo para dono do ferro velho
    public function get_empresa_solicitacao(Request $request) {

        $solicitacao = Solicitacoes::where('solicitacoes.empresa_id', auth()->user()->empresa_id)
            ->join('users', 'users.id', '=', 'solicitacoes.cliente_id')
            ->join('materiais', 'materiais.id', '=', 'solicitacoes.material_id')
            ->orderBy('solicitacoes.id', 'desc')
            ->select('users.name AS cliente_nome', 'materiais.nome as material_nome', 'solicitacoes.*')
            ->get();
        return response()->json(compact('solicitacao'));
    }

    public function empresa_start_busca(Request $request) {
        $solicitacao = Solicitacoes::find_uuid($request->solicitacao_uuid);
        if($solicitacao->empresa_id != auth()->user()->empresa_id) {
            return response()->json(['error'=>'Você não tem permissao para essa acao'], 403);
        }
        $solicitacao->status = 2;
        $solicitacao->save();
        return response()->json(compact('solicitacao'));
    }



    public function empresa_cancelar(Request $request) {
        $solicitacao = Solicitacoes::find_uuid($request->solicitacao_uuid);
        if($solicitacao->empresa_id != auth()->user()->empresa_id) {
            return response()->json(['error'=>'Você não tem permissao para essa acao'], 403);
        }
        $solicitacao->status = 0;
        $solicitacao->save();
        return response()->json(compact('solicitacao'));
    }



    public function empresa_coletado (Request $request) {
        $solicitacao = Solicitacoes::find_uuid($request->solicitacao_uuid);
        if($solicitacao->empresa_id != auth()->user()->empresa_id) {
            return response()->json(['error'=>'Você não tem permissao para essa acao'], 403);
        }
        $solicitacao->status = 3;
        $solicitacao->save();
        return response()->json(compact('solicitacao'));
    }

    public function empresa_concluir (Request $request) {
        $solicitacao = Solicitacoes::find_uuid($request->solicitacao_uuid);
        if($solicitacao->empresa_id != auth()->user()->empresa_id || $solicitacao->status != 3) {
            return response()->json(['error'=>'Você não tem permissao para essa acao'], 403);
        }
        $solicitacao->status = 4;
        $solicitacao->qnt_pontos = $request->qnt_pts;
        $solicitacao->save();

        TransacaoDePonto::registro_historico ($solicitacao->id, $request->qnt_pts);
        User::update_pts($solicitacao->cliente_id, $request->qnt_pts);
        return response()->json(compact('solicitacao'));
    }

}
