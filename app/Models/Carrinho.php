<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Uuid;
use App\User;
use Spatie\Activitylog\Traits\LogsActivity;

class Carrinho extends Model
{
    protected $table = "carrinhos";

    use SoftDeletes;
    use LogsActivity;

    /* ******* *** LOGS *** ******* */
    protected static $logFillable = true;

    protected static $logName = 'carrinho';

    protected static $logOnlyDirty = true;

    protected $fillable = [
        'uuid', 
        'venda_id',
        'cliente_id', 
        'status',
        'valor'
    ];

    //run create
    public static function boot() {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public function cliente () {
        return $this->belongsTo(User::class);
    }
    
    public function produtos () {
        return $this->hasMany(CarrinhoProduto::class, 'carrinho_id');
    }

    public static function calcula_valor ($carrinho_id) 
    {
        $carrinho = Carrinho::find($carrinho_id);
        $valor = 0;
        foreach(CarrinhoProduto::where('carrinho_id', $carrinho_id)->get() as $produto_carrinho) {
            $valor = $valor + $produto_carrinho->qnt * $produto_carrinho->produto->valor_venda;
        }
        $carrinho->valor = $valor;
        return $valor;
    }

}
