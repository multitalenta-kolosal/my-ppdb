<?php

namespace Modules\Referal\Entities;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Referee extends BaseModel
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    protected $table = "referees";

    protected static $logName = 'referees';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['name', 'id'];
    
    public function registrants()
    {
        return $this->hasMany('Modules\Registrant\Entities\Registrant','ref_code','ref_code')
                    ->join('registrant_stages', 'registrant_stages.id', '=', 'registrants.progress_id')
                    ->orderBy('registrant_stages.accepted_pass','desc');
    }

    public function verified_registrants()
    {
        return $this->hasMany('Modules\Registrant\Entities\Registrant','ref_code','ref_code')
                    ->join('registrant_stages', 'registrant_stages.id', '=', 'registrants.progress_id')
                    ->where('registrant_stages.accepted_pass',true);
    }
    
    protected static function newFactory()
    {
        return \Modules\Referal\Database\factories\RefereeFactory::new();
    }
}
