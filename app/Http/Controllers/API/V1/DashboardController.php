<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Produto;

class DashboardController extends Controller
{
    /**
     * Retornaos dados para a dashboard, apenas count
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard_count(Request $request)
    {
        $user = User::where('id', '>', 0);
        $produto = Produto::where('qnt', '<=', 'qnt_min');
        if($request->mes != null) {
            $user = $user->whereMonth('created_at', $request->mes);
        }

        if($request->ano != null) {
            $user = $user->whereYear('created_at', $request->ano);
        }
        $user = $user->count();
        $produto_critico = $produto->get();
        $count_produto_critico = $produto->count();
        return response()->json(compact('user', 'produto_critico', 'count_produto_critico'));
    }

    
}
