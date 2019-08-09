<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;
use Spatie\Activitylog\Traits\LogsActivity;

class FluxoFinanceiro extends Model
{
    protected $table = 'fluxo_financeiros';
    use SoftDeletes;
    use LogsActivity;

    /* ******* *** LOGS *** ******* */
    protected static $logFillable = true;

    protected static $logName = 'fluxo_financeiro';

    protected static $logOnlyDirty = true;

    protected $fillable = [
        'uuid', 
        'cliente_id',
        'venda_id',
        'descricao',
        'data_vencimento',
        'valor_da_parcela',
        'valor_total_venda',
        'parcela_atual',
        'total_parcelas',
        'bf_code',
        'bf_reference',
        'bf_link',
        'bf_barcode',
        'status'
    ];

    
    protected $hidden = [
        'id', "created_at", "updated_at", "deleted_at", 'cliente_id'
    ];

    //run create
    public static function boot() {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public static function find_uuid($uuid) {
        return FluxoFinanceiro::where('uuid', $uuid)->first();
    }

    public function cliente()
    {
        return $this->belongsTo(User::class);
    }

    public function venda()
    {
        return $this->belongsTo(Venda::class);
    }

    
}
