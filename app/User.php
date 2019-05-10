<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;


use Uuid;

use App\Models\Endereco;

class User extends Authenticatable implements JWTSubject {

    protected $table = 'users';
    use Notifiable;
    use SoftDeletes;

    
    protected $fillable = [
        'uuid', 'nome', 'email', 'password', 'role', 
        'cpf_cnpj', 'data_nascimento', 'nome_mae',
        'nome_pai', 'endereco_id', 'status', 'api_token', 'tel1', 'tel2'
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







    /* *** FOR API *** */

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }


    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token) {
        $this->notify(new CustomResetPassword($token, $this->email));
    }
}
