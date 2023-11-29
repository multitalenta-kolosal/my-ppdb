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
        return $this->belongsTo('Modules\Core\Entities\Unit','unit_id');
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

        // $school_fee_group = ["KB/TK", "SD"];

        $composed_string= "1. Sumbangan Pengembangan Mutu (SPM): ".$this->scheme_string." (sudah termasuk SPP bulan Juli:  Rp 550.000,00)";
       
        return $composed_string;
    }

    public function concluseFeeByType($type, $isPersonal = false){
        $fee_type = $type;

        if($type == "spm"){
            $fee_type = 'school_fee';

            if($isPersonal){
                return $this->scheme_amount;
            }
        }

        if($this->unit->have_major){
            $fee = $this->tier->$fee_type ?? $this->unit->$fee_type;
        }else{
            $fee = $this->unit->$fee_type;
        }

        return $fee;
    }


    public function compose_verify_offline($registrant){

        $school_offline_group = ["SD"];

        if(in_array($registrant->unit->name, $school_offline_group)){
            $composed_string= "Setelah melakukan pembayaran biaya pendaftaran, segera hubungi admin kami di chat ini untuk informasi mengenai verifikasi kelengkapan berkas ";
        }else{
            $composed_string= "Setelah melakukan pembayaran biaya pendaftaran, kamu bisa upload/unggah bukti pembayaran dan kelengkapan berkas secara online melalui ".$registrant->unit->registration_veriform_link;
        }

        return $composed_string;
    }

    public function getFormattedPhoneParentAttribute()
    {
        $phone = $this->phone;
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }else if (substr($phone, 0, 1) === '+') {
            $phone = substr($phone, 1);
        }
        return $phone;
    }

    public function getFormattedPhoneChildAttribute()
    {
        $phone = $this->phone2;
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }else if (substr($phone, 0, 1) === '+') {
            $phone = substr($phone, 1);
        }
        return $phone;
    }
}
