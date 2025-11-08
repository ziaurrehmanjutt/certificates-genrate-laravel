<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Program;
use App\Models\ClassSection;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StudentController extends Controller
{
    /**
     * Display a listing of students
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Student::with(['enrollments.program', 'enrollments.classSection']);

            // Apply filters
            if ($request->filled('email')) {
                $query->where('email', 'like', '%' . $request->email . '%');
            }

            if ($request->filled('name')) {
                $search = $request->name;
                $query->where(function($q) use ($search) {
                    $q->where('first_name', 'like', '%' . $search . '%')
                      ->orWhere('last_name', 'like', '%' . $search . '%')
                      ->orWhere('middle_name', 'like', '%' . $search . '%');
                });
            }

            if ($request->filled('cnic')) {
                $query->where('cnic', 'like', '%' . $request->cnic . '%');
            }

            if ($request->filled('gender')) {
                $query->where('gender', $request->gender);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('full_name', function ($student) {
                    return $student->full_name;
                })
                ->addColumn('enrollments_count', function ($student) {
                    return $student->enrollments->count();
                })
                ->addColumn('active_programs', function ($student) {
                    $activeEnrollments = $student->enrollments->whereIn('status', ['admitted', 'active']);
                    return $activeEnrollments->map(function($enrollment) {
                        return $enrollment->program ? $enrollment->program->name : '-';
                    })->implode(', ') ?: '-';
                })
                ->addColumn('action', function ($student) {
                    $editBtn = '<a href="' . route('admin.students.edit', $student->id) . '" class="btn btn-sm btn-primary btn-icon-text"><i class="mdi mdi-pencil btn-icon-prepend"></i> Edit</a>';
                    $viewBtn = '<a href="' . route('admin.students.show', $student->id) . '" class="btn btn-sm btn-info btn-icon-text"><i class="mdi mdi-eye btn-icon-prepend"></i> View</a>';
                    $deleteBtn = '<button class="btn btn-sm btn-danger btn-icon-text delete-btn" data-id="' . $student->id . '"><i class="mdi mdi-delete btn-icon-prepend"></i> Delete</button>';

                    return '<div class="btn-group" role="group">' . $viewBtn . ' ' . $editBtn . ' ' . $deleteBtn . '</div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        // Get filter options
        $programs = Program::active()->get();
        $classSections = ClassSection::active()->get();

        return view('admin.students.index', compact('programs', 'classSections'));
    }

    /**
     * Show the form for creating a new student
     */
    public function create()
    {
        // Will implement later
        return view('admin.students.create');
    }

    /**
     * Store a newly created student
     */
    public function store(Request $request)
    {
        // Will implement later
    }

    /**
     * Display the specified student
     */
    public function show(Student $student)
    {
        // Will implement later
        return view('admin.students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified student
     */
    public function edit(Student $student)
    {
        // Will implement later
        return view('admin.students.edit', compact('student'));
    }

    /**
     * Update the specified student
     */
    public function update(Request $request, Student $student)
    {
        // Will implement later
    }

    /**
     * Remove the specified student
     */
    public function destroy(Student $student)
    {
        // Will implement later
        $student->delete();
        return response()->json(['success' => true, 'message' => 'Student deleted successfully']);
    }
}

