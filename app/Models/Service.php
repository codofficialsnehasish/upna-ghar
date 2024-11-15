<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $table = "services";
    protected $primaryKey = "id";

    public function bookings()
    {
        return $this->hasOne(ServiceBook::class,);
    }

    public function service_subcategories()
    {
        return $this->hasMany(ServiceCategories::class, 'services_id', 'id');
    }
}
