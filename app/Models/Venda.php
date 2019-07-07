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
        'bf_link', 'bf_barcode', 'fluxo_financeiro_id',
        'preco_do_acrescimo'
    ];

    
    protected $hidden = [
        "updated_at", "deleted_at", 'produto_id', 'cliente_id'
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

    public function fluxo_financeiro()
    {
        return $this->hasMany(FluxoFinanceiro::class, 'venda_id');
    }

    public function produto_venda() {
        return $this->hasMany(ProdutoVenda::class, 'venda_id');
    }
    
    

    public function calcula_valor()
    {   
        $valor_final = 0;
        $ProdutoVenda = ProdutoVenda::where('venda_id', $this->id)->where('qnt', '>', 0)->get();
        foreach($ProdutoVenda as $pv) {
            $valor_final += $pv->qnt * $pv->valor;
        }
        $venda = Venda::find($this->id);
        $desconto = $ProdutoVenda->sum('valor_desconto');
        $venda->preco_do_desconto = $desconto;
        $venda->preco_final = $valor_final - $ProdutoVenda->sum('valor_desconto');
        $venda->save();
    }
}
