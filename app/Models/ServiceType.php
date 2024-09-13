<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    use HasFactory;

    public static function get_service_type_name($id){
        return self::where('id',$id)->value('name');
    }
}
