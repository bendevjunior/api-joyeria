<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
   
    protected $table = 'slider';
    protected $fillable = ['img', 'texto', 'titulo', 'url','visivel'];
    
    protected $hidden = [
      "created_at", "updated_at", "deleted_at"
    ];
}
