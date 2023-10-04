<?php

namespace Modules\Core\Entities;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class UnitPathFeeManual extends BaseModel
{
    use SoftDeletes;

    protected $table = "unit_path_fee_manual";

    protected static $logName = 'unit_path_fee_manual';
    protected static $logOnlyDirty = true;
    
    public function unit()
    {
        return $this->belongsTo('Modules\Core\Entities\Unit');
    }

    public function path()
    {
        return $this->belongsTo('Modules\Core\Entities\Path');
    }

    public function getByUnitPath($unit_id,$path_id)
    {
        return $this->where('unit_id', $unit_id)->where('path_id', $path_id)->first();
    }
}
