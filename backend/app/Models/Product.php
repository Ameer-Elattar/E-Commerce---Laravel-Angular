<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'description',
        'price',
        'image',
        'stock', 
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return url('images/products/' . $this->image);
    }
    


    function cart(){
        return $this->hasMany(Cart::class);
    }
}
