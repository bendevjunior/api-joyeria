<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PivoProdutoFornecedor extends Model {
    protected $table = 'pivo_produto_fornecedors';
    public $timestamps = false;
    protected $fillable = ['produto_id', 'fornecedor_id'];
}
