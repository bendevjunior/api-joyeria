<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdutoVenda extends Model
{
    protected $table = 'produto_vendas';
    public $timestamps = false;
    protected $fillable = [
        'venda_id', 
        'cliente_id', 
        'qnt', 
        'valor_desconto',
        'valor',
        'preco_do_acrescimo'
    ];

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}
