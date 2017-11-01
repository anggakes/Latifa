<?php
/**
 * Created by PhpStorm.
 * User: anggakes
 * Date: 10/31/17
 * Time: 5:41 PM
 */

namespace App\Models\Therapist;


use Jenssegers\Mongodb\Eloquent\Model;

class Settings extends Model
{

    protected $connection = 'mongodb';

    protected $fillable = ['userId'];
}