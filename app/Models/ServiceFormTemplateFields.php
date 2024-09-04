<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceFormTemplateFields extends Model
{
    use HasFactory;

    protected $table = "service_form_templates_fields";
    protected $primaryKey = "id";
}
