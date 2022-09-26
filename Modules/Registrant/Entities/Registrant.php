<?php

namespace Modules\Registrant\Entities;

use App\Models\BaseModel;
use Modules\Core\Entities\Period;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Feed\FeedItem;

class Registrant extends BaseModel
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;
    use Notifiable;

    protected $table = 'registrants';

    protected static $logName = 'registrants';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['name', 'registrant_id'];

    
    public function unit()
    {
        return $this->belongsTo('Modules\Core\Entities\Unit','unit_id')
        ->withDefault([
            'name' => ''
        ]);;
    }

    
    public function path()
    {
        return $this->belongsTo('Modules\Core\Entities\Path','type')
        ->withDefault([
            'name' => ''
        ]);;
    }

    public function period()
    {
        return $this->belongsTo('Modules\Core\Entities\Period','period_id')
        ->withDefault([
            'period_name' => ''
        ]);;
    }

    public function tier()
    {
        return $this->belongsTo('Modules\Core\Entities\Tier','tier_id')
                ->withDefault([
                    'tier_name' => ''
                ]);
    }

    public function registrant_stage()
    {
        return $this->hasOne('Modules\Registrant\Entities\RegistrantStage', 'id', 'progress_id')
        ->withDefault([
            'status_id' => ''
        ]);;
    }

    public function registrant_message()
    {
        return $this->hasOne('Modules\Message\Entities\RegistrantMessage', 'registrant_id', 'registrant_id');
    }

    public function scopeThisPeriod($query, $value = null){
        if($value){
            return $query->where('period_id', $value);
        }else{
            return $query->where('period_id', Period::findActivePeriodId());
        }
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Registrant\Database\Factories\RegistrantFactory::new();
    }
}
