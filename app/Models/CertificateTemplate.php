<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificateTemplate extends Model
{
    protected $fillable = [
        'name',
        'description',
        'background_image_path',
        'orientation',
        'font_family',
        'extra_config',
    ];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
        'extra_config' => 'array',
    ];
}
