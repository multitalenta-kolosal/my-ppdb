<?php

namespace Modules\Registrant\Entities;

use App\Models\BaseModel;
use Modules\Core\Entities\Period;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
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

    public function compose_tuition_fee($registrant){

        $school_fee_group = ["KB/TK", "SD"];

        if(in_array($registrant->unit->name, $school_fee_group)){
            $composed_string= "1. Uang Masuk Rp. ". number_format($registrant->unit->school_fee , 2, ',', '.')."\n2. SPP bulan Juli 2022 Rp. ". number_format($registrant->unit->spp , 2, ',', '.');
        }else{
            $composed_string= "1. Dana Pendidikan Rp. ". number_format($registrant->unit->dp , 2, ',', '.')."\n2. Dana Penunjang Pendidikan Rp. ". number_format($registrant->unit->dpp , 2, ',', '.')."\n3. SPP bulan Juli 2022 Rp. ". number_format($registrant->unit->spp , 2, ',', '.');
        }

        return $composed_string;
    }
}
