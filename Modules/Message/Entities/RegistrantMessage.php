<?php

namespace Modules\Message\Entities;

use App\Models\BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Feed\FeedItem;

class RegistrantMessage extends BaseModel
{
    use HasFactory;
    use LogsActivity;
    use Notifiable;

    protected $table = 'registrant_messages';

    protected static $logName = 'registrant_messages';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['registrant_id'];

    public function registrant()
    {
        return $this->belongsTo('Modules\Registrant\Entities\Registrant','registrant_id','registrant_id')->ThisPeriod(my_period());
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Registrant\Database\Factories\RegistrantMessageFactory::new();
    }
}
