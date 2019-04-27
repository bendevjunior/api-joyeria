<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Uuid;

class User extends Authenticatable {
    
    protected $table = 'users';
    use Notifiable;
    use SoftDeletes;

    
    protected $fillable = [
        'uuid', 'name', 'email', 'password', 'role', 
        'cpf_cnpj', 'data_nascimento', 'nome_mae',
        'nome_pai', 'endereco_id'
    ];

    protected $hidden = [
        'password', 'remember_token', 'endereco_id'
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
