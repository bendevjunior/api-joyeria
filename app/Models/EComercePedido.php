<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Uuid;

class EComercePedido extends Model
{
    protected $table = 'e_comerce_pedidos';
    use SoftDeletes;

    protected $fillable = [
        'uuid', 'venda_id', 'cliente_id','metodo_correio', 'status',
        'data_envio', 'codigo_correio'
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

    public function venda() {
        return $this->belongsTo(Venda::class);
    }

    public function cliente() {
        return $this->belongsTo(User::class);
    }
}
