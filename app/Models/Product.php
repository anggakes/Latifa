<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    //

    use SoftDeletes;

    public function getImageAttribute($value){
        return asset($value);
    }

    public function getFixPrice(){

        return $this->salePrice > 0 ? $this->salePrice : $this->price;

    }

    public function fromSku($sku){

        return $this->where('sku', $sku)->first();
    }
}
