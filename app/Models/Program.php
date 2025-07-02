<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{

    protected $fillable = ['name', 'description'];
    public function classSections()
    {
        return $this->hasMany(ClassSection::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
