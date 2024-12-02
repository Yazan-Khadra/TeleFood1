<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Store extends Model{
    use Searchable;
    protected $fillable=[
        'name',
        'description',
        'image_url',
        'category_id',
        'rate',
    ];
    public function Location(){
        return $this->hasMany(StoreGovernorate::class,'store_id');
    }
    public function Products(){
        return $this->hasMany(Product::class);
    }
    //when you create categories table please uncomment this method
    public function Category(){
        return $this->belongsTo(Category::class);
    }
   
}
