<?php
/**
 * Created by PhpStorm.
 * User: anggakes
 * Date: 11/1/17
 * Time: 2:17 PM
 */

namespace App\Models\Therapist;


use Jenssegers\Mongodb\Eloquent\Model;

class CurrentLocation extends Model
{

    protected $connection = 'mongodb';

    protected $fillable = ['userId'];
}