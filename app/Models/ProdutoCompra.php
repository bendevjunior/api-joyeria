<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Uuid;

class ProdutoCompra extends Model {

    protected $table = "produto_compras";
    use SoftDeletes;

    protected $fillable = [
        'uuid', 'produto_id', 'fornecedor_id', 'descricao', 
        'qnt', 'lote', 'valor_unitario', 'valor_total',
        'peso_total', 'data_pagamento', 'data_entrega',
        'numero_nf', 'data_fabricacao', 'galvanica',
        'banho', 'milisimagem_ouro', 'valor etiqueta'
    ];

    
    protected $hidden = [
        'id', "updated_at", "deleted_at"
    ];

    //run create
    public static function boot() {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }


    public static function find_uuid($uuid) {
       return ProdutoCompra::where('uuid', $uuid)->first();
    }

    public function fornecedor() {
        return $this->belongsTo(Fornecedor::class);
    }

    public function produto() {
        return $this->belongsTo(Produto::class);
    }
}
