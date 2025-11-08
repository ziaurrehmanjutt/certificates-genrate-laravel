<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Program;
use App\Models\ClassSection;
use App\Models\StudentEnrollment;
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
        // Backend validation
        $validated = $request->validate([
            'first_name' => 'required|string|min:2|max:100',
            'middle_name' => 'nullable|string|max:100',
            'last_name' => 'required|string|min:2|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'nullable|string|min:11|max:20',
            'cnic' => 'nullable|string|size:15|unique:students,cnic',
            'dob' => 'nullable|date|before:today',
            'gender' => 'required|in:male,female,other',
            'profile_image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'father_name' => 'nullable|string|max:150',
            'mother_name' => 'nullable|string|max:150',
            'address' => 'nullable|string|max:500',
            'remarks' => 'nullable|string|max:1000',
        ], [
            'first_name.required' => 'First name is required',
            'first_name.min' => 'First name must be at least 2 characters',
            'first_name.max' => 'First name cannot exceed 100 characters',
            'last_name.required' => 'Last name is required',
            'last_name.min' => 'Last name must be at least 2 characters',
            'last_name.max' => 'Last name cannot exceed 100 characters',
            'email.required' => 'Email address is required',
            'email.email' => 'Please provide a valid email address',
            'email.max' => 'Email cannot exceed 150 characters',
            'phone.min' => 'Phone number must be at least 11 digits',
            'cnic.size' => 'CNIC must be in format: XXXXX-XXXXXXX-X',
            'cnic.unique' => 'This CNIC is already registered',
            'dob.date' => 'Please provide a valid date of birth',
            'dob.before' => 'Date of birth must be before today',
            'gender.required' => 'Gender is required',
            'gender.in' => 'Please select a valid gender',
            'profile_image.image' => 'Profile image must be an image file',
            'profile_image.mimes' => 'Profile image must be jpeg, jpg, png, or gif',
            'profile_image.max' => 'Profile image size cannot exceed 2MB',
        ]);

        try {
            // Handle profile image upload
            if ($request->hasFile('profile_image')) {
                $image = $request->file('profile_image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/students'), $imageName);
                $validated['profile_image'] = 'uploads/students/' . $imageName;
            }

            // Create student
            $student = Student::create($validated);

            // Redirect with success message
            return redirect()
                ->route('admin.students.index')
                ->with('success', 'Student added successfully! Student ID: ' . $student->id);

        } catch (\Exception $e) {
            // If there's an error, delete uploaded image if exists
            if (isset($validated['profile_image']) && file_exists(public_path($validated['profile_image']))) {
                unlink(public_path($validated['profile_image']));
            }

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to add student: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified student
     */
    public function show(Student $student)
    {
        $student->load(['enrollments.program', 'enrollments.classSection']);
        $programs = Program::active()->get();
        $classSections = ClassSection::active()->get();

        return view('admin.students.show', compact('student', 'programs', 'classSections'));
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

    /**
     * Store a new enrollment for the student
     */
    public function storeEnrollment(Request $request, Student $student)
    {
        $validated = $request->validate([
            'program_id' => 'required|exists:programs,id',
            'class_id' => 'nullable|exists:class_sections,id',
            'roll_no' => 'required|string|unique:student_enrollments,roll_no|max:255',
            'registration_no' => 'nullable|string|unique:student_enrollments,registration_no|max:255',
            'admission_date' => 'required|date',
            'status' => 'required|in:admitted,active,passed_out,dropped,expelled,transferred',
        ], [
            'program_id.required' => 'Please select a program',
            'program_id.exists' => 'Selected program does not exist',
            'class_id.exists' => 'Selected class/section does not exist',
            'roll_no.required' => 'Roll number is required',
            'roll_no.unique' => 'This roll number is already assigned',
            'registration_no.unique' => 'This registration number is already assigned',
            'admission_date.required' => 'Admission date is required',
            'admission_date.date' => 'Please provide a valid admission date',
            'status.required' => 'Status is required',
        ]);

        try {
            // Check if student is already enrolled in this program
            $existingEnrollment = StudentEnrollment::where('student_id', $student->id)
                ->where('program_id', $validated['program_id'])
                ->whereNull('deleted_at')
                ->first();

            if ($existingEnrollment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Student is already enrolled in this program!'
                ], 422);
            }

            $validated['student_id'] = $student->id;
            $enrollment = StudentEnrollment::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Enrollment added successfully!',
                'enrollment' => $enrollment->load(['program', 'classSection'])
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add enrollment: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete an enrollment
     */
    public function destroyEnrollment(Student $student, StudentEnrollment $enrollment)
    {
        if ($enrollment->student_id != $student->id) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid enrollment'
            ], 403);
        }

        $enrollment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Enrollment deleted successfully'
        ]);
    }
}

