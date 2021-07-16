<?php

namespace Modules\Registrant\Entities;

use App\Models\BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Feed\FeedItem;

class RegistrantStage extends BaseModel
{
    use HasFactory;
    use LogsActivity;
    use Notifiable;

    protected $table = 'registrant_stages';

    protected static $logName = 'registrant_stages';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['registrant_id'];

    public function registrant()
    {
        return $this->belongsTo('Modules\Registrant\Entities\RegistrantStage');
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Registrant\Database\Factories\RegistrantStageFactory::new();
    }
}
