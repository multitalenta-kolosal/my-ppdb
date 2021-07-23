<?php

namespace Modules\Message\Entities;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends BaseModel
{
    use HasFactory;

    protected $table = "messages";

    protected static $logName = 'messages';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['name', 'id'];

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Message\Database\factories\MessageFactory::new();
    }
}
