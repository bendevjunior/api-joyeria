<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Uuid;

use App\User;

class Consignado extends Model
{
    protected $table = 'consignados';
    use SoftDeletes;

    protected $fillable = [
        'uuid', 'produto_id', 'cliente_id',
        'qnt', 'qnt_vendido', 'data_devolucao', 'status'
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
}
