<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarrinhoProduto extends Model
{
    protected $table = "carrinhos";

    protected $fillable = [
        'carrinho_id', 
        'produto_id',
        'qnt'
    ];

    public function carrinho() {
        return $this->belongsTo(Carrinho::class);
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

}
