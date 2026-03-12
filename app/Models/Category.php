<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'parent_id'];

    // This allows us to see the "Parent" of a subcategory
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // This allows us to see all "Subcategories" inside a parent
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}