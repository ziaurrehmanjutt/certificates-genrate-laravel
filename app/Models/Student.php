<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{


    protected $fillable = [
        'name',
        'roll_no',
        'program_id',
        'class_id',
        'cnic',
        'dob'
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function classSection()
    {
        return $this->belongsTo(ClassSection::class, 'class_id');
    }
}
