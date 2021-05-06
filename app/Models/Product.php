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
        'img_path',
        'category_id',
    ];

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class, 'id');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
}
