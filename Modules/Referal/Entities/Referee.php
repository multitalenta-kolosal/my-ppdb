<?php

namespace Modules\Referal\Entities;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Referee extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "referees";

    protected static $logName = 'referees';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['name', 'id'];
    
    public function registrants()
    {
        // return $this->hasMany('Modules\Registrant\Entities\Registrant');
    }
    
    protected static function newFactory()
    {
        return \Modules\Referal\Database\factories\RefereeFactory::new();
    }
}
