<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{


    protected $fillable = [
        'certificate_no',
        'student_id',
        'template_id',
        'issued_date',
        'qr_code_path'
    ];
}
