<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCategories extends Model
{
    use HasFactory;

    protected $fillable = [
        'services_id',
        'category_id',
    ];

    public function services()
    {
        return $this->belongsTo(Service::class, 'services_id', 'id');
    }
    public function categories()
    {
        return $this->belongsTo(Categories::class, 'category_id', 'id');
    }
}
