<?php
/**
 * Created by PhpStorm.
 * User: anggakes
 * Date: 10/15/17
 * Time: 6:14 PM
 */

namespace App\Models\Bidding;


use Jenssegers\Mongodb\Eloquent\Model;

class Offer extends Model
{

    protected $connection = "mongodb";
    protected $table = 'offers';

    protected $fillable = [
        'therapist_id',
        'offer'
    ];

}