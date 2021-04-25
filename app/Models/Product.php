<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use willvincent\Rateable\Rateable;

class Product extends Model
{
    use HasFactory, Rateable;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'img_path'
    ];

    protected $guarded = [];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product')->withPivot('category_id');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
}
