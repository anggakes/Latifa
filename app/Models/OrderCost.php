<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderCost extends Model
{
    //
    protected $fillable = [
        'label', 'value', 'note'
    ];

    protected $hidden = ['created_at', 'updated_at', 'order_id'];
}
