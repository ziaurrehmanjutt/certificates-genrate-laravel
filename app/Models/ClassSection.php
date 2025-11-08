<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassSection extends Model
{
    protected $fillable = [
        'name',
        'program_id',
        'session',
        'year',
        'semester',
        'start_date',
        'end_date',
        'is_active'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'year' => 'integer',
    ];

    /**
     * Get the program this class section belongs to
     */
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Get all enrollments for this class section
     */
    public function enrollments()
    {
        return $this->hasMany(StudentEnrollment::class, 'class_id');
    }

    /**
     * Get students in this class section
     */
    public function students()
    {
        return $this->hasManyThrough(Student::class, StudentEnrollment::class, 'class_id', 'id', 'id', 'student_id');
    }

    /**
     * Scope for active class sections
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for a specific session
     */
    public function scopeSession($query, $session)
    {
        return $query->where('session', $session);
    }
}
