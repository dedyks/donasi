<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Cmgmyr\Messenger\Models\Thread;
use Cmgmyr\Messenger\Traits\Messagable;

class NotificationLog extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'notification_log';

    protected $fillable = [
        
        'user_id',
        'artikel_id',
        'artikel_data',
        'user_data',
        'content',
        'title',
        'body',
        'message',
        'type',
        'category',
        'read',
        ];

    protected $dates = [
        'deleted_at',
    ];
 
    public $timestamps = true;
}
