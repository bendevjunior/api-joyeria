<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Produto;
use App\Models\ProdutoFoto;
use App\Models\Fornecedor;
use App\Models\PivoProdutoFornecedor;
use App\Models\ProductCategory;
use App\Models\ProdutoColecao;

class ProdutoController extends Controller
{

    public function index()
    {
        $produtos = Produto::where('status', 1)->orderBy('nome', 'asc')
            ->with('categoria')->get();
        foreach ($produtos as $produto) {
            $produto->ultima_compra = $produto->ultima_compra();
        }
        return response()->json(compact('produtos'));
    }
    public function store(Request $request)
    {


        $produto = $request["produto"];
        $categoria = ProductCategory::find_uuid($produto['categoria_uuid']);
        $colecao = ProdutoColecao::find_uuid($produto['colecao_uuid']);
        $produto['categoria_id'] = $categoria->id;
        $produto['colecao_id'] = $colecao->id;
        $produto = Produto::create($produto);
        $produto->numero_codigo_de_barras = str_pad($produto->id, 13, '0', STR_PAD_LEFT);
        $produto->save();
        $produto = Produto::find($produto->id);
        if ($request["fotos"] != null) {
            foreach ($request["fotos"] as $foto) {
                ProdutoFoto::create([
                    'produto_id' => $produto->id,
                    'url' => $foto['foto']
                ]);
            }
        }
        $categoria = $produto->categoria;
        $colecao = $produto->colecao;
        return response()->json(compact('produto'));
    }

    public function store_update_fornecedor(Request $request)
    {
        $produto = Produto::find_uuid($request['produto_uuid']);
        PivoProdutoFornecedor::where('produto_id', $produto->id)->delete();
        foreach ($request['fornecedores'] as $fornecedor_uuid) {
            $fornecedor = Fornecedor::find_uuid($fornecedor_uuid["fornecedor_uuid"]);
            PivoProdutoFornecedor::create([
                'produto_id'    => $produto->id,
                'fornecedor_id' => $fornecedor->id
            ]);
        }
        return response()->json(['success' => 'Fornecedor vinculado com sucesso']);
    }

    public function show(Request $request)
    {
        if (is_null($request->produto_uuid)) {
            //list all
            $produto = Produto::where('status', 1)->with('foto', 'categoria', 'colecao')->get();
        } else {
            $produto = Produto::find_uuid($request->produto_uuid);
            $produto_fornecedor = $produto->fornecedores;
            $produto_foto = $produto->foto;
            $categoria = $produto->categoria;
            $colecao = $produto->colecao;
        }
        return response()->json(compact('produto'));
    }


    public function  mostrar(Request $request)
    {

        $produto = Produto::where('nome', $request->nome)->where('status', 1)->with('foto', 'categoria', 'colecao')->first();
        $ultima_compra = $produto->UltimaCompra;
        return response()->json(compact('produto', 'ultima_compra'));
    }

    public function store_foto(Request $request)
    {
        $produto = Produto::find($produto->id);
        ProdutoFoto::create([
            'produto_id' => $produto->id,
            'url' => $request->foto
        ]);
        return response()->json(compact('produto'));
    }

    public function destroy_foto(Request $request)
    {
        $ProdutoFoto = ProdutoFoto::find_uuid($request->uuid);
        $ProdutoFoto->delete();
        return response()->json(['sucesso' => 'imagem deletada com sucesso']);
    }

    public function categoria_store(Request $request)
    {
        $productCategory = ProductCategory::create($request->all());
        return response()->json(compact('productCategory'));
    }

    public function categoria_update(Request $request)
    {
        $productCategory = ProductCategory::find_uuid($request->uuid);
        $productCategory->update($request->all());
        return response()->json(compact('productCategory'));
    }

    public function categoria_index(Request $request)
    {
        //$categoria = ProductCategory::where('status', 1)->orderBy('nome', 'asc')->with('produto')->get();
        $categorias = ProductCategory::where('status', 1)->orderBy('nome', 'asc')->get();
        foreach($categorias as $categoria) {
            $categoria->qnt = $categoria->QntProduto;
        }
        return response()->json(compact('categorias'));
    }

    public function categoria_produto(Request $request)
    {
        $categoria = ProductCategory::find_uuid($request->uuid);
        $produto = Produto::where('categoria_id', $categoria->id)->orderBy('nome', 'asc')->with('foto', 'colecao')->get();
        $qnt = $produto->count();
        return response()->json(compact('qnt', 'produto'));
    }

    public function colecao_store(Request $request)
    {
        $productCategory = ProdutoColecao::create($request->all());
        return response()->json(compact('productCategory'));
    }

    public function colecao_update(Request $request)
    {
        $produtoColecao = ProdutoColecao::find_uuid($request->uuid);
        $produtoColecao->update($request->all());
        return response()->json(compact('produtoColecao'));
    }

    public function colecao_index(Request $request)
    {
        $colecoes = ProdutoColecao::where('status', 1)->orderBy('nome', 'asc')->get();
        foreach($colecoes as $colecao) {
            $colecao->qnt = $colecao->QntProduto;
        }
        return response()->json(compact('colecao'));
    }

    public function colecao_produto(Request $request)
    {
        $colecao = ProdutoColecao::where('nome', $request->nome)->first();
 
        $produto = Produto::where('colecao_id', $colecao->id)->orderBy('nome', 'asc')->with('foto', 'colecao')->get();
        $qnt = $produto->count();
        return response()->json(compact('qnt', 'produto'));
    }
}
