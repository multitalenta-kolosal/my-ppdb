<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Userprofile extends BaseModel
{
    use SoftDeletes;
    
    protected $dates = [
        'date_of_birth',
        'last_login',
        'email_verified_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
