<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Uuid;


class Produto extends Model {
    protected $table = 'produtos';
    use SoftDeletes;

    protected $fillable = [
        'uuid', 'nome', 'descricao', 'codigo_de_barras', 'qnt',
        'qnt_min', 'lote', 'valore_bruto', 'valor_banho',
        'valor_venda', 'peso', 'status', 'numero_codigo_de_barras'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id', "created_at", "updated_at", "deleted_at"
    ];

    //run create
    public static function boot() {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }


    public static function find_uuid($uuid) {
       return Produtos::where('uuid', $uuid)->first();
    }

    
}
