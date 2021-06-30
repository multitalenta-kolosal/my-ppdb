<?php

namespace Modules\Registrant\Entities;

use App\Models\BaseModel;
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
