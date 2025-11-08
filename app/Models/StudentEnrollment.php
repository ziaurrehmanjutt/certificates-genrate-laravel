<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentEnrollment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'student_id',
        'program_id',
        'class_id',
        'roll_no',
        'registration_no',
        'admission_date',
        'graduation_date',
        'status',
        'certificate_status',
        'certificate_issued_date',
        'certificate_number',
        'cgpa',
        'grade',
        'remarks'
    ];

    protected $casts = [
        'admission_date' => 'date',
        'graduation_date' => 'date',
        'certificate_issued_date' => 'date',
        'cgpa' => 'decimal:2',
    ];

    /**
     * Get the student for this enrollment
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the program for this enrollment
     */
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Get the class section for this enrollment
     */
    public function classSection()
    {
        return $this->belongsTo(ClassSection::class, 'class_id');
    }

    /**
     * Scope for active enrollments
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['admitted', 'active']);
    }

    /**
     * Scope for passed out students
     */
    public function scopePassedOut($query)
    {
        return $query->where('status', 'passed_out');
    }

    /**
     * Scope for pending certificates
     */
    public function scopePendingCertificate($query)
    {
        return $query->where('certificate_status', 'pending');
    }

    /**
     * Scope for generated certificates
     */
    public function scopeGeneratedCertificate($query)
    {
        return $query->where('certificate_status', 'generated');
    }

    /**
     * Scope for issued certificates
     */
    public function scopeIssuedCertificate($query)
    {
        return $query->where('certificate_status', 'issued');
    }

    /**
     * Check if certificate is generated
     */
    public function hasCertificate()
    {
        return in_array($this->certificate_status, ['generated', 'issued']);
    }

    /**
     * Check if enrollment is active
     */
    public function isActive()
    {
        return in_array($this->status, ['admitted', 'active']);
    }

    /**
     * Get full student name through relationship
     */
    public function getStudentFullNameAttribute()
    {
        return $this->student ? $this->student->full_name : '';
    }
}
