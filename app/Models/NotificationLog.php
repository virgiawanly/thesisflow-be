<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationLog extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'notification_log';

    /**
     * The attributes that are mass assignable.
     * 
     * @var array<int, string>
     */
    protected $fillable = [
        'user_ref',
        'channel',
        'title',
        'message',
    ];
}
