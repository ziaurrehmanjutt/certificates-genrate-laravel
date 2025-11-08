<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'duration_years',
        'level',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'duration_years' => 'integer',
    ];

    /**
     * Get all class sections for this program
     */
    public function classSections()
    {
        return $this->hasMany(ClassSection::class);
    }

    /**
     * Get all enrollments for this program
     */
    public function enrollments()
    {
        return $this->hasMany(StudentEnrollment::class);
    }

    /**
     * Get students through enrollments
     */
    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_enrollments')
                    ->withPivot(['roll_no', 'status', 'certificate_status', 'cgpa', 'grade', 'admission_date', 'graduation_date'])
                    ->withTimestamps();
    }

    /**
     * Scope for active programs
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
