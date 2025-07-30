<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentDynamicField extends Model
{
    protected $fillable = [
        'label',
        'key',
        'type',
        'options',
        'default_value',
        'help_text',
        'is_required',
    ];

    protected $casts = [
        'label' => 'array',
        'options' => 'array',
        'help_text' => 'array',
        'is_required' => 'boolean',
    ];
}
