<?php

namespace Modules\Core\Entities;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Tier extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "tiers";

    protected static $logName = 'tiers';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['name', 'id'];
    
    public function registrants()
    {
        return $this->hasMany('Modules\Registrant\Entities\Registrant')->ThisPeriod(session('period'));
    }

    public function unit()
    {
        return $this->belongsTo('Modules\Core\Entities\Unit');
    }

    protected static function newFactory()
    {
        return \Modules\Core\Database\factories\TierFactory::new();
    }
}
