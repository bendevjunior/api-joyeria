<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Str;

use App\Models\Produto;
use App\Models\ProdutoFoto;
use App\Models\Fornecedor;
use App\Models\PivoProdutoFornecedor;
use App\Models\ProductCategory;
use App\Models\ProdutoColecao;
use App\Models\ProdutoCompra;
use App\Models\ProdutoVenda;

class ProdutoController extends Controller
{

    public function index_produto()
    {
        $produtos = Produto::where('status', 1)->orderBy('nome', 'asc')
            ->with('categoria')->get();
        foreach ($produtos as $produto) {
            $produto->ultima_compra = $produto->ultima_compra();
        }
        return response()->json(compact('produtos'));
    }
    public function desabilita(Request $request)
    {
        $produto = Produto::find_uuid($request->uuid);
        $produto->status = 0;
        $produto->update();
        return response()->json(['success' => 'produto desabilitado com sucesso']);
    }

    public static function base64_to_image($b64, $path) {
        $output = realpath(dirname('../')) . $path;
            
        list($type, $data) = explode(';', $b64);
        list(, $data) = explode(',', $b64);
        $data = base64_decode($data);
        file_put_contents($output, $data);
     
        return [
            'success' => file_exists($output),
            'paths' => [
                'relative' => $path,
                'absolute' => $output
            ]
        ];
    }

    public function store(Request $request){


        $produto = $request["produto"];
        $produto->numero_codigo_de_barras = str_pad($produto->id, 13, '0', STR_PAD_LEFT);
        $produto->codigo_de_barras = str_pad($produto->id, 13, '0', STR_PAD_LEFT);
        $produto = Produto::create($produto);
        $produto = Produto::find($produto->id);
        if ($request["fotos"] != null) {
            foreach ($request["fotos"] as $foto) {
                ProdutoFoto::create([
                    'produto_id' => $produto->id,
                    'url' => $foto['foto']
                ]);
            }

            $categoria = $produto->categoria;
            $colecao = $produto->colecao;
            return response()->json(compact('produto'));
        }
    }
    
    public function storeComImagem(Request $request){


        $produto = $request["produto"];
        $i = rand();
       // $produto->codigo_de_barras = 11111;// str_pad($i, 13, '0', STR_PAD_LEFT);
        $img_name = (string) Str::uuid() . '.png';
        $produto = $this->base64ToImage($produto->primeira_imagem, 'img/'.$img_name);
        $produto = Produto::create($produto);
        if ($request["fotos"] != null) {
            foreach ($request["fotos"] as $foto) {
                $img_name = (string) Str::uuid() . '.png';
                $img = $this->base64ToImage($request['foto'], 'img/'.$img_name);
                ProdutoFoto::create([
                    'produto_id' => $produto->id,
                    'url' => 'img/'.$img_name
                ]);
            }

            $categoria = $produto->categoria;
            $colecao = $produto->colecao;
            return response()->json(compact('produto'));
        }
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

    public function show_administrativo(Request $request)
    {
        if (is_null($request->produto_uuid)) {
            //list all
            $produto = Produto::with('foto', 'categoria', 'colecao')->get();
        } else {
            $produto = Produto::find_uuid($request->produto_uuid);
            $produto_fornecedor = $produto->fornecedores;
            $produto_foto = $produto->foto;
            $categoria = $produto->categoria;
            $colecao = $produto->colecao;
        }
        return response()->json(compact('produto'));
    }

    public function show_unic_product(Request $request){
        $produto = Produto::find_uuid($request->uuid);
        return response()->json($produto);
    }

    public function  mostrar(Request $request)
    {

        $produto = Produto::where('nome', $request->nome)->where('status', 1)->with('foto', 'categoria', 'colecao')->first();
        
        if($produto != null) {
            $ultima_compra = $produto->ultima_compra;
        }
        return response()->json(compact('produto', 'ultima_compra'));
    }
    

    public function store_foto(Request $request)
    {
        $produto = Produto::find($request->id);
        ProdutoFoto::create([
            'produto_id' => $produto->id,
            'url' => $request->foto
        ]);
        return response()->json(compact('produto'));
    }
    
    public function store_foto_img(Request $request)
    {
        $img = 'tmp/' . (string) Str::uuid() . '.png';
        $this->base64ToImage($request->foto, $img);
        $produto = Produto::find($request->id);
        ProdutoFoto::create([
            'produto_id' => $produto->id,
            'url' => $img
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
        foreach ($categorias as $categoria) {
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
        return response()->json($productCategory);
    }

    public function colecao_store_com_img(Request $request)
    {
        $img = 'img/' . (string) Str::uuid() . '.png';
        $this->base64ToImage($request->img, $img);
        $request->merge(['img'=>$img]);
        $productCategory = ProdutoColecao::create($request->all());
        return response()->json($productCategory);
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
        foreach ($colecoes as $colecao) {
            $colecao->qnt = $colecao->QntProduto;
        }
        return response()->json(compact('colecoes'));
    }

    public function colecao_produto(Request $request)
    {
        $colecao = ProdutoColecao::where('nome', $request->nome)->first();

        $produto = Produto::where('colecao_id', $colecao->id)->orderBy('nome', 'asc')->with('foto', 'colecao')->get();
        $qnt = $produto->count();
        return response()->json(compact('qnt', 'produto'));
    }

    public function categoria_produto_nome(Request $request)
    {
        $categoria = ProductCategory::where('nome', $request->nome)->first();

        $produto = Produto::where('categoria_id', $categoria->id)->orderBy('nome', 'asc')->with('foto', 'colecao')->get();
        $qnt = $produto->count();
        return response()->json(compact('qnt', 'produto'));
    }

    public function colecao_com_produto_list()
    {
        $productColection = ProdutoColecao::where('status', 1)->with('produto')->get();
        return response()->json(compact('productColection'));
    }

    //update
    public function update(Request $request)
    {
        
       $produto = Produto::find_uuid($request->produto['uuid']);
       
        $produto->update($request->produto);
        return response()->json($produto);
    }

    public function mais_vendidos()
    {
        $retorno = [];
        foreach(Produto::all() as $p) {
            $produto_venda = ProdutoVenda::where('produto_id', $p->id)->get();
            if($produto_venda) {
                $retorno[] = [
                    'nome' => $p->nome,
                    'qnt' => $produto_venda->sum('qnt')
                ];
            }
            
        }
        return response()->json($retorno);
        
    }

    public function mais_recentes()
    {
        $produtos = Produto::orderBy('id', 'desc')->limit(4)->get();
        return response()->json($produtos);
    }
}
