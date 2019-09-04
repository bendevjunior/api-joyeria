<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Uuid;

class Documento extends Model
{
    protected $table = 'documentos';
    use SoftDeletes;
    use LogsActivity;

    /* ******* *** LOGS *** ******* */
    protected static $logFillable = true;

    protected static $logName = 'consignado';

    protected static $logOnlyDirty = true;

    protected $fillable = [
        'uuid', 'user_id', 'documento'
    ];


    protected $hidden = [
        'id', "created_at", "updated_at", "deleted_at",
    ];

    //run create
    public static function boot() {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public static function find_uuid($uuid) {
        return Documento::where('uuid', $uuid)->first();
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
