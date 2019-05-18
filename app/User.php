<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;


use Uuid;

use App\Models\Endereco;

class User extends Authenticatable {

    protected $table = 'users';
    use Notifiable, HasApiTokens;
    use SoftDeletes;

    
    protected $fillable = [
        'uuid', 'nome', 'email', 'password', 'role', 
        'cpf_cnpj', 'data_nascimento', 'nome_mae',
        'nome_pai', 'endereco_id', 'status', 'api_token', 
        'tel1', 'tel2', 'obs', 'status_spc'
    ];

    protected $hidden = [
        'password', 'remember_token', 'endereco_id', 'deleted_at',
        'created_at', 'updated_at', 'id'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //run create
    public static function boot() {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public static function find_uuid ($uuid) {
        return User::where('uuid', $uuid)->first();
    }


    //relationship
    public function endereco() {
        return$this->belongsTo(Endereco::class);
    }





}
