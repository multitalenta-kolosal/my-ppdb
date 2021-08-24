<?php

namespace Modules\Finance\Entities;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Installment extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "installments";

    protected static $logName = 'installments';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['name', 'id'];
    
    public function registrants()
    {
        return $this->hasMany('Modules\Registrant\Entities\Registrant');
    }

    public function tier()
    {
        return $this->hasMany('Modules\Finance\Entities\Installment');
    }

    protected static function newFactory()
    {
        return \Modules\Finance\Database\factories\InstallmentFactory::new();
    }
}
