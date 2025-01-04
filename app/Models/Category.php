<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'parent_id', 'description', 'image'];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function getParentCategoryNameAttribute()
    {
        return $this->parent ? $this->parent->name : null;
    }

    public function serviceCategories()
    {
        return $this->hasMany(ServiceCategories::class, 'category_id', 'id'); // category_id links to id in the categories table
    }
}
