<?php
/**
 * Created by PhpStorm.
 * User: anggakes
 * Date: 9/9/17
 * Time: 1:58 PM
 */

namespace App\Models\Payment;

use Illuminate\Database\Eloquent\Model;

class PaymentRoute extends Model
{

    protected $table = 'payment_route';

    protected $fillable = ['channel_key', 'channel_class', 'channel_type'];

}