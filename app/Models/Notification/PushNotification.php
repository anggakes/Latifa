<?php
/**
 * Created by PhpStorm.
 * User: anggakes
 * Date: 10/22/17
 * Time: 4:57 PM
 */

namespace App\Models\Notification;

use Jenssegers\Mongodb\Eloquent\Model;

/**
 * Class PushNotification
 * @package App\Models\Notification
 *
 * @property userId
 */

class PushNotification extends Model
{

    protected $connection = 'mongodb';


    protected $fillable = [
        'userId',
        'role',
        'playerId',
        'deviceName',
        'deviceId',
    ];
}