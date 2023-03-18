<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Image;


class Product extends Model
{
    use HasFactory;
    protected $guard=[];
    // public $timestamps = false;


    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function images() 
    {          
     return $this->hasMany(Image::class);        
    }
}
