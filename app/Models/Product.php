<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * This tells Laravel it's safe to save these specific fields into MySQL.
     */
    protected $fillable = [
        'name',
        'category_id',
        'subcategory_id',
        'price',
        'description',
        'image',
    ];

    /**
     * Relationship: A product belongs to a Category.
     * This allows us to show the category name on the dashboard.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}