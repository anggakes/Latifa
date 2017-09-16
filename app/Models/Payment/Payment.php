<?php
/**
 * Created by PhpStorm.
 * User: anggakes
 * Date: 9/9/17
 * Time: 6:58 PM
 */

namespace App\Models\Payment;

use Jenssegers\Mongodb\Eloquent\Model;

class Payment extends Model
{

    protected $connection = 'mongodb';

    protected $table = 'payment';

}