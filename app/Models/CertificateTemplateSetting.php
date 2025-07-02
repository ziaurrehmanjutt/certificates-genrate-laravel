<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificateTemplateSetting extends Model
{
    protected $fillable = [
        'template_id',
        'setting_key',
        'setting_value'
    ];
}
