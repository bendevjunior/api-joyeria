<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarrinhoProduto extends Model
{
    protected $table = "carrinhos";

    protected $fillable = [
        'carrinho_id', 
        'produto_id',
    ];

    public function carrinho() {
        return $this->belongsTo(Carrinho::class);
    }

}
