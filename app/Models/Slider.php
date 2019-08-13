<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Slider extends Model
{
    use LogsActivity;
    /* ******* *** LOGS *** ******* */
    protected static $logFillable = true;

    protected static $logName = 'slider';

    protected static $logOnlyDirty = true;  
    protected $table = 'slider';
    protected $fillable = ['img', 'texto', 'titulo', 'url','visivel'];
    
    protected $hidden = [
      "created_at", "updated_at", "deleted_at"
    ];
}
