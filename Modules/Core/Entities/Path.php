<?php

namespace Modules\Core\Entities;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;

class Path extends BaseModel
{
    use HasFactory;

    protected $table = "paths";

    protected static $logName = 'paths';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['name', 'id'];
    
    protected static function newFactory()
    {
        return \Modules\Core\Database\factories\UnitFactory::new();
    }
}
