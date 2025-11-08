<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'phone',
        'cnic',
        'dob',
        'gender',
        'profile_image',
        'address',
        'father_name',
        'mother_name',
        'remarks'
    ];

    protected $casts = [
        'dob' => 'date',
    ];

    /**
     * Get full name of the student
     */
    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name}");
    }

    /**
     * Get all enrollments for this student
     */
    public function enrollments()
    {
        return $this->hasMany(StudentEnrollment::class);
    }

    /**
     * Get active enrollments
     */
    public function activeEnrollments()
    {
        return $this->hasMany(StudentEnrollment::class)
                    ->whereIn('status', ['admitted', 'active']);
    }

    /**
     * Get programs through enrollments
     */
    public function programs()
    {
        return $this->belongsToMany(Program::class, 'student_enrollments')
                    ->withPivot(['roll_no', 'status', 'certificate_status', 'cgpa', 'grade'])
                    ->withTimestamps();
    }
}
