<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassSection extends Model
{
    protected $table = 'classes';


    protected $fillable = [
        'name',
        'program_id',
        'year'
    ];



    public function program()
    {
        return $this->belongsTo(Program::class);
    }
    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }
}
