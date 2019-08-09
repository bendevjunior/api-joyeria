<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class CarrinhoProduto extends Model
{
    protected $table = "carrinhos";

    use LogsActivity;

    /* ******* *** LOGS *** ******* */
    protected static $logFillable = true;

    protected static $logName = 'carrinho_produto';

    protected static $logOnlyDirty = true;

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
