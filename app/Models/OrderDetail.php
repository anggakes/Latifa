<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    //

    protected $fillable = ['price', 'name', 'sku'];
    protected $hidden = ['created_at', 'updated_at', 'order_id'];


    public function product(){

        return $this->belongsTo(Product::class);
    }

}
