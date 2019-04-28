<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Uuid;

class Endereco extends Model {
    
    protected $table = 'enderecos'; //table name
    use SoftDeletes;

    protected $fillable = [
        'uuid', 'estado_id', 'cidade_id', 'rua', 'numero', 
        'complemento', 'referencia', 'bairro', 'cep', 'latitude', 
        'logintitude', 'pais'
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
       return Endereco::where('uuid', $uuid)->first();
    }

    //relacionamentos
    public function estado(){
    	return $this->belongsTo(SysEstadoBR::class);
    }

    public function cidade(){
    	return $this->belongsTo(SysCidadeBR::class);
    }

}
