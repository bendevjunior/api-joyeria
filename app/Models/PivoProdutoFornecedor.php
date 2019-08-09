<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class PivoProdutoFornecedor extends Model {

    use LogsActivity;

    /* ******* *** LOGS *** ******* */
    protected static $logFillable = true;

    protected static $logName = 'pivo_produto_fornecedor';

    protected static $logOnlyDirty = true;

    protected $table = 'pivo_produto_fornecedors';
    public $timestamps = false;
    protected $fillable = ['produto_id', 'fornecedor_id'];    
}
