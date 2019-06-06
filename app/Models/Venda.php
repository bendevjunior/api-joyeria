<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Uuid;

use App\User;

class Venda extends Model
{
    protected $table = 'vendas';
    use SoftDeletes;

    protected $fillable = [
        'uuid', 'produto_id', 'cliente_id',
        'qnt', 'preco', 'preco_final', 'preco_do_desconto', 
        'data_pagamento', 'status', 'bf_code', 'bf_reference',
        'bf_link', 'bf_barcode'
    ];

    
    protected $hidden = [
        'id', "created_at", "updated_at", "deleted_at", 'produto_id', 'cliente_id'
    ];

    //run create
    public static function boot() {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public static function find_uuid($uuid) {
        return Consignado::where('uuid', $uuid)->first();
    }

    public function produto() {
        return $this->belongsTo(Produto::class);
    }

    public function cliente() {
        return $this->belongsTo(User::class);
    }

    public function consignado () {
        return $this->belongsTo(Consignado::class);
    }
}
