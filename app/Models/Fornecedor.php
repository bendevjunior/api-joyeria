<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Uuid;

class Fornecedor extends Model {
    protected $table = 'fornecedores';
    use SoftDeletes;

    protected $fillable = [
        'uuid', 'endereco_id', 'nome', 'email', 'cpf_cnpj', 'nome_contato',
        'tel1','tel2', 'website', 'obs', 'status'
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
       return Fornecedor::where('uuid', $uuid)->first();
    }

    public function endereco() {
        return $this->belongsTo(Endereco::class);
    }
}
