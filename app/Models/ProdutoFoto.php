<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Uuid;
use Spatie\Activitylog\Traits\LogsActivity;

class ProdutoFoto extends Model {
    use LogsActivity;

    /* ******* *** LOGS *** ******* */
    protected static $logFillable = true;

    protected static $logName = 'produto_foto';

    protected static $logOnlyDirty = true;

    protected $table = 'produto_fotos';
    public $timestamps = false;
    protected $fillable = ['uuid', 'produto_id', 'url'];

    protected $hidden = [
        'id'
    ];

    //run create
    public static function boot() {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }


    public static function find_uuid($uuid) {
       return ProdutoFoto::where('uuid', $uuid)->first();
    }
}
