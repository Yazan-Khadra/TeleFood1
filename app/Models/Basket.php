<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    protected $fillable=['user_id','product_id','size',
                        'description','quantity','total_price'];
}
