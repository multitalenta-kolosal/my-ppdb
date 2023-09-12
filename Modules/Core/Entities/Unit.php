<?php

namespace Modules\Core\Entities;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Unit extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "units";

    protected static $logName = 'units';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['name', 'id'];
    
    public function registrants()
    {
        return $this->hasMany('Modules\Registrant\Entities\Registrant')->ThisPeriod(my_period());
    }

    public function tier()
    {
        return $this->hasMany('Modules\Core\Entities\Unit');
    }

    public function unit_path_fees()
    {
        return $this->hasMany('Modules\Core\Entities\UnitPathFee');
    }

    protected static function newFactory()
    {
        return \Modules\Core\Database\factories\UnitFactory::new();
    }
}
