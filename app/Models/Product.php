<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    //

    use SoftDeletes;

    public function getFixPrice(){

        return $this->salePrice > 0 ? $this->salePrice : $this->price;

    }
}
