<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Uuid;
use App\User;

class Carrinho extends Model
{
    protected $table = "carrinhos";

    use SoftDeletes;

    protected $fillable = [
        'uuid', 
        'venda_id',
        'cliente_id', 
        'status'
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

}
