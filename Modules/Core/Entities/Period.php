<?php

namespace Modules\Core\Entities;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Period extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "periods";

    protected static $logName = 'periods';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['period_name', 'id'];
    protected $fillable = [];
    
    public function registrants()
    {
        return $this->hasMany('Modules\Registrant\Entities\Registrant')->ThisPeriod(my_period());
    }

    public static function findActivePeriodId()
    {
        $period = Period::where('active_state',true)->first();
        if($period)
            return $period->id;
        else
            return null;
    }
    
    protected static function newFactory()
    {
        return \Modules\Core\Database\factories\PeriodFactory::new();
    }
}
