<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ProdutoVenda extends Model
{
    use LogsActivity;

    /* ******* *** LOGS *** ******* */
    protected static $logFillable = true;

    protected static $logName = 'produto_venda';

    protected static $logOnlyDirty = true;

    protected $table = 'produto_vendas';
    protected $with  = 'produto';
    public $timestamps = false;
    protected $fillable = [
        'venda_id', 
        'cliente_id', 
        'qnt', 
        'valor_desconto',
        'valor',
        'preco_do_acrescimo',
        'produto_id'
    ];



    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}
