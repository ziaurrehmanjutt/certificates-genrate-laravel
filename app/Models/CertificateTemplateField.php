<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificateTemplateField extends Model
{
    protected $fillable = [
        'template_id',
        'key',
        'label',
        'type',
        'default_value',
        'is_required',
        'help_text',
        'source_type',
        'source_key',
    ];

    protected $casts = [
        'label' => 'array',
        'help_text' => 'array',
        'default_value' => 'array',
    ];

    public function template()
    {
        return $this->belongsTo(CertificateTemplate::class, 'template_id');
    }
}
