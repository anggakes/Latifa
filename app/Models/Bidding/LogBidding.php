<?php
/**
 * Created by PhpStorm.
 * User: anggakes
 * Date: 11/1/17
 * Time: 2:41 PM
 */

namespace App\Models\Bidding;


use Jenssegers\Mongodb\Eloquent\Model;

class LogBidding extends Model
{

    protected $connection = 'mongodb';

    protected $fillable = [
        'therapist_id',
        'invoice_number',
        'response'
    ];

}